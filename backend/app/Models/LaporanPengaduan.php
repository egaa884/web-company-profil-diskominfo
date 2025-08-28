<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanPengaduan extends Model
{
    use HasFactory;

    protected $table = 'laporan_pengaduan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori_pengaduan',
        'status',
        'prioritas',
        'nama_pelapor',
        'email_pelapor',
        'telepon_pelapor',
        'alamat_pelapor',
        'nik_pelapor',
        'file_lampiran',
        'catatan_admin',
        'tanggal_pengaduan',
        'tanggal_selesai',
        'admin_id',
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Get the admin that handles this complaint
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get priority label
     */
    public function getPriorityLabelAttribute(): string
    {
        return match($this->prioritas) {
            'rendah' => 'Rendah',
            'normal' => 'Normal',
            'tinggi' => 'Tinggi',
            'kritis' => 'Kritis',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->prioritas) {
            'rendah' => 'success',
            'normal' => 'info',
            'tinggi' => 'warning',
            'kritis' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_lampiran ? asset('storage/' . $this->file_lampiran) : null;
    }

    /**
     * Get file name
     */
    public function getFileNameAttribute(): ?string
    {
        return $this->file_lampiran ? basename($this->file_lampiran) : null;
    }

    /**
     * Scope for pending complaints
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for processed complaints
     */
    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    /**
     * Scope for completed complaints
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Scope for rejected complaints
     */
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    /**
     * Scope for high priority complaints
     */
    public function scopePrioritasTinggi($query)
    {
        return $query->where('prioritas', 'tinggi');
    }

    /**
     * Scope for critical priority complaints
     */
    public function scopePrioritasKritis($query)
    {
        return $query->where('prioritas', 'kritis');
    }
}
