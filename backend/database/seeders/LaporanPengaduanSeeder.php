<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LaporanPengaduan;
use App\Models\Admin;

class LaporanPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::first();

        $categories = [
            'Pelayanan Publik',
            'Infrastruktur',
            'Administrasi',
            'Keamanan',
            'Kesehatan',
            'Pendidikan',
            'Transportasi',
            'Lingkungan',
        ];

        $statuses = ['pending', 'diproses', 'selesai', 'ditolak'];
        $priorities = ['rendah', 'normal', 'tinggi', 'kritis'];

        $sampleData = [
            [
                'judul' => 'Jalan Rusak di Kelurahan Kartoharjo',
                'deskripsi' => 'Jalan utama di Kelurahan Kartoharjo mengalami kerusakan parah yang mengganggu lalu lintas. Terdapat lubang-lubang besar yang berbahaya bagi pengendara.',
                'kategori_pengaduan' => 'Infrastruktur',
                'status' => 'diproses',
                'prioritas' => 'tinggi',
                'nama_pelapor' => 'Budi Santoso',
                'email_pelapor' => 'budi.santoso@email.com',
                'telepon_pelapor' => '081234567890',
                'alamat_pelapor' => 'Jl. Kartoharjo No. 45, Kota Madiun',
                'nik_pelapor' => '3573011234567890',
            ],
            [
                'judul' => 'Pelayanan Lambat di Kantor Dinas',
                'deskripsi' => 'Pelayanan di kantor dinas sangat lambat, antrian panjang dan tidak ada informasi yang jelas tentang estimasi waktu pelayanan.',
                'kategori_pengaduan' => 'Pelayanan Publik',
                'status' => 'selesai',
                'prioritas' => 'normal',
                'nama_pelapor' => 'Siti Nurhaliza',
                'email_pelapor' => 'siti.nurhaliza@email.com',
                'telepon_pelapor' => '081234567891',
                'alamat_pelapor' => 'Jl. Madiun No. 12, Kota Madiun',
                'nik_pelapor' => '3573011234567891',
                'catatan_admin' => 'Sudah ditangani dengan menambah petugas pelayanan dan sistem antrian digital.',
                'tanggal_selesai' => now()->subDays(5),
            ],
            [
                'judul' => 'Sampah Menumpuk di Taman Kota',
                'deskripsi' => 'Sampah menumpuk di taman kota selama 3 hari terakhir, mengganggu keindahan dan kebersihan lingkungan.',
                'kategori_pengaduan' => 'Lingkungan',
                'status' => 'pending',
                'prioritas' => 'normal',
                'nama_pelapor' => 'Ahmad Rizki',
                'email_pelapor' => 'ahmad.rizki@email.com',
                'telepon_pelapor' => '081234567892',
                'alamat_pelapor' => 'Jl. Taman No. 78, Kota Madiun',
                'nik_pelapor' => '3573011234567892',
            ],
            [
                'judul' => 'Lampu Jalan Mati di Malam Hari',
                'deskripsi' => 'Lampu jalan di Jl. Perintis Kemerdekaan mati total sejak 2 hari yang lalu, sangat gelap dan berbahaya untuk pengendara malam.',
                'kategori_pengaduan' => 'Infrastruktur',
                'status' => 'selesai',
                'prioritas' => 'kritis',
                'nama_pelapor' => 'Dewi Sartika',
                'email_pelapor' => 'dewi.sartika@email.com',
                'telepon_pelapor' => '081234567893',
                'alamat_pelapor' => 'Jl. Perintis Kemerdekaan No. 23, Kota Madiun',
                'nik_pelapor' => '3573011234567893',
                'catatan_admin' => 'Lampu sudah diperbaiki dan berfungsi normal kembali.',
                'tanggal_selesai' => now()->subDays(2),
            ],
            [
                'judul' => 'Kesulitan Mengurus Surat Keterangan',
                'deskripsi' => 'Saya mengalami kesulitan dalam mengurus surat keterangan domisili, petugas tidak memberikan informasi yang jelas.',
                'kategori_pengaduan' => 'Administrasi',
                'status' => 'diproses',
                'prioritas' => 'normal',
                'nama_pelapor' => 'Rina Marlina',
                'email_pelapor' => 'rina.marlina@email.com',
                'telepon_pelapor' => '081234567894',
                'alamat_pelapor' => 'Jl. Sudirman No. 67, Kota Madiun',
                'nik_pelapor' => '3573011234567894',
            ],
            [
                'judul' => 'Fasilitas Umum Tidak Terawat',
                'deskripsi' => 'Fasilitas umum di taman bermain anak tidak terawat dengan baik, beberapa alat bermain rusak dan berbahaya.',
                'kategori_pengaduan' => 'Infrastruktur',
                'status' => 'pending',
                'prioritas' => 'tinggi',
                'nama_pelapor' => 'Maya Indah',
                'email_pelapor' => 'maya.indah@email.com',
                'telepon_pelapor' => '081234567895',
                'alamat_pelapor' => 'Jl. Pahlawan No. 89, Kota Madiun',
                'nik_pelapor' => '3573011234567895',
            ],
            [
                'judul' => 'Pelayanan Kesehatan Lambat',
                'deskripsi' => 'Pelayanan di puskesmas sangat lambat, antrian panjang dan tidak ada sistem prioritas untuk pasien darurat.',
                'kategori_pengaduan' => 'Kesehatan',
                'status' => 'ditolak',
                'prioritas' => 'tinggi',
                'nama_pelapor' => 'Bambang Sutejo',
                'email_pelapor' => 'bambang.sutejo@email.com',
                'telepon_pelapor' => '081234567896',
                'alamat_pelapor' => 'Jl. Kesehatan No. 34, Kota Madiun',
                'nik_pelapor' => '3573011234567896',
                'catatan_admin' => 'Pengaduan ditolak karena sudah ada sistem prioritas yang berjalan dengan baik.',
            ],
            [
                'judul' => 'Transportasi Umum Tidak Tepat Waktu',
                'deskripsi' => 'Angkutan umum sering tidak tepat waktu, mengganggu jadwal kerja dan aktivitas masyarakat.',
                'kategori_pengaduan' => 'Transportasi',
                'status' => 'diproses',
                'prioritas' => 'normal',
                'nama_pelapor' => 'Eko Prasetyo',
                'email_pelapor' => 'eko.prasetyo@email.com',
                'telepon_pelapor' => '081234567897',
                'alamat_pelapor' => 'Jl. Transportasi No. 56, Kota Madiun',
                'nik_pelapor' => '3573011234567897',
            ],
        ];

        foreach ($sampleData as $data) {
            LaporanPengaduan::create(array_merge($data, [
                'admin_id' => $admin ? $admin->id : null,
                'tanggal_pengaduan' => now()->subDays(rand(1, 30)),
            ]));
        }

        // Create additional random data
        for ($i = 0; $i < 20; $i++) {
            LaporanPengaduan::create([
                'judul' => 'Pengaduan ' . ($i + 1) . ' - ' . fake()->sentence(3),
                'deskripsi' => fake()->paragraph(3),
                'kategori_pengaduan' => $categories[array_rand($categories)],
                'status' => $statuses[array_rand($statuses)],
                'prioritas' => $priorities[array_rand($priorities)],
                'nama_pelapor' => fake()->name(),
                'email_pelapor' => fake()->email(),
                'telepon_pelapor' => fake()->phoneNumber(),
                'alamat_pelapor' => fake()->address(),
                'nik_pelapor' => fake()->numerify('357301########'),
                'admin_id' => $admin ? $admin->id : null,
                'tanggal_pengaduan' => now()->subDays(rand(1, 60)),
                'tanggal_selesai' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
            ]);
        }
    }
} 