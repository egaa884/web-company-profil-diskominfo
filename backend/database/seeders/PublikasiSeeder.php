<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publikasi;
use Illuminate\Support\Str;

class PublikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for pengaduan category
        Publikasi::create([
            'judul' => 'Laporan Pengaduan Masyarakat Bulan Januari 2025',
            'slug' => Str::slug('Laporan Pengaduan Masyarakat Bulan Januari 2025'),
            'kategori' => 'pengaduan',
            'ringkasan' => 'Laporan pengaduan masyarakat yang diterima dan diproses oleh Diskominfo Kota Madiun pada bulan Januari 2025.',
            'isi' => 'Laporan ini memuat data pengaduan masyarakat yang diterima melalui berbagai kanal seperti pengaduan langsung, email, dan media sosial. Total pengaduan yang diterima sebanyak 45 laporan dengan rincian: 25 laporan selesai, 15 laporan sedang diproses, dan 5 laporan ditolak.',
            'file_path' => null,
            'published_at' => '2025-01-15 10:00:00',
            'is_published' => true,
            'meta' => [
                'bulan' => 'Januari',
                'status' => 'selesai',
                'total_pengaduan' => 45,
                'pengaduan_selesai' => 25,
                'pengaduan_diproses' => 15,
                'pengaduan_ditolak' => 5,
                'period' => 'Januari 2025'
            ]
        ]);

        Publikasi::create([
            'judul' => 'Laporan Pengaduan Masyarakat Bulan Februari 2025',
            'slug' => Str::slug('Laporan Pengaduan Masyarakat Bulan Februari 2025'),
            'kategori' => 'pengaduan',
            'ringkasan' => 'Laporan pengaduan masyarakat yang diterima dan diproses oleh Diskominfo Kota Madiun pada bulan Februari 2025.',
            'isi' => 'Laporan ini memuat data pengaduan masyarakat yang diterima melalui berbagai kanal seperti pengaduan langsung, email, dan media sosial. Total pengaduan yang diterima sebanyak 52 laporan dengan rincian: 30 laporan selesai, 18 laporan sedang diproses, dan 4 laporan ditolak.',
            'file_path' => null,
            'published_at' => '2025-02-15 10:00:00',
            'is_published' => true,
            'meta' => [
                'bulan' => 'Februari',
                'status' => 'selesai',
                'total_pengaduan' => 52,
                'pengaduan_selesai' => 30,
                'pengaduan_diproses' => 18,
                'pengaduan_ditolak' => 4,
                'period' => 'Februari 2025'
            ]
        ]);

        Publikasi::create([
            'judul' => 'Laporan Pengaduan Masyarakat Bulan Maret 2025',
            'slug' => Str::slug('Laporan Pengaduan Masyarakat Bulan Maret 2025'),
            'kategori' => 'pengaduan',
            'ringkasan' => 'Laporan pengaduan masyarakat yang diterima dan diproses oleh Diskominfo Kota Madiun pada bulan Maret 2025.',
            'isi' => 'Laporan ini memuat data pengaduan masyarakat yang diterima melalui berbagai kanal seperti pengaduan langsung, email, dan media sosial. Total pengaduan yang diterima sebanyak 48 laporan dengan rincian: 28 laporan selesai, 16 laporan sedang diproses, dan 4 laporan ditolak.',
            'file_path' => null,
            'published_at' => '2025-03-15 10:00:00',
            'is_published' => true,
            'meta' => [
                'bulan' => 'Maret',
                'status' => 'diproses',
                'total_pengaduan' => 48,
                'pengaduan_selesai' => 28,
                'pengaduan_diproses' => 16,
                'pengaduan_ditolak' => 4,
                'period' => 'Maret 2025'
            ]
        ]);

        // Sample data for penerima category
        Publikasi::create([
            'judul' => 'Laporan Penerimaan Barang Bulan Juni 2025',
            'slug' => Str::slug('Laporan Penerimaan Barang Bulan Juni 2025'),
            'kategori' => 'penerima',
            'ringkasan' => 'Ringkasan laporan penerimaan barang dan aset TI pada bulan Juni. Memuat daftar barang, jumlah, dan vendor terkait.',
            'isi' => 'Laporan ini memuat detail penerimaan barang dan aset TI yang diterima oleh Diskominfo Kota Madiun pada bulan Juni 2025. Barang yang diterima meliputi perangkat komputer, printer, dan perangkat jaringan dari berbagai vendor yang telah ditunjuk.',
            'file_path' => null,
            'published_at' => '2025-07-10 10:00:00',
            'is_published' => true,
            'meta' => [
                'jenis_barang' => 'Perangkat TI',
                'vendor' => 'PT Teknologi Maju',
                'total_barang' => 25
            ]
        ]);

        Publikasi::create([
            'judul' => 'Laporan Penerimaan Surat Masuk April-Juni 2025',
            'slug' => Str::slug('Laporan Penerimaan Surat Masuk April-Juni 2025'),
            'kategori' => 'penerima',
            'ringkasan' => 'Laporan triwulan mengenai jumlah surat masuk, kategori, dan tindak lanjut yang telah dilakukan oleh dinas.',
            'isi' => 'Laporan triwulan II tahun 2025 memuat data surat masuk yang diterima oleh Diskominfo Kota Madiun. Total surat masuk sebanyak 156 surat dengan rincian: 89 surat dinas, 45 surat dari masyarakat, dan 22 surat dari instansi lain.',
            'file_path' => null,
            'published_at' => '2025-07-05 10:00:00',
            'is_published' => true,
            'meta' => [
                'periode' => 'Triwulan II 2025',
                'total_surat' => 156,
                'surat_dinas' => 89,
                'surat_masyarakat' => 45,
                'surat_instansi' => 22
            ]
        ]);

        Publikasi::create([
            'judul' => 'Laporan Penerimaan Tamu Kunjungan Kerja Bulan Mei 2025',
            'slug' => Str::slug('Laporan Penerimaan Tamu Kunjungan Kerja Bulan Mei 2025'),
            'kategori' => 'penerima',
            'ringkasan' => 'Dokumentasi kunjungan kerja dari dinas lain dan pihak ketiga selama bulan Mei.',
            'isi' => 'Laporan ini memuat data kunjungan kerja yang diterima oleh Diskominfo Kota Madiun pada bulan Mei 2025. Total kunjungan sebanyak 12 kunjungan dengan rincian: 8 kunjungan dari dinas lain, 3 kunjungan dari perguruan tinggi, dan 1 kunjungan dari perusahaan swasta.',
            'file_path' => null,
            'published_at' => '2025-06-01 10:00:00',
            'is_published' => true,
            'meta' => [
                'bulan' => 'Mei 2025',
                'total_kunjungan' => 12,
                'dinas_lain' => 8,
                'perguruan_tinggi' => 3,
                'perusahaan' => 1
            ]
        ]);

        // Sample data for surveikepuasan category with images
        Publikasi::create([
            'judul' => 'Survei Kepuasan Masyarakat 2025',
            'slug' => Str::slug('Survei Kepuasan Masyarakat 2025'),
            'kategori' => 'surveikepuasan',
            'ringkasan' => 'Hasil survei kepuasan masyarakat terhadap layanan Diskominfo Kota Madiun tahun 2025.',
            'isi' => 'Survei kepuasan masyarakat ini dilakukan untuk mengukur tingkat kepuasan masyarakat terhadap layanan yang diberikan oleh Diskominfo Kota Madiun. Survei melibatkan 500 responden dengan hasil tingkat kepuasan sebesar 85%.',
            'file_path' => '/images/survei/survei-kepuasan-1.jpg',
            'published_at' => '2025-06-15 10:00:00',
            'is_published' => true,
            'meta' => [
                'tahun' => 2025,
                'total_responden' => 500,
                'tingkat_kepuasan' => 85,
                'metode_survei' => 'Online dan Offline'
            ]
        ]);

        Publikasi::create([
            'judul' => 'Survei Kepuasan Pelayanan IT 2025',
            'slug' => Str::slug('Survei Kepuasan Pelayanan IT 2025'),
            'kategori' => 'surveikepuasan',
            'ringkasan' => 'Hasil survei kepuasan khusus untuk layanan teknologi informasi Diskominfo Kota Madiun.',
            'isi' => 'Survei kepuasan khusus untuk layanan teknologi informasi yang diberikan oleh Diskominfo Kota Madiun. Survei melibatkan 300 responden dengan hasil tingkat kepuasan sebesar 88%.',
            'file_path' => '/images/survei/survei-kepuasan-2.jpg',
            'published_at' => '2025-07-01 10:00:00',
            'is_published' => true,
            'meta' => [
                'tahun' => 2025,
                'total_responden' => 300,
                'tingkat_kepuasan' => 88,
                'jenis_layanan' => 'Teknologi Informasi'
            ]
        ]);

        // Sample data for surveievaluasi category with images
        Publikasi::create([
            'judul' => 'Survei Evaluasi Pelayanan Publik 2025',
            'slug' => Str::slug('Survei Evaluasi Pelayanan Publik 2025'),
            'kategori' => 'surveievaluasi',
            'ringkasan' => 'Hasil evaluasi pelayanan publik yang dilakukan oleh Diskominfo Kota Madiun tahun 2025.',
            'isi' => 'Survei evaluasi pelayanan publik ini dilakukan untuk mengevaluasi kualitas dan efektivitas layanan yang diberikan oleh Diskominfo Kota Madiun. Evaluasi melibatkan 400 responden dengan hasil skor evaluasi sebesar 82%.',
            'file_path' => '/images/survei/survei-evaluasi-1.jpg',
            'published_at' => '2025-06-20 10:00:00',
            'is_published' => true,
            'meta' => [
                'tahun' => 2025,
                'total_responden' => 400,
                'skor_evaluasi' => 82,
                'aspek_evaluasi' => 'Kualitas, Efektivitas, dan Efisiensi'
            ]
        ]);

        Publikasi::create([
            'judul' => 'Evaluasi Kinerja Pelayanan Digital 2025',
            'slug' => Str::slug('Evaluasi Kinerja Pelayanan Digital 2025'),
            'kategori' => 'surveievaluasi',
            'ringkasan' => 'Evaluasi kinerja pelayanan digital dan e-government Diskominfo Kota Madiun.',
            'isi' => 'Evaluasi kinerja pelayanan digital dan e-government yang diberikan oleh Diskominfo Kota Madiun. Evaluasi melibatkan 250 responden dengan hasil skor evaluasi sebesar 87%.',
            'file_path' => '/images/survei/survei-evaluasi-2.jpg',
            'published_at' => '2025-07-05 10:00:00',
            'is_published' => true,
            'meta' => [
                'tahun' => 2025,
                'total_responden' => 250,
                'skor_evaluasi' => 87,
                'jenis_evaluasi' => 'Pelayanan Digital dan E-Government'
            ]
        ]);
    }
}
