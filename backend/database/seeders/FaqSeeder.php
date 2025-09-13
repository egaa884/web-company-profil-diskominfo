<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'title' => 'Layanan Publik',
                'question' => 'Bagaimana cara mengakses layanan publik di Dinas Komunikasi dan Informatika?',
                'answer' => 'Anda dapat mengakses layanan publik melalui website resmi kami atau datang langsung ke kantor Dinas Komunikasi dan Informatika Kota Madiun. Kami menyediakan berbagai layanan seperti pengaduan, informasi publik, dan layanan administrasi.',
            ],
            [
                'title' => 'Pengaduan',
                'question' => 'Bagaimana cara mengajukan pengaduan?',
                'answer' => 'Untuk mengajukan pengaduan, Anda dapat:\n1. Mengisi formulir pengaduan online melalui website kami\n2. Datang langsung ke kantor Dinas Komunikasi dan Informatika\n3. Menghubungi call center kami di nomor (0351) 123456\n\nPastikan menyertakan data lengkap dan bukti pendukung.',
            ],
            [
                'title' => 'Informasi Publik',
                'question' => 'Bagaimana cara mendapatkan informasi publik?',
                'answer' => 'Informasi publik dapat diperoleh melalui:\n- Website resmi Dinas Komunikasi dan Informatika\n- Layanan PPID (Pejabat Pengelola Informasi dan Dokumentasi)\n- Permohonan informasi secara tertulis\n\nKami berkomitmen untuk memberikan informasi yang akurat dan tepat waktu.',
            ],
            [
                'title' => 'Layanan Online',
                'question' => 'Apakah semua layanan tersedia secara online?',
                'answer' => 'Sebagian besar layanan kami sudah tersedia secara online melalui portal layanan kami. Namun, untuk layanan tertentu yang memerlukan verifikasi dokumen asli, Anda masih perlu datang langsung ke kantor.',
            ],
            [
                'title' => 'Waktu Layanan',
                'question' => 'Kapan jam operasional kantor?',
                'answer' => 'Jam operasional kantor Dinas Komunikasi dan Informatika Kota Madiun:\n- Senin - Kamis: 07.30 - 16.00 WIB\n- Jumat: 07.30 - 16.30 WIB\n- Sabtu: 07.30 - 14.00 WIB\n- Minggu dan hari libur nasional: Tutup\n\nUntuk layanan darurat, tersedia hotline 24 jam.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}