<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profil;

class ProfilSeeder extends Seeder
{
    public function run()
    {
        // Sekilas Dinas
        Profil::create([
            'kategori' => 'sekilas-dinas',
            'judul' => 'Sekilas Dinas Komunikasi dan Informatika Kota Madiun',
            'konten' => '
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
        ]);

        // Visi Misi
        Profil::create([
            'kategori' => 'visi-misi',
            'judul' => 'Visi dan Misi Dinas Komunikasi dan Informatika Kota Madiun',
            'konten' => '
                <p class="mb-4 font-bold text-lg">VISI:</p>
                <p class="mb-4">"Terwujudnya Kota Madiun yang Maju, Mandiri, dan Berdaya Saing melalui Transformasi Digital yang Inovatif dan Berkelanjutan"</p>

                <p class="mb-4 font-bold text-lg">MISI:</p>
                <ol class="list-decimal list-inside space-y-2">
                    <li>Meningkatkan kualitas pelayanan informasi publik yang transparan dan akuntabel</li>
                    <li>Mengembangkan infrastruktur teknologi informasi dan komunikasi yang handal</li>
                    <li>Mendorong inovasi digital untuk kemajuan masyarakat Kota Madiun</li>
                    <li>Meningkatkan kompetensi sumber daya manusia di bidang teknologi informasi</li>
                    <li>Mengoptimalkan pengelolaan data dan statistik untuk pengambilan keputusan</li>
                </ol>
            ',
        ]);

        // Kantor Dinas
        Profil::create([
            'kategori' => 'kantor-dinas',
            'judul' => 'Lokasi dan Kontak Dinas Komunikasi dan Informatika Kota Madiun',
            'konten' => '
                <div class="space-y-4">
                    <div>
                        <h3 class="font-bold text-lg mb-2">Alamat Kantor:</h3>
                        <p>Jl. Perintis Kemerdekaan No.32<br>
                        Kelurahan Kartoharjo, Kecamatan Kartoharjo<br>
                        Kota Madiun, Jawa Timur 63117</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg mb-2">Kontak:</h3>
                        <p>Telepon: (0351) 123456<br>
                        Email: info@kominfo.madiunkota.go.id<br>
                        Website: www.kominfo.madiunkota.go.id</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg mb-2">Jam Operasional:</h3>
                        <p>Senin - Kamis: 07:30 - 16:00 WIB<br>
                        Jumat: 07:30 - 16:30 WIB<br>
                        Sabtu - Minggu: Tutup</p>
                    </div>
                </div>
            ',
        ]);

        // Struktur Organisasi
        Profil::create([
            'kategori' => 'struktur-organisasi',
            'judul' => 'Struktur Organisasi Dinas Komunikasi dan Informatika Kota Madiun',
            'konten' => '
                <div class="space-y-4">
                    <p class="mb-4">Dinas Komunikasi dan Informatika Kota Madiun memiliki struktur organisasi Type B dengan kepemimpinan sebagai berikut:</p>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-lg mb-2">Kepala Dinas</h3>
                        <p>Drs. Ahmad Susanto, M.Si</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-bold text-lg mb-2">Sekretaris</h3>
                        <p>Dra. Siti Aminah, M.M</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold mb-2">Bidang Pengelolaan Informasi Publik dan Komunikasi</h4>
                            <p>Kepala Bidang: Budi Santoso, S.Kom</p>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-bold mb-2">Bidang Pengelolaan Teknologi Informasi dan Komunikasi</h4>
                            <p>Kepala Bidang: Rina Wulandari, S.T</p>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="font-bold mb-2">Bidang Pengelolaan Statistik dan Persandian</h4>
                            <p>Kepala Bidang: Eko Prasetyo, S.Si</p>
                        </div>
                    </div>
                </div>
            ',
        ]);

        // Tugas Pokok dan Fungsi
        Profil::create([
            'kategori' => 'tugas-pokok-fungsi',
            'judul' => 'Tugas Pokok dan Fungsi Dinas Komunikasi dan Informatika Kota Madiun',
            'konten' => '
                <div class="space-y-6">
                    <div>
                        <h3 class="font-bold text-lg mb-3">Tugas Pokok:</h3>
                        <p class="mb-4">Melaksanakan urusan pemerintahan di bidang komunikasi, informatika, persandian, dan statistik sesuai dengan ketentuan peraturan perundang-undangan.</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg mb-3">Fungsi:</h3>
                        <ol class="list-decimal list-inside space-y-2">
                            <li>Perumusan kebijakan teknis di bidang komunikasi, informatika, persandian, dan statistik</li>
                            <li>Pelaksanaan kebijakan di bidang komunikasi, informatika, persandian, dan statistik</li>
                            <li>Pembinaan dan pengendalian di bidang komunikasi, informatika, persandian, dan statistik</li>
                            <li>Pelaksanaan tugas lain yang diberikan oleh Walikota sesuai dengan tugas dan fungsinya</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg mb-3">Program Unggulan:</h3>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pengembangan sistem informasi dan komunikasi</li>
                            <li>Digitalisasi layanan publik</li>
                            <li>Peningkatan literasi digital masyarakat</li>
                            <li>Pengembangan data center Kota Madiun</li>
                            <li>Inovasi aplikasi berbasis teknologi</li>
                        </ul>
                    </div>
                </div>
            ',
        ]);

        // Standar Pelayanan
        Profil::create([
            'kategori' => 'standar-pelayanan',
            'judul' => 'Standar Pelayanan Dinas Komunikasi dan Informatika Kota Madiun',
            'konten' => '
                <div class="space-y-6">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="font-bold text-lg mb-3">Maklumat Pelayanan</h3>
                        <p class="mb-2"><strong>Dasar Hukum:</strong> Peraturan Menteri PANRB Nomor 15 Tahun 2014</p>
                        <p class="mb-2"><strong>Visi Pelayanan:</strong> "Terwujudnya Pelayanan Prima yang Cepat, Tepat, dan Berkualitas"</p>
                        <p><strong>Misi Pelayanan:</strong> Memberikan pelayanan yang profesional, transparan, dan akuntabel</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg mb-3">Jenis Pelayanan:</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="border p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">Pelayanan Informasi Publik</h4>
                                <p>Waktu penyelesaian: 10 hari kerja</p>
                            </div>
                            <div class="border p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">Pelayanan Teknologi Informasi</h4>
                                <p>Waktu penyelesaian: 7 hari kerja</p>
                            </div>
                            <div class="border p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">Pelayanan Statistik</h4>
                                <p>Waktu penyelesaian: 14 hari kerja</p>
                            </div>
                            <div class="border p-4 rounded-lg">
                                <h4 class="font-semibold mb-2">Pelayanan Persandian</h4>
                                <p>Waktu penyelesaian: 5 hari kerja</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="font-bold text-lg mb-3">Komitmen Pelayanan</h3>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Melayani dengan ramah dan sopan</li>
                            <li>Menyelesaikan sesuai standar waktu yang ditetapkan</li>
                            <li>Memberikan informasi yang jelas dan akurat</li>
                            <li>Menjaga kerahasiaan data pengguna</li>
                            <li>Menerima saran dan kritik untuk perbaikan</li>
                        </ul>
                    </div>
                </div>
            ',
        ]);

        // Tentang (Detailed About)
        Profil::create([
            'kategori' => 'tentang',
            'judul' => 'Tentang Dinas Komunikasi dan Informatika Kota Madiun',
            'pdf' => 'profil/13niUbDSMPWSnSH7XjOpstJbrpvS6mKqezPExPTJ.pdf',
            'konten' => '
                <p class="mb-4">
                    Dinas Komunikasi dan Informatika Kota Madiun merupakan instansi pemerintah yang memiliki peran strategis
                    dalam pengembangan komunikasi, informatika, dan statistik di Kota Madiun. Dinas ini didirikan berdasarkan
                    Peraturan Daerah Kota Madiun Nomor 04 Tahun 2008 tentang Organisasi dan Tata Kerja Dinas Daerah Kota Madiun.
                </p>

                <p class="mb-4">
                    Sejak awal berdirinya, Dinas Komunikasi dan Informatika Kota Madiun telah mengalami berbagai perkembangan
                    dan perubahan lokasi kantor. Dimulai dari Jalan Basuki Rahmad, kemudian pindah ke Jalan Hayam Wuruk,
                    selanjutnya ke Jalan Pahlawan, dan saat ini berlokasi di Jalan Perintis Kemerdekaan Nomor 32,
                    Kelurahan Kartoharjo, Kecamatan Kartoharjo, Kota Madiun.
                </p>

                <p class="mb-4">
                    Dinas ini memiliki visi "Terwujudnya Kota Madiun yang Maju, Mandiri, dan Berdaya Saing melalui Transformasi Digital
                    yang Inovatif dan Berkelanjutan" dengan misi untuk meningkatkan kualitas pelayanan informasi publik yang transparan
                    dan akuntabel, mengembangkan infrastruktur teknologi informasi dan komunikasi yang handal, mendorong inovasi
                    digital untuk kemajuan masyarakat Kota Madiun, meningkatkan kompetensi sumber daya manusia di bidang teknologi
                    informasi, serta mengoptimalkan pengelolaan data dan statistik untuk pengambilan keputusan.
                </p>

                <p class="mb-4">
                    Dinas Komunikasi dan Informatika Kota Madiun memiliki tugas pokok untuk melaksanakan urusan pemerintahan
                    di bidang komunikasi, informatika, persandian, dan statistik sesuai dengan ketentuan peraturan perundang-undangan.
                    Dalam melaksanakan tugas pokok tersebut, Dinas menyelenggarakan fungsi perumusan kebijakan teknis, pelaksanaan
                    kebijakan, pembinaan dan pengendalian, serta pelaksanaan tugas lain yang diberikan oleh Walikota sesuai
                    dengan tugas dan fungsinya.
                </p>

                <p class="mb-4">
                    Dinas Komunikasi dan Informatika Kota Madiun memiliki struktur organisasi Type B dengan tiga divisi utama
                    yaitu Divisi Pengelolaan Informasi Publik dan Komunikasi, Divisi Pengelolaan Teknologi Informasi dan Komunikasi,
                    serta Divisi Pengelolaan Statistik dan Persandian. Dinas ini juga menjalankan berbagai program unggulan
                    seperti pengembangan sistem informasi dan komunikasi, digitalisasi layanan publik, peningkatan literasi
                    digital masyarakat, pengembangan data center Kota Madiun, serta inovasi aplikasi berbasis teknologi.
                </p>

                <p class="mb-4">
                    Untuk informasi lebih lanjut, Dinas Komunikasi dan Informatika Kota Madiun dapat dihubungi melalui alamat
                    Jl. Perintis Kemerdekaan No.32, Kartoharjo, Kec. Kartoharjo, Kota Madiun, Jawa Timur 63117, telepon (0351) 123456,
                    email info@kominfo.madiunkota.go.id, atau website www.kominfo.madiunkota.go.id.
                </p>
            ',
        ]);
    }
} 