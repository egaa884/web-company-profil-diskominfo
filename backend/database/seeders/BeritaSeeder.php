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

        Berita::create([
            'judul' => 'Berita Kominfo Madiun',
            'slug' => Str::slug('Berita Kominfo Madiun'),
            'konten' => 'Ini adalah konten berita Kominfo Madiun.',
            'status' => 'published',
            'category' => 'Berita Kominfo Madiun',
            'admin_id' => $admin->id,
            'published_at' => now(),
        ]);

        Berita::create([
            'judul' => 'Madiun Today',
            'slug' => Str::slug('Madiun Today'),
            'konten' => 'Ini adalah konten berita Madiun Today.',
            'status' => 'draft',
            'category' => 'Madiun Today',
            'admin_id' => $admin->id,
        ]);

        Berita::create([
            'judul' => 'Kabar Warga',
            'slug' => Str::slug('Kabar Warga'),
            'konten' => 'Ini adalah konten Kabar Warga.',
            'status' => 'published',
            'category' => 'Kabar Warga',
            'admin_id' => $admin->id,
            'published_at' => now()->subDays(2),
        ]);
    }
} 