<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LaporanPengaduan>
 */
class LaporanPengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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

        return [
            'judul' => fake()->sentence(4),
            'deskripsi' => fake()->paragraph(3),
            'kategori_pengaduan' => fake()->randomElement($categories),
            'status' => fake()->randomElement($statuses),
            'prioritas' => fake()->randomElement($priorities),
            'nama_pelapor' => fake()->name(),
            'email_pelapor' => fake()->email(),
            'telepon_pelapor' => fake()->phoneNumber(),
            'alamat_pelapor' => fake()->address(),
            'nik_pelapor' => fake()->numerify('357301########'),
            'file_lampiran' => null, // Can be set manually if needed
            'catatan_admin' => fake()->optional()->paragraph(),
            'tanggal_pengaduan' => fake()->dateTimeBetween('-60 days', 'now'),
            'tanggal_selesai' => fake()->optional()->dateTimeBetween('-30 days', 'now'),
            'admin_id' => Admin::inRandomOrder()->first()?->id,
        ];
    }

    /**
     * Indicate that the complaint is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'tanggal_selesai' => null,
        ]);
    }

    /**
     * Indicate that the complaint is being processed.
     */
    public function diproses(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diproses',
            'tanggal_selesai' => null,
        ]);
    }

    /**
     * Indicate that the complaint is completed.
     */
    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
            'tanggal_selesai' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the complaint is rejected.
     */
    public function ditolak(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ditolak',
            'tanggal_selesai' => null,
        ]);
    }

    /**
     * Indicate that the complaint has high priority.
     */
    public function prioritasTinggi(): static
    {
        return $this->state(fn (array $attributes) => [
            'prioritas' => 'tinggi',
        ]);
    }

    /**
     * Indicate that the complaint has critical priority.
     */
    public function prioritasKritis(): static
    {
        return $this->state(fn (array $attributes) => [
            'prioritas' => 'kritis',
        ]);
    }
} 