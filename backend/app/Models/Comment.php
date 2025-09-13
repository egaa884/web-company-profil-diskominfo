<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'berita_id',
        'name',
        'email',
        'comment',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Relationship with Berita
    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    // Scope for approved comments
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope for pending comments
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}
