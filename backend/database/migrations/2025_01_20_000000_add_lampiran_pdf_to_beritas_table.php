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
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('lampiran_pdf')->nullable()->after('gambar');
            $table->string('nama_pembuat')->nullable()->after('admin_id');
            $table->text('deskripsi_singkat')->nullable()->after('konten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['lampiran_pdf', 'nama_pembuat', 'deskripsi_singkat']);
        });
    }
};
