<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanPengaduanAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'full_title' => $this->full_title,
            'deskripsi' => $this->deskripsi,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'period' => $this->period,
            'kategori' => $this->kategori,
            'ringkasan' => $this->ringkasan,
            'total_pengaduan' => $this->total_pengaduan,
            'pengaduan_diproses' => $this->pengaduan_diproses,
            'pengaduan_selesai' => $this->pengaduan_selesai,
            'pengaduan_ditolak' => $this->pengaduan_ditolak,
            'file_lampiran' => $this->file_url,
            'file_name' => $this->file_name,
            'is_published' => $this->is_published,
            'published_label' => $this->published_label,
            'tanggal_publikasi' => $this->tanggal_publikasi?->format('Y-m-d H:i:s'),
            'tanggal_publikasi_formatted' => $this->tanggal_publikasi?->format('d F Y H:i'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'created_at_formatted' => $this->created_at?->format('d F Y H:i'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'updated_at_formatted' => $this->updated_at?->format('d F Y H:i'),
            'admin' => $this->whenLoaded('admin', function () {
                return [
                    'id' => $this->admin->id,
                    'name' => $this->admin->name,
                    'email' => $this->admin->email,
                ];
            }),
        ];
    }
}
