<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanPengaduanAdmin extends Model
{
    use HasFactory;

    protected $table = 'laporan_pengaduan_admin';

    protected $fillable = [
        'judul',
        'deskripsi',
        'bulan',
        'tahun',
        'file_lampiran',
        'kategori',
        'ringkasan',
        'total_pengaduan',
        'pengaduan_diproses',
        'pengaduan_selesai',
        'pengaduan_ditolak',
        'catatan_admin',
        'admin_id',
        'is_published',
        'tanggal_publikasi',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'tanggal_publikasi' => 'datetime',
        'total_pengaduan' => 'integer',
        'pengaduan_diproses' => 'integer',
        'pengaduan_selesai' => 'integer',
        'pengaduan_ditolak' => 'integer',
    ];

    /**
     * Get the admin that created this report
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the full title with month and year
     */
    public function getFullTitleAttribute(): string
    {
        return "Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan {$this->bulan} Tahun {$this->tahun}";
    }

    /**
     * Get the period string
     */
    public function getPeriodAttribute(): string
    {
        return "{$this->bulan} {$this->tahun}";
    }

    /**
     * Get the file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_lampiran ? asset('storage/' . $this->file_lampiran) : null;
    }

    /**
     * Get the file name
     */
    public function getFileNameAttribute(): ?string
    {
        return $this->file_lampiran ? basename($this->file_lampiran) : null;
    }

    /**
     * Get published status label
     */
    public function getPublishedLabelAttribute(): string
    {
        return $this->is_published ? 'Dipublikasi' : 'Draft';
    }

    /**
     * Get published status color
     */
    public function getPublishedColorAttribute(): string
    {
        return $this->is_published ? 'success' : 'warning';
    }

    /**
     * Scope for published reports
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for draft reports
     */
    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    /**
     * Scope for reports by year
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('tahun', $year);
    }

    /**
     * Scope for reports by month
     */
    public function scopeByMonth($query, $month)
    {
        return $query->where('bulan', $month);
    }
}
