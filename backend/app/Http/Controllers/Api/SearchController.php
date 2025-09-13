<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Profil;
use App\Models\Faq;
use App\Models\Publikasi;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        if (empty($query)) {
            return response()->json([
                'query' => $query,
                'results' => [
                    'berita' => [],
                    'profil' => [],
                    'faq' => [],
                    'publikasi' => []
                ],
                'total' => 0
            ]);
        }

        $results = [];

        // Search in Berita
        $beritaResults = Berita::where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('judul', 'LIKE', "%{$query}%")
                  ->orWhere('konten', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%");
            })
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($berita) {
                if ($berita->gambar) {
                    $berita->gambar_url = url('storage/' . $berita->gambar);
                }
                if ($berita->pdf) {
                    $berita->pdf_url = url('storage/' . $berita->pdf);
                }
                return [
                    'id' => $berita->id,
                    'judul' => $berita->judul,
                    'slug' => $berita->slug,
                    'isi' => $berita->konten,
                    'category' => $berita->category,
                    'gambar_url' => $berita->gambar_url ?? null,
                    'pdf_url' => $berita->pdf_url ?? null,
                    'created_at' => $berita->created_at,
                    'type' => 'berita',
                    'url' => '/berita/' . $berita->slug
                ];
            });

        // Search in Profil
        $profilResults = Profil::where(function ($q) use ($query) {
                $q->where('judul', 'LIKE', "%{$query}%")
                  ->orWhere('konten', 'LIKE', "%{$query}%")
                  ->orWhere('kategori', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($profil) {
                return [
                    'id' => $profil->id,
                    'judul' => $profil->judul,
                    'isi' => $profil->konten,
                    'kategori' => $profil->kategori,
                    'created_at' => $profil->created_at,
                    'type' => 'profil',
                    'url' => '/profil'
                ];
            });

        // Search in FAQ
        $faqResults = Faq::where(function ($q) use ($query) {
                $q->where('question', 'LIKE', "%{$query}%")
                  ->orWhere('answer', 'LIKE', "%{$query}%");
            })
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($faq) {
                return [
                    'id' => $faq->id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                    'category' => $faq->category ? $faq->category->name : null,
                    'created_at' => $faq->created_at,
                    'type' => 'faq',
                    'url' => '/faq'
                ];
            });

        // Search in Publikasi
        $publikasiResults = Publikasi::where(function ($q) use ($query) {
                $q->where('judul', 'LIKE', "%{$query}%")
                  ->orWhere('ringkasan', 'LIKE', "%{$query}%")
                  ->orWhere('isi', 'LIKE', "%{$query}%")
                  ->orWhere('kategori', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($publikasi) {
                return [
                    'id' => $publikasi->id,
                    'judul' => $publikasi->judul,
                    'deskripsi' => $publikasi->ringkasan ?? $publikasi->isi,
                    'kategori' => $publikasi->kategori,
                    'file_path' => $publikasi->file_path,
                    'created_at' => $publikasi->created_at,
                    'type' => 'publikasi',
                    'url' => '/pengaduan' // Adjust URL as needed
                ];
            });

        $total = $beritaResults->count() + $profilResults->count() + $faqResults->count() + $publikasiResults->count();

        return response()->json([
            'query' => $query,
            'results' => [
                'berita' => $beritaResults,
                'profil' => $profilResults,
                'faq' => $faqResults,
                'publikasi' => $publikasiResults
            ],
            'total' => $total
        ]);
    }
}