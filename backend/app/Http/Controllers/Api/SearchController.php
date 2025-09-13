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
        $limit = $request->get('limit', 5); // Default to 5 for auto-suggest
        $type = $request->get('type', null); // For auto-suggest filtering

        if (empty($query)) {
            return response()->json([
                'query' => $query,
                'results' => [
                    'berita' => [],
                    'profil' => [],
                    'faq' => [],
                    'publikasi' => [],
                    'menu' => []
                ],
                'total' => 0
            ]);
        }

        $results = [];

        // If type is specified (auto-suggest), only search that type
        if ($type === 'berita') {
            // Determine search mode based on query length
            $searchPattern = strlen($query) === 1
                ? "{$query}%"          // Prefix search for single character
                : "%{$query}%";        // Contains search for multiple characters

            $beritaResults = Berita::where('status', 'published')
                ->whereRaw('LOWER(judul) LIKE LOWER(?)', [$searchPattern]) // Case-insensitive
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($berita) {
                    return [
                        'id' => $berita->id,
                        'judul' => $berita->judul,
                        'slug' => $berita->slug,
                        'type' => 'berita',
                        'url' => '/berita/' . $berita->slug
                    ];
                });

            return response()->json([
                'query' => $query,
                'results' => [
                    'berita' => $beritaResults,
                    'profil' => [],
                    'faq' => [],
                    'publikasi' => [],
                    'menu' => []
                ],
                'total' => $beritaResults->count()
            ]);
        }

        // Global search across all sources
        // Determine search mode based on query length
        $searchPattern = strlen($query) === 1
            ? "{$query}%"          // Prefix search for single character
            : "%{$query}%";        // Contains search for multiple characters

        // Search in Berita
        $beritaResults = Berita::where('status', 'published')
            ->whereRaw('LOWER(judul) LIKE LOWER(?)', [$searchPattern])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($berita) {
                return [
                    'id' => $berita->id,
                    'judul' => $berita->judul,
                    'slug' => $berita->slug,
                    'type' => 'berita',
                    'url' => '/berita/' . $berita->slug
                ];
            });

        // Search in Profil
        $profilResults = Profil::whereRaw('LOWER(judul) LIKE LOWER(?)', [$searchPattern])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($profil) {
                return [
                    'id' => $profil->id,
                    'judul' => $profil->judul ?: 'Profil',
                    'slug' => $profil->id,
                    'type' => 'profil',
                    'url' => '/profil'
                ];
            });

        // Search in FAQ
        $faqResults = Faq::whereRaw('LOWER(question) LIKE LOWER(?)', [$searchPattern])
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($faq) {
                return [
                    'id' => $faq->id,
                    'judul' => $faq->question,
                    'slug' => $faq->id,
                    'type' => 'faq',
                    'url' => '/faq'
                ];
            });

        // Search in Publikasi
        $publikasiResults = Publikasi::whereRaw('LOWER(judul) LIKE LOWER(?)', [$searchPattern])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($publikasi) {
                return [
                    'id' => $publikasi->id,
                    'judul' => $publikasi->judul,
                    'slug' => $publikasi->id,
                    'type' => 'publikasi',
                    'url' => '/pengaduan'
                ];
            });

        // Static menu items that match the search
        $menuItems = [];
        $staticMenus = [
            ['id' => 'beranda', 'judul' => 'Beranda', 'url' => '/home'],
            ['id' => 'radio', 'judul' => 'Radio Suara Madiun', 'url' => '/radio'],
            ['id' => 'survei-kepuasan', 'judul' => 'Survei Kepuasan Masyarakat', 'url' => '/surveikepuasan'],
            ['id' => 'survei-evaluasi', 'judul' => 'Survei Evaluasi Pelayanan Publik', 'url' => '/surveievaluasi'],
            ['id' => 'layanan-pengaduan', 'judul' => 'Layanan Pengaduan', 'url' => '/layanan-pengaduan'],
        ];

        foreach ($staticMenus as $menu) {
            if (stripos($menu['judul'], $query) !== false) {
                $menuItems[] = [
                    'id' => $menu['id'],
                    'judul' => $menu['judul'],
                    'slug' => $menu['id'],
                    'type' => 'menu',
                    'url' => $menu['url']
                ];
            }
        }

        $total = $beritaResults->count() + $profilResults->count() + $faqResults->count() + $publikasiResults->count() + count($menuItems);

        return response()->json([
            'query' => $query,
            'results' => [
                'berita' => $beritaResults,
                'profil' => $profilResults,
                'faq' => $faqResults,
                'publikasi' => $publikasiResults,
                'menu' => $menuItems
            ],
            'total' => $total
        ]);
    }
}