<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Admin dengan role 'admin' (akses penuh)
        Admin::create([
            'name' => 'Admin Kominfo',
            'email' => 'admin@kominfo.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // User dengan role 'user' (hanya akses berita)
        Admin::create([
            'name' => 'User Berita',
            'email' => 'user@kominfo.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
