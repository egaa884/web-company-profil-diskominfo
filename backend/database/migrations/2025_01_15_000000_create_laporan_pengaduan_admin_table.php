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
        Schema::create('laporan_pengaduan_admin', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('bulan'); // e.g., 'Juni'
            $table->integer('tahun'); // e.g., 2025
            $table->string('file_lampiran')->nullable(); // untuk upload file PDF laporan
            $table->string('kategori')->default('Laporan Pengaduan Pelayanan Publik');
            $table->text('ringkasan')->nullable(); // ringkasan laporan
            $table->integer('total_pengaduan')->default(0);
            $table->integer('pengaduan_diproses')->default(0);
            $table->integer('pengaduan_selesai')->default(0);
            $table->integer('pengaduan_ditolak')->default(0);
            $table->text('catatan_admin')->nullable();
            $table->unsignedBigInteger('admin_id'); // admin yang membuat laporan
            $table->boolean('is_published')->default(false); // status publikasi
            $table->timestamp('tanggal_publikasi')->nullable();
            $table->timestamps();
            
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->index(['bulan', 'tahun']);
            $table->index('is_published');
            $table->unique(['bulan', 'tahun']); // satu laporan per bulan per tahun
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengaduan_admin');
    }
};
