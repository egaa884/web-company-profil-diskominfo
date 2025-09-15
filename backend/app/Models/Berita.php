<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi
    protected $table = 'beritas';

    protected $fillable = ['judul', 'konten', 'status', 'gambar', 'lampiran_pdf', 'views', 'slug', 'admin_id', 'category', 'is_hot', 'deskripsi_singkat', 'nama_pembuat'];

    // Tanggal yang di-cast ke objek Carbon
    protected $dates = ['published_at'];

    // Relationship with BeritaImage
    public function images()
    {
        return $this->hasMany(BeritaImage::class)->orderBy('sort_order');
    }

    // Relationship with Comment
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    // Get approved comments
    public function approvedComments()
    {
        return $this->comments()->approved();
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
