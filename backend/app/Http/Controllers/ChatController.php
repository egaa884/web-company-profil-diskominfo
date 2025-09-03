<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Handle chat requests. This scaffold enforces category scope and returns
     * a safe response with a link to Awak Sigap for more details.
     */
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = trim($validated['message']);

        $allowedCategories = [
            'ppid' => 'PPID (Permohonan Data & Informasi Publik)',
            'aduan_konsultasi_hukum' => 'Aduan/Konsultasi Hukum',
            'kontribusi_berita' => 'Kontribusi Berita',
            'kekerasan_perempuan_anak' => 'Laporan Kekerasan pada Perempuan & Anak',
            'lapor_bapak' => 'Lapor Bapak',
            'insiden_keamanan_informasi' => 'Insiden Keamanan Informasi',
            'sp4n_lapor' => 'SP4N LAPOR',
            'pengaduan' => 'Pengaduan (pelayanan umum & darurat)',
            'aduan_konten_negatif' => 'Aduan Konten Negatif',
            'aduan_nomor_telepon' => 'Aduan Nomor Telepon',
            'aduan_nomor_rekening' => 'Aduan Nomor Rekening',
            'aduan_hoaks' => 'Aduan Hoaks',
        ];

        // Simple keyword-based category detection (placeholder for LLM classifier)
        $messageLower = mb_strtolower($message, 'UTF-8');
        $category = null;

        $keywords = [
            'ppid' => ['ppid', 'informasi publik', 'permohonan informasi'],
            'aduan_konsultasi_hukum' => ['hukum', 'konsultasi hukum', 'pengacara', 'legal'],
            'kontribusi_berita' => ['kontribusi berita', 'tulis berita', 'publikasi berita'],
            'kekerasan_perempuan_anak' => ['kekerasan', 'kdrt', 'perempuan', 'anak', 'kekerasan anak'],
            'lapor_bapak' => ['lapor bapak', 'walikota', 'wakil walikota'],
            'insiden_keamanan_informasi' => ['insiden keamanan', 'kebocoran data', 'keamanan informasi', 'csirt'],
            'sp4n_lapor' => ['sp4n', 'lapor.go.id', 'sp4n lapor'],
            'pengaduan' => ['pengaduan', 'lapor', 'keluhan', 'darurat'],
            'aduan_konten_negatif' => ['konten negatif', 'akun palsu', 'url negatif', 'website negatif'],
            'aduan_nomor_telepon' => ['nomor telepon', 'telepon penipuan', 'spam call'],
            'aduan_nomor_rekening' => ['nomor rekening', 'rekening penipuan', 'bank penipuan'],
            'aduan_hoaks' => ['hoaks', 'hoax', 'cek berita', 'klarifikasi informasi'],
        ];

        foreach ($keywords as $key => $list) {
            foreach ($list as $kw) {
                if (mb_strpos($messageLower, $kw) !== false) {
                    $category = $key;
                    break 2;
                }
            }
        }

        // Compose system prompt and call OpenAI to answer in Indonesian, scoped to categories
        $systemPrompt = "Anda adalah asisten AI untuk Pengaduan Awak Sigap Kota Madiun. Jawab SELALU dalam bahasa Indonesia. Jawab hanya jika pertanyaan terkait kategori berikut: PPID, Aduan/Konsultasi Hukum, Kontribusi Berita, Laporan Kekerasan pada Perempuan & Anak, Lapor Bapak, Insiden Keamanan Informasi, SP4N LAPOR, Pengaduan (pelayanan umum & darurat), Aduan Konten Negatif, Aduan Nomor Telepon, Aduan Nomor Rekening, dan Aduan Hoaks. Jika di luar itu, tolak dengan sopan dan arahkan pengguna untuk bertanya dalam kategori yang didukung. Jika relevan, sarankan mengunjungi situs Awak Sigap (https://awaksigap.madiunkota.go.id/) untuk rincian lebih lanjut.";

        // If no category matched, enforce refusal via assistant content directly without LLM
        if ($category === null) {
            return response()->json([
                'reply' => 'Maaf, saya hanya dapat membantu topik terkait PPID, Aduan/Konsultasi Hukum, Kontribusi Berita, Laporan Kekerasan pada Perempuan & Anak, Lapor Bapak, Insiden Keamanan Informasi, SP4N LAPOR, Pengaduan, Aduan Konten Negatif, Aduan Nomor Telepon, Aduan Nomor Rekening, dan Aduan Hoaks. Silakan ajukan pertanyaan dalam salah satu kategori tersebut. Untuk informasi lebih lanjut, kunjungi situs Awak Sigap: https://awaksigap.madiunkota.go.id/',
                'category' => null,
            ]);
        }

        $categoryLabel = $allowedCategories[$category] ?? 'Kategori terkait';

        $userPrompt = "Kategori terdeteksi: {$categoryLabel}. Pertanyaan pengguna: \n\n".$message;

        try {
            $apiKey = config('services.openai.api_key');
            $baseUrl = rtrim(config('services.openai.base_url'), '/');
            $model = config('services.openai.model', 'gpt-4o-mini');
            $timeout = (int) config('services.openai.timeout', 60);

            if (!$apiKey) {
                return response()->json([
                    'reply' => 'Konfigurasi OpenAI belum disetel. Hubungi administrator untuk mengatur OPENAI_API_KEY.',
                    'category' => $category,
                ], 500);
            }

            $basePayload = [
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'temperature' => 0.2,
            ];

            $modelsToTry = array_values(array_unique([
                $model,
                'gpt-4o-mini',
                'gpt-4o-mini-2024-07-18',
                'gpt-3.5-turbo',
            ]));

            $response = null;
            $lastError = null;
            foreach ($modelsToTry as $tryModel) {
                $payload = $basePayload;
                $payload['model'] = $tryModel;
                $response = Http::withHeaders([
                        'Authorization' => 'Bearer '.$apiKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->timeout($timeout)
                    ->post($baseUrl.'/chat/completions', $payload);

                if ($response->ok()) {
                    break; // success
                }

                $lastError = $response->json();
                $status = $response->status();
                $errMsg = is_array($lastError) ? ($lastError['error']['message'] ?? json_encode($lastError)) : (string) $response->body();
                Log::warning('OpenAI model failed', ['model' => $tryModel, 'status' => $status, 'error' => $errMsg]);
            }

            if (!$response || !$response->ok()) {
                $errorMsg = '';
                $status = $response ? $response->status() : null;
                if ($response) {
                    $body = $response->json();
                    $errorMsg = is_array($body) ? ($body['error']['message'] ?? json_encode($body)) : (string) $response->body();
                }

                // Graceful fallback content per category if quota/rate/billing issues occur
                $isQuotaOrBilling = $status === 429 || (is_string($errorMsg) && stripos($errorMsg, 'quota') !== false);
                if ($isQuotaOrBilling) {
                    $fallbackMap = [
                        'ppid' => 'Untuk mengajukan permohonan informasi publik (PPID), siapkan identitas pemohon dan rincian informasi yang dibutuhkan. Ajukan melalui kanal resmi yang disediakan Pemerintah Kota Madiun. Detail tata cara, formulir, dan SLA dapat Anda lihat di situs Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'aduan_konsultasi_hukum' => 'Untuk aduan/konsultasi hukum, tuliskan kronologi singkat dan dokumen pendukung. Ikuti arahan pada laman resmi. Rincian langkah tersedia di Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'kontribusi_berita' => 'Kontribusi Berita: siapkan naskah berita yang faktual dan dukungan media (foto/video) bila ada. Ketentuan dan tata cara unggah dapat dilihat di Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'kekerasan_perempuan_anak' => 'Laporan Kekerasan pada Perempuan & Anak: utamakan keselamatan pelapor/korban. Catat waktu, tempat, dan bukti. Untuk kanal pengaduan resmi dan pendampingan, rujuk Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'lapor_bapak' => 'Lapor Bapak: sampaikan keluhan/aspirasi secara ringkas dan jelas, sertakan lokasi dan bukti. Prosedur pengajuan tersedia di Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'insiden_keamanan_informasi' => 'Insiden Keamanan Informasi: segera dokumentasikan indikasi insiden (waktu, sistem terdampak, gejala), hindari menyebarkan data sensitif. Alur pelaporan CSIRT/keamanan ada di Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'sp4n_lapor' => 'SP4N LAPOR: gunakan akun SP4N untuk menyampaikan aspirasi/aduan layanan publik. Tautan dan panduan pelaporan tersedia via Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'pengaduan' => 'Pengaduan layanan umum & darurat: jelaskan permasalahan, lokasi, waktu, dan bukti pendukung agar tindak lanjut cepat. Panduan lengkap ada di Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'aduan_konten_negatif' => 'Aduan Konten Negatif: lampirkan URL/akun/jenis konten dan alasan keberatan. Cara melapor lengkap tersedia di Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'aduan_nomor_telepon' => 'Aduan Nomor Telepon (penipuan/spam): catat nomor, waktu kejadian, bentuk modus. Panduan pelaporan ada di Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'aduan_nomor_rekening' => 'Aduan Nomor Rekening mencurigakan: simpan bukti transfer/chat, nomor rekening, dan kronologi. Rujukan langkah pelaporan: Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                        'aduan_hoaks' => 'Aduan Hoaks: sertakan tautan atau tangkapan layar konten yang diduga hoaks untuk proses verifikasi. Panduan cek fakta dan klarifikasi: Awak Sigap: https://awaksigap.madiunkota.go.id/.',
                    ];

                    $fallback = $fallbackMap[$category] ?? 'Silakan rujuk prosedur resmi pada situs Awak Sigap: https://awaksigap.madiunkota.go.id/.';
                    return response()->json([
                        'reply' => $fallback,
                        'category' => $category,
                    ], 200);
                }

                $replyMsg = config('app.debug')
                    ? ('Maaf, layanan AI bermasalah: '.$errorMsg)
                    : 'Maaf, layanan AI sedang bermasalah. Silakan coba lagi nanti. Untuk informasi lebih lanjut, kunjungi: https://awaksigap.madiunkota.go.id/';
                return response()->json([
                    'reply' => $replyMsg,
                    'category' => $category,
                ], 502);
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                return response()->json([
                    'reply' => 'Maaf, saya tidak dapat menghasilkan jawaban saat ini. Silakan coba lagi nanti. Rujukan: https://awaksigap.madiunkota.go.id/',
                    'category' => $category,
                ], 502);
            }

            // Ensure we always add the site link for more details
            $suffix = "\n\nUntuk rincian lebih lengkap, silakan kunjungi situs resmi Awak Sigap: https://awaksigap.madiunkota.go.id/";
            if (!Str::contains($content, 'Awak Sigap')) {
                $content .= $suffix;
            }

            return response()->json([
                'reply' => $content,
                'category' => $category,
            ]);
        } catch (\Throwable $e) {
            Log::error('ChatController exception', ['error' => $e->getMessage()]);
            return response()->json([
                'reply' => 'Maaf, terjadi kesalahan saat memproses permintaan. Silakan coba lagi nanti. Rujukan: https://awaksigap.madiunkota.go.id/',
                'category' => $category,
            ], 500);
        }
    }
}


