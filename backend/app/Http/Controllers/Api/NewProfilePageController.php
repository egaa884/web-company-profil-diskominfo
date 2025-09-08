<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;

class NewProfilePageController extends Controller
{
    public function getSekilasDinas()
    {
        $profil = Profil::whereRaw('LOWER(kategori) = ?', ['sekilas_dinas'])->first();

        if ($profil) {
            return response()->json([
                'title' => $profil->judul ?? 'Sekilas Dinas Komunikasi dan Informatika Kota Madiun',
                'content' => $profil->konten,
                'image' => $profil->gambar ? url('storage/' . $profil->gambar) : null
            ]);
        }

        // Fallback to default content if no data in DB
        return response()->json([
            'title' => 'Sekilas Dinas Komunikasi dan Informatika Kota Madiun',
            'content' => '
                <p class="mb-4">
                    Dinas Komunikasi dan Informatika Kota Madiun adalah instansi pemerintah yang bertanggung jawab
                    dalam bidang komunikasi, informatika, persandian, dan statistik. Dinas ini dibentuk berdasarkan
                    Peraturan Daerah Kota Madiun Nomor 04 tahun 2008 tentang Organisasi dan Tata Kerja Dinas Daerah
                    Kota Madiun.
                </p>

                <p class="mb-4">
                    Sejak awal berdirinya, Dinas Komunikasi dan Informatika telah mengalami beberapa kali perubahan
                    lokasi kantor, dimulai dari Jalan Basuki Rahmad, kemudian pindah ke Jalan Hayam Wuruk,
                    selanjutnya ke Jalan Pahlawan, dan saat ini berlokasi di Jalan Perintis Kemerdekaan Nomor 32,
                    Kelurahan Kartoharjo, Kecamatan Kartoharjo, Kota Madiun.
                </p>

                <p class="mb-4">
                    Saat ini, Dinas Komunikasi dan Informatika Kota Madiun memiliki struktur organisasi Type B
                    dengan tiga divisi utama: Divisi Pengelolaan Informasi Publik dan Komunikasi, Divisi Pengelolaan
                    Teknologi Informasi dan Komunikasi, serta Divisi Pengelolaan Statistik dan Persandian.
                </p>

                <p class="mb-4">
                    Dinas ini berperan penting dalam mendukung transformasi digital dan peningkatan pelayanan publik
                    di Kota Madiun melalui pengembangan teknologi informasi dan komunikasi yang inovatif dan
                    berkelanjutan.
                </p>
            ',
            'image' => null
        ]);
    }

    public function getVisiMisi()
    {
        $profil = Profil::whereRaw('LOWER(kategori) = ?', ['visi_misi'])->first();

        if ($profil) {
            return response()->json([
                'title' => $profil->judul ?? 'Visi dan Misi Dinas Komunikasi dan Informatika Kota Madiun',
                'visi' => $profil->konten, // Assuming konten contains the vision text
                'misi' => [], // You might need to parse this or have separate fields
                'image' => $profil->gambar ? url('storage/' . $profil->gambar) : '/images/visi.png'
            ]);
        }

        // Fallback
        return response()->json([
            'title' => 'Visi dan Misi Dinas Komunikasi dan Informatika Kota Madiun',
            'visi' => 'Terwujudnya Kota Madiun yang Maju, Mandiri, dan Berdaya Saing melalui Transformasi Digital yang Inovatif dan Berkelanjutan',
            'misi' => [
                'Meningkatkan kualitas pelayanan informasi publik yang transparan dan akuntabel',
                'Mengembangkan infrastruktur teknologi informasi dan komunikasi yang handal',
                'Mendorong inovasi digital untuk kemajuan masyarakat Kota Madiun',
                'Meningkatkan kompetensi sumber daya manusia di bidang teknologi informasi',
                'Mengoptimalkan pengelolaan data dan statistik untuk pengambilan keputusan'
            ],
            'image' => '/images/visi.png'
        ]);
    }

    public function getKantorDinas()
    {
        $profil = Profil::whereRaw('LOWER(kategori) = ?', ['kantor_dinas'])->first();

        if ($profil) {
            return response()->json([
                'title' => $profil->judul ?? 'Lokasi dan Kontak Dinas Komunikasi dan Informatika Kota Madiun',
                'address' => $profil->konten, // Assuming konten contains address
                'phone' => '', // You might need additional fields
                'email' => '',
                'website' => '',
                'hours' => []
            ]);
        }

        // Fallback
        return response()->json([
            'title' => 'Lokasi dan Kontak Dinas Komunikasi dan Informatika Kota Madiun',
            'address' => 'Jl. Perintis Kemerdekaan No.32, Kelurahan Kartoharjo, Kecamatan Kartoharjo, Kota Madiun, Jawa Timur 63117',
            'phone' => '(0351) 123456',
            'email' => 'info@kominfo.madiunkota.go.id',
            'website' => 'www.kominfo.madiunkota.go.id',
            'hours' => [
                'weekdays' => '07:30 - 16:00 WIB',
                'friday' => '07:30 - 16:30 WIB',
                'weekend' => 'Tutup'
            ]
        ]);
    }

    public function getStrukturOrganisasi()
    {
        $profil = Profil::whereRaw('LOWER(kategori) = ?', ['struktur_organisasi'])->first();

        if ($profil) {
            return response()->json([
                'title' => $profil->judul ?? 'Struktur Organisasi Dinas Komunikasi dan Informatika Kota Madiun',
                'kepala_dinas' => [], // Parse from konten or have separate fields
                'sekretaris' => [],
                'bidang' => []
            ]);
        }

        // Fallback
        return response()->json([
            'title' => 'Struktur Organisasi Dinas Komunikasi dan Informatika Kota Madiun',
            'kepala_dinas' => [
                'name' => 'Drs. Ahmad Susanto, M.Si',
                'position' => 'Kepala Dinas'
            ],
            'sekretaris' => [
                'name' => 'Dra. Siti Aminah, M.M',
                'position' => 'Sekretaris'
            ],
            'bidang' => [
                [
                    'name' => 'Bidang Pengelolaan Informasi Publik dan Komunikasi',
                    'kepala' => 'Budi Santoso, S.Kom'
                ],
                [
                    'name' => 'Bidang Pengelolaan Teknologi Informasi dan Komunikasi',
                    'kepala' => 'Rina Wulandari, S.T'
                ],
                [
                    'name' => 'Bidang Pengelolaan Statistik dan Persandian',
                    'kepala' => 'Eko Prasetyo, S.Si'
                ]
            ]
        ]);
    }

    public function getTugasPokokFungsi()
    {
        $profil = Profil::whereRaw('LOWER(kategori) = ?', ['tugas_pokok_fungsi'])->first();

        if ($profil) {
            return response()->json([
                'title' => $profil->judul ?? 'Tugas Pokok dan Fungsi Dinas Komunikasi dan Informatika Kota Madiun',
                'tugas_pokok' => $profil->konten,
                'fungsi' => [],
                'program_unggulan' => []
            ]);
        }

        // Fallback
        return response()->json([
            'title' => 'Tugas Pokok dan Fungsi Dinas Komunikasi dan Informatika Kota Madiun',
            'tugas_pokok' => 'Melaksanakan urusan pemerintahan di bidang komunikasi, informatika, persandian, dan statistik sesuai dengan ketentuan peraturan perundang-undangan.',
            'fungsi' => [
                'Perumusan kebijakan teknis di bidang komunikasi, informatika, persandian, dan statistik',
                'Pelaksanaan kebijakan di bidang komunikasi, informatika, persandian, dan statistik',
                'Pembinaan dan pengendalian di bidang komunikasi, informatika, persandian, dan statistik',
                'Pelaksanaan tugas lain yang diberikan oleh Walikota sesuai dengan tugas dan fungsinya'
            ],
            'program_unggulan' => [
                'Pengembangan sistem informasi dan komunikasi',
                'Digitalisasi layanan publik',
                'Peningkatan literasi digital masyarakat',
                'Pengembangan data center Kota Madiun',
                'Inovasi aplikasi berbasis teknologi'
            ]
        ]);
    }

    public function getStandarPelayanan()
    {
        $profil = Profil::whereRaw('LOWER(kategori) = ?', ['standar_pelayanan'])->first();

        if ($profil) {
            return response()->json([
                'title' => $profil->judul ?? 'Standar Pelayanan Dinas Komunikasi dan Informatika Kota Madiun',
                'maklumat_pelayanan' => [],
                'jenis_pelayanan' => [],
                'komitmen' => []
            ]);
        }

        // Fallback
        return response()->json([
            'title' => 'Standar Pelayanan Dinas Komunikasi dan Informatika Kota Madiun',
            'maklumat_pelayanan' => [
                'dasar_hukum' => 'Peraturan Menteri PANRB Nomor 15 Tahun 2014',
                'visi' => 'Terwujudnya Pelayanan Prima yang Cepat, Tepat, dan Berkualitas',
                'misi' => 'Memberikan pelayanan yang profesional, transparan, dan akuntabel'
            ],
            'jenis_pelayanan' => [
                [
                    'name' => 'Pelayanan Informasi Publik',
                    'waktu_penyelesaian' => '10 hari kerja'
                ],
                [
                    'name' => 'Pelayanan Teknologi Informasi',
                    'waktu_penyelesaian' => '7 hari kerja'
                ],
                [
                    'name' => 'Pelayanan Statistik',
                    'waktu_penyelesaian' => '14 hari kerja'
                ],
                [
                    'name' => 'Pelayanan Persandian',
                    'waktu_penyelesaian' => '5 hari kerja'
                ]
            ],
            'komitmen' => [
                'Melayani dengan ramah dan sopan',
                'Menyelesaikan sesuai standar waktu yang ditetapkan',
                'Memberikan informasi yang jelas dan akurat',
                'Menjaga kerahasiaan data pengguna',
                'Menerima saran dan kritik untuk perbaikan'
            ]
        ]);
    }

    public function getAllProfileData()
    {
        return response()->json([
            'sekilas_dinas' => $this->getSekilasDinas()->getData(),
            'visi_misi' => $this->getVisiMisi()->getData(),
            'kantor_dinas' => $this->getKantorDinas()->getData(),
            'struktur_organisasi' => $this->getStrukturOrganisasi()->getData(),
            'tugas_pokok_fungsi' => $this->getTugasPokokFungsi()->getData(),
            'standar_pelayanan' => $this->getStandarPelayanan()->getData()
        ]);
    }
}