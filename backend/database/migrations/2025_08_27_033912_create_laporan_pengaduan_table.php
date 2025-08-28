<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('kategori_pengaduan');
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->enum('prioritas', ['rendah', 'normal', 'tinggi', 'kritis'])->default('normal');
            $table->string('nama_pelapor');
            $table->string('email_pelapor');
            $table->string('telepon_pelapor');
            $table->text('alamat_pelapor');
            $table->string('nik_pelapor', 16);
            $table->string('file_lampiran')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_pengaduan');
            $table->timestamp('tanggal_selesai')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengaduan');
    }
};
