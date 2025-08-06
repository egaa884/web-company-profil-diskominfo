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
            'konten' => '
                <p class="sekilas-paragraph">
                    Dinas Komunikasi dan Informatika Kota Madiun adalah instansi pemerintah yang bertanggung jawab 
                    dalam bidang komunikasi, informatika, persandian, dan statistik. Dinas ini dibentuk berdasarkan 
                    Peraturan Daerah Kota Madiun Nomor 04 tahun 2008 tentang Organisasi dan Tata Kerja Dinas Daerah 
                    Kota Madiun.
                </p>
                
                <p class="sekilas-paragraph">
                    Sejak awal berdirinya, Dinas Komunikasi dan Informatika telah mengalami beberapa kali perubahan 
                    lokasi kantor, dimulai dari Jalan Basuki Rahmad, kemudian pindah ke Jalan Hayam Wuruk, 
                    selanjutnya ke Jalan Pahlawan, dan saat ini berlokasi di Jalan Perintis Kemerdekaan Nomor 32, 
                    Kelurahan Kartoharjo, Kecamatan Kartoharjo, Kota Madiun.
                </p>
                
                <p class="sekilas-paragraph">
                    Saat ini, Dinas Komunikasi dan Informatika Kota Madiun memiliki struktur organisasi Type B 
                    dengan tiga divisi utama: Divisi Pengelolaan Informasi Publik dan Komunikasi, Divisi Pengelolaan 
                    Teknologi Informasi dan Komunikasi, serta Divisi Pengelolaan Statistik dan Persandian.
                </p>
                
                <p class="sekilas-paragraph">
                    Dinas ini berperan penting dalam mendukung transformasi digital dan peningkatan pelayanan publik 
                    di Kota Madiun melalui pengembangan teknologi informasi dan komunikasi yang inovatif dan 
                    berkelanjutan.
                </p>
            ',
        ]);

        // Visi Misi
        Profil::create([
            'kategori' => 'visi-misi',
            'konten' => '
                <p class="text-lg font-semibold">Terwujudnya</p>
                <p class="text-lg font-semibold">Pemerintahan</p>
                <p class="text-lg font-semibold">Bersih Berwibawa</p>
                <p class="text-lg font-semibold">Menuju masyarakat</p>
                <p class="text-lg font-semibold">Sejahtera</p>
            ',
        ]);

        // Struktur Organisasi
        Profil::create([
            'kategori' => 'struktur-organisasi',
            'konten' => '
                <h3 class="text-xl font-bold mb-4">Struktur Organisasi Dinas Kominfo Kota Madiun</h3>
                <div class="space-y-4">
                    <div class="border-l-4 border-blue-600 pl-4">
                        <h4 class="font-semibold text-lg">Kepala Dinas</h4>
                        <p class="text-gray-600">Dr. Ir. Ahmad Supriyadi, M.Si</p>
                    </div>
                    <div class="border-l-4 border-green-600 pl-4">
                        <h4 class="font-semibold text-lg">Sekretaris</h4>
                        <p class="text-gray-600">Ir. Budi Santoso, M.T</p>
                    </div>
                    <div class="border-l-4 border-yellow-600 pl-4">
                        <h4 class="font-semibold text-lg">Kasi Pengelolaan Informasi Publik</h4>
                        <p class="text-gray-600">Drs. Siti Nurhaliza, M.Si</p>
                    </div>
                    <div class="border-l-4 border-red-600 pl-4">
                        <h4 class="font-semibold text-lg">Kasi Pengelolaan TIK</h4>
                        <p class="text-gray-600">Ir. Rudi Hartono, M.Kom</p>
                    </div>
                </div>
            ',
        ]);

        // Tugas Pokok dan Fungsi
        Profil::create([
            'kategori' => 'tugas-pokok-fungsi',
            'konten' => '
                <h3 class="text-xl font-bold mb-4">Tugas Pokok dan Fungsi</h3>
                <div class="space-y-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-2">Tugas Pokok:</h4>
                        <p class="text-gray-700">Melaksanakan urusan pemerintahan di bidang komunikasi, informatika, persandian, dan statistik.</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-green-800 mb-2">Fungsi:</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Perumusan kebijakan teknis di bidang komunikasi, informatika, persandian, dan statistik</li>
                            <li>Pelaksanaan kebijakan di bidang komunikasi, informatika, persandian, dan statistik</li>
                            <li>Pelaksanaan evaluasi dan pelaporan di bidang komunikasi, informatika, persandian, dan statistik</li>
                            <li>Pelaksanaan administrasi dinas sesuai dengan lingkup tugasnya</li>
                        </ul>
                    </div>
                </div>
            ',
        ]);

        // Standar Pelayanan
        Profil::create([
            'kategori' => 'standar-pelayanan',
            'konten' => '
                <h3 class="text-xl font-bold mb-4">Standar Pelayanan</h3>
                <div class="space-y-4">
                    <div class="border rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Waktu Pelayanan:</h4>
                        <p class="text-gray-700">Senin - Jumat: 07:00 - 15:30 WIB</p>
                    </div>
                    <div class="border rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Jenis Pelayanan:</h4>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            <li>Layanan Informasi Publik</li>
                            <li>Layanan Pengaduan</li>
                            <li>Layanan Konsultasi TIK</li>
                            <li>Layanan Statistik</li>
                        </ul>
                    </div>
                    <div class="border rounded-lg p-4">
                        <h4 class="font-semibold mb-2">Syarat dan Ketentuan:</h4>
                        <p class="text-gray-700">Setiap layanan memiliki persyaratan dan ketentuan yang dapat dilihat di masing-masing unit layanan.</p>
                    </div>
                </div>
            ',
        ]);

        // Kantor Dinas
        Profil::create([
            'kategori' => 'kantor-dinas',
            'konten' => '
                <h3 class="text-xl font-bold mb-4">Informasi Kantor</h3>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Alamat:</h4>
                        <p class="text-gray-700">Jalan Perintis Kemerdekaan Nomor 32, Kelurahan Kartoharjo, Kecamatan Kartoharjo, Kota Madiun, Jawa Timur 63117</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Telepon:</h4>
                        <p class="text-gray-700">(0351) 123456</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Email:</h4>
                        <p class="text-gray-700">kominfo@madiunkota.go.id</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">Jam Operasional:</h4>
                        <p class="text-gray-700">Senin - Jumat: 07:00 - 15:30 WIB</p>
                    </div>
                </div>
            ',
        ]);
    }
} 