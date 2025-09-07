<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'berita_id',
        'image_path',
        'image_name',
        'sort_order'
    ];

    // Relationship with Berita
    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    // Accessor for full image URL
    public function getImageUrlAttribute()
    {
        return $this->image_path ? url('storage/' . $this->image_path) : null;
    }
}
