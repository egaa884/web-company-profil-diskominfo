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
<<<<<<< HEAD
    protected $fillable = ['judul', 'konten', 'status', 'gambar', 'lampiran_pdf', 'slug', 'admin_id', 'category', 'nama_pembuat', 'deskripsi_singkat'];
=======
    protected $fillable = ['judul', 'konten', 'status', 'gambar', 'pdf', 'views', 'slug', 'admin_id', 'category'];
>>>>>>> ea161908d4f286972222c8073d65dd9c6f5840d6

    // Tanggal yang di-cast ke objek Carbon
    protected $dates = ['published_at'];

    // Relationship with BeritaImage
    public function images()
    {
        return $this->hasMany(BeritaImage::class)->orderBy('sort_order');
    }

    // Method untuk increment view count
    public function incrementViews()
    {
        $this->increment('views');
        return $this;
    }

    // Method untuk mendapatkan formatted view count
    public function getFormattedViewsAttribute()
    {
        return number_format($this->views);
    }
}
