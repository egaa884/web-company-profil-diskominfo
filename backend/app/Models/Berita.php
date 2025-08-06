<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi
    protected $table = 'beritas'; 

    // Kolom yang dapat diisi massal
    protected $fillable = ['judul', 'konten', 'status', 'gambar', 'slug', 'admin_id', 'category'];

    // Tanggal yang di-cast ke objek Carbon
    protected $dates = ['published_at'];
}
