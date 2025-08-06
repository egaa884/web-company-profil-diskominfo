<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infografis extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan oleh model ini (jika tidak default 'infografis')
    protected $table = 'infografis';

    // Tentukan kolom yang dapat diisi mass-assignment
    protected $fillable = [
        'judul', 
        'deskripsi', 
        'tanggal', 
        'gambar',
    ];

    // Tentukan kolom yang harus diperlakukan sebagai tanggal (untuk otomatis parsing)
    protected $dates = ['tanggal'];

    // Jika ingin mengatur path gambar otomatis, Anda bisa menambahkan accessor di sini
    public function getGambarUrlAttribute()
    {
        return asset('storage/' . $this->gambar);
    }
}
