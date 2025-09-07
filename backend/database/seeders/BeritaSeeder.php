<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use App\Models\Admin;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        // Ambil admin pertama untuk admin_id
        $admin = Admin::first();

        Berita::updateOrCreate(
            ['slug' => Str::slug('Berita Kominfo Madiun')],
            [
                'judul' => 'Berita Kominfo Madiun',
                'konten' => 'Ini adalah konten berita Kominfo Madiun.',
                'status' => 'published',
                'category' => 'Berita Kominfo Madiun',
                'admin_id' => $admin->id,
                'published_at' => now(),
            ]
        );

        Berita::updateOrCreate(
            ['slug' => Str::slug('Madiun Today')],
            [
                'judul' => 'Madiun Today',
                'konten' => 'Ini adalah konten berita Madiun Today.',
                'status' => 'draft',
                'category' => 'Madiun Today',
                'admin_id' => $admin->id,
            ]
        );

        Berita::updateOrCreate(
            ['slug' => Str::slug('Kabar Warga')],
            [
                'judul' => 'Kabar Warga',
                'konten' => 'Ini adalah konten Kabar Warga.',
                'status' => 'published',
                'category' => 'Kabar Warga',
                'admin_id' => $admin->id,
                'published_at' => now()->subDays(2),
            ]
        );

        // Sample Siaran Pers entries
        Berita::updateOrCreate(
            ['slug' => Str::slug('Pengenalan Keterbukaan Informasi Publik')],
            [
                'judul' => 'Pengenalan Keterbukaan Informasi Publik',
                'konten' => 'Diskominfostandi Kota Madiun menggelar sosialisasi Pengenalan Keterbukaan Informasi Publik (KIP) dengan tema "Pola Interaksi dan Pola Komunikasi di Era Digital" di Balai Kota Madiun pada 26 Juli 2023. Kegiatan ini dihadiri oleh berbagai stakeholder dan masyarakat umum untuk meningkatkan pemahaman tentang pentingnya transparansi informasi publik.',
                'status' => 'published',
                'category' => 'Siaran Pers Madiun',
                'admin_id' => $admin->id,
                'published_at' => now()->subDays(1),
            ]
        );

        Berita::updateOrCreate(
            ['slug' => Str::slug('Gerakan Masyarakat Hidup Sehat')],
            [
                'judul' => 'Gerakan Masyarakat Hidup Sehat',
                'konten' => 'Diskominfostandi Kota Madiun bersama perangkat daerah lainnya turut menyukseskan Gerakan Masyarakat Hidup Sehat dengan 15.000 peserta senam di Lapangan Balai Kota Madiun. Kegiatan ini merupakan bagian dari program pemerintah daerah untuk meningkatkan kesehatan masyarakat dan membangun kesadaran akan pentingnya olahraga rutin.',
                'status' => 'published',
                'category' => 'Siaran Pers Madiun',
                'admin_id' => $admin->id,
                'published_at' => now()->subDays(3),
            ]
        );

        Berita::updateOrCreate(
            ['slug' => Str::slug('Peringatan Hari Pers Nasional 2024')],
            [
                'judul' => 'Peringatan Hari Pers Nasional 2024',
                'konten' => 'Walikota Madiun, Mohammad Idris, secara simbolis menyerahkan piagam penghargaan dan santunan kepada 5 orang jurnalis Kota Madiun saat acara Peringatan Hari Pers Nasional 2024. Acara ini menjadi momentum untuk mengapresiasi peran penting pers dalam membangun masyarakat yang informatif dan demokratis.',
                'status' => 'published',
                'category' => 'Siaran Pers Madiun',
                'admin_id' => $admin->id,
                'published_at' => now()->subDays(5),
            ]
        );

        // Sample Infografis entries
        Berita::updateOrCreate(
            ['slug' => Str::slug('Waspada Modus Penipuan Aktivasi IKD')],
            [
                'judul' => 'Waspada Modus Penipuan Aktivasi IKD',
                'konten' => 'Infografis ini memberikan informasi penting tentang berbagai modus penipuan yang sering terjadi terkait aktivasi IKD (Identitas Kependudukan Digital). Masyarakat diimbau untuk selalu waspada dan melaporkan jika menemukan aktivitas mencurigakan.',
                'status' => 'published',
                'category' => 'Infografis Madiun',
                'admin_id' => $admin->id,
                'published_at' => now()->subDays(7),
            ]
        );

        Berita::updateOrCreate(
            ['slug' => Str::slug('Sebentar Lagi Anak Daftar Sekolah')],
            [
                'judul' => 'Sebentar Lagi Anak Daftar Sekolah, Kenali Jalur Penerimaannya!',
                'konten' => 'Infografis ini menjelaskan berbagai jalur penerimaan siswa baru di sekolah-sekolah di Kota Madiun. Mulai dari jalur prestasi, zonasi, hingga afirmasi untuk membantu orang tua memahami proses pendaftaran yang tepat.',
                'status' => 'published',
                'category' => 'Infografis Madiun',
                'admin_id' => $admin->id,
                'published_at' => now()->subDays(10),
            ]
        );

        Berita::updateOrCreate(
            ['slug' => Str::slug('Tren Peningkatan Indeks Reformasi Birokrasi')],
            [
                'judul' => 'Tren Peningkatan Indeks Reformasi Birokrasi Pemerintah Kota Madiun',
                'konten' => 'Infografis ini menampilkan data tren peningkatan indeks reformasi birokrasi di Pemerintah Kota Madiun selama beberapa tahun terakhir. Menunjukkan komitmen pemerintah daerah dalam meningkatkan kualitas pelayanan publik.',
                'status' => 'published',
                'category' => 'Infografis Madiun',
                'admin_id' => $admin->id,
                'published_at' => now()->subDays(12),
            ]
        );
    }
}