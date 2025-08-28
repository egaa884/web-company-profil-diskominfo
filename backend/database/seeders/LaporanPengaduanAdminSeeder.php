<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaporanPengaduanAdmin;
use App\Models\Admin;

class LaporanPengaduanAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin or create one if none exists
        $admin = Admin::first();
        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Admin Diskominfo',
                'email' => 'admin@diskominfo.madiunkota.go.id',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
        }

        $reports = [
            [
                'judul' => 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Juni Tahun 2025',
                'deskripsi' => 'Laporan bulanan pengaduan pelayanan publik yang berisi data statistik dan analisis pengaduan yang diterima selama bulan Juni 2025. Laporan ini mencakup berbagai kategori pengaduan termasuk pelayanan publik, infrastruktur, administrasi, dan lainnya.',
                'bulan' => 'Juni',
                'tahun' => 2025,
                'kategori' => 'Laporan Pengaduan Pelayanan Publik',
                'ringkasan' => 'Total pengaduan yang diterima pada bulan Juni 2025 sebanyak 45 pengaduan dengan tingkat penyelesaian mencapai 89%.',
                'total_pengaduan' => 45,
                'pengaduan_diproses' => 3,
                'pengaduan_selesai' => 40,
                'pengaduan_ditolak' => 2,
                'catatan_admin' => 'Laporan bulanan pengaduan pelayanan publik Diskominfo Kota Madiun untuk bulan Juni 2025.',
                'is_published' => true,
                'tanggal_publikasi' => now(),
            ],
            [
                'judul' => 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Mei Tahun 2025',
                'deskripsi' => 'Laporan bulanan pengaduan pelayanan publik yang berisi data statistik dan analisis pengaduan yang diterima selama bulan Mei 2025. Laporan ini mencakup berbagai kategori pengaduan termasuk pelayanan publik, infrastruktur, administrasi, dan lainnya.',
                'bulan' => 'Mei',
                'tahun' => 2025,
                'kategori' => 'Laporan Pengaduan Pelayanan Publik',
                'ringkasan' => 'Total pengaduan yang diterima pada bulan Mei 2025 sebanyak 38 pengaduan dengan tingkat penyelesaian mencapai 92%.',
                'total_pengaduan' => 38,
                'pengaduan_diproses' => 2,
                'pengaduan_selesai' => 35,
                'pengaduan_ditolak' => 1,
                'catatan_admin' => 'Laporan bulanan pengaduan pelayanan publik Diskominfo Kota Madiun untuk bulan Mei 2025.',
                'is_published' => true,
                'tanggal_publikasi' => now()->subDays(30),
            ],
            [
                'judul' => 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan April Tahun 2025',
                'deskripsi' => 'Laporan bulanan pengaduan pelayanan publik yang berisi data statistik dan analisis pengaduan yang diterima selama bulan April 2025. Laporan ini mencakup berbagai kategori pengaduan termasuk pelayanan publik, infrastruktur, administrasi, dan lainnya.',
                'bulan' => 'April',
                'tahun' => 2025,
                'kategori' => 'Laporan Pengaduan Pelayanan Publik',
                'ringkasan' => 'Total pengaduan yang diterima pada bulan April 2025 sebanyak 42 pengaduan dengan tingkat penyelesaian mencapai 88%.',
                'total_pengaduan' => 42,
                'pengaduan_diproses' => 4,
                'pengaduan_selesai' => 37,
                'pengaduan_ditolak' => 1,
                'catatan_admin' => 'Laporan bulanan pengaduan pelayanan publik Diskominfo Kota Madiun untuk bulan April 2025.',
                'is_published' => true,
                'tanggal_publikasi' => now()->subDays(60),
            ],
            [
                'judul' => 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Maret Tahun 2025',
                'deskripsi' => 'Laporan bulanan pengaduan pelayanan publik yang berisi data statistik dan analisis pengaduan yang diterima selama bulan Maret 2025. Laporan ini mencakup berbagai kategori pengaduan termasuk pelayanan publik, infrastruktur, administrasi, dan lainnya.',
                'bulan' => 'Maret',
                'tahun' => 2025,
                'kategori' => 'Laporan Pengaduan Pelayanan Publik',
                'ringkasan' => 'Total pengaduan yang diterima pada bulan Maret 2025 sebanyak 35 pengaduan dengan tingkat penyelesaian mencapai 91%.',
                'total_pengaduan' => 35,
                'pengaduan_diproses' => 2,
                'pengaduan_selesai' => 32,
                'pengaduan_ditolak' => 1,
                'catatan_admin' => 'Laporan bulanan pengaduan pelayanan publik Diskominfo Kota Madiun untuk bulan Maret 2025.',
                'is_published' => true,
                'tanggal_publikasi' => now()->subDays(90),
            ],
            [
                'judul' => 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Februari Tahun 2025',
                'deskripsi' => 'Laporan bulanan pengaduan pelayanan publik yang berisi data statistik dan analisis pengaduan yang diterima selama bulan Februari 2025. Laporan ini mencakup berbagai kategori pengaduan termasuk pelayanan publik, infrastruktur, administrasi, dan lainnya.',
                'bulan' => 'Februari',
                'tahun' => 2025,
                'kategori' => 'Laporan Pengaduan Pelayanan Publik',
                'ringkasan' => 'Total pengaduan yang diterima pada bulan Februari 2025 sebanyak 28 pengaduan dengan tingkat penyelesaian mencapai 93%.',
                'total_pengaduan' => 28,
                'pengaduan_diproses' => 1,
                'pengaduan_selesai' => 26,
                'pengaduan_ditolak' => 1,
                'catatan_admin' => 'Laporan bulanan pengaduan pelayanan publik Diskominfo Kota Madiun untuk bulan Februari 2025.',
                'is_published' => true,
                'tanggal_publikasi' => now()->subDays(120),
            ],
        ];

        foreach ($reports as $report) {
            LaporanPengaduanAdmin::create([
                ...$report,
                'admin_id' => $admin->id,
            ]);
        }
    }
}
