<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Tambahkan semua kolom yang mungkin hilang
            if (!Schema::hasColumn('beritas', 'nama_pembuat')) {
                $table->string('nama_pembuat')->nullable();
            }
            if (!Schema::hasColumn('beritas', 'deskripsi_singkat')) {
                $table->text('deskripsi_singkat')->nullable();
            }
            if (!Schema::hasColumn('beritas', 'gambar')) {
                $table->string('gambar')->nullable();
            }
            if (!Schema::hasColumn('beritas', 'lampiran_pdf')) {
                $table->string('lampiran_pdf')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            if (Schema::hasColumn('beritas', 'nama_pembuat')) {
                $table->dropColumn('nama_pembuat');
            }
            if (Schema::hasColumn('beritas', 'deskripsi_singkat')) {
                $table->dropColumn('deskripsi_singkat');
            }
            if (Schema::hasColumn('beritas', 'gambar')) {
                $table->dropColumn('gambar');
            }
            if (Schema::hasColumn('beritas', 'lampiran_pdf')) {
                $table->dropColumn('lampiran_pdf');
            }
        });
    }
};