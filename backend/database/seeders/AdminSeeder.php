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
        Admin::updateOrCreate(
            ['email' => 'admin@kominfo.com'],
            [
                'name' => 'Admin Kominfo',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // User dengan role 'user' (hanya akses berita)
        Admin::updateOrCreate(
            ['email' => 'user@kominfo.com'],
            [
                'name' => 'User Berita',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}
