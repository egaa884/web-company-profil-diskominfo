<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('images')->orderBy('created_at', 'desc');

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter by status (only published)
        $query->where('status', 'published');

        // Get paginated results
        $beritas = $query->paginate(10);
        
        // Add full image URL and PDF URL for each berita
        $beritas->getCollection()->each(function ($berita) {
            if ($berita->gambar) {
                $berita->gambar_url = url('storage/' . $berita->gambar);
            }
            if ($berita->pdf) {
                $berita->pdf_url = url('storage/' . $berita->pdf);
            }
        });
        
        return response()->json($beritas);
    }

    public function show(Berita $berita)
    {
        // Load images relationship
        $berita->load('images');

        // Add full image URL if image exists
        if ($berita->gambar) {
            $berita->gambar_url = url('storage/' . $berita->gambar);
        }

        // Add full PDF URL if PDF exists
        if ($berita->pdf) {
            $berita->pdf_url = url('storage/' . $berita->pdf);
        }

        return response()->json($berita);
    }

    public function showBySlug($slug)
    {
        $berita = Berita::with('images')->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$berita) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        // Add full image URL if image exists
        if ($berita->gambar) {
            $berita->gambar_url = url('storage/' . $berita->gambar);
        }

        // Add full PDF URL if PDF exists
        if ($berita->pdf) {
            $berita->pdf_url = url('storage/' . $berita->pdf);
        }

        return response()->json($berita);
    }

    public function latest()
    {
        // Get latest 3 berita for the frontend news section
        $beritas = Berita::with('images')->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Add full image URL and PDF URL for each berita
        $beritas->each(function ($berita) {
            if ($berita->gambar) {
                $berita->gambar_url = url('storage/' . $berita->gambar);
            }
            if ($berita->pdf) {
                $berita->pdf_url = url('storage/' . $berita->pdf);
            }
        });

        return response()->json($beritas);
    }

    public function hotNews()
    {
        // Get hot/featured news (you can modify this logic as needed)
        $beritas = Berita::with('images')->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Add full image URL and PDF URL for each berita
        $beritas->each(function ($berita) {
            if ($berita->gambar) {
                $berita->gambar_url = url('storage/' . $berita->gambar);
            }
            if ($berita->pdf) {
                $berita->pdf_url = url('storage/' . $berita->pdf);
            }
        });

        return response()->json($beritas);
    }

    public function byCategory($category)
    {
        $beritas = Berita::with('images')->where('status', 'published')
            ->where('category', $category)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Add full image URL and PDF URL for each berita
        $beritas->getCollection()->each(function ($berita) {
            if ($berita->gambar) {
                $berita->gambar_url = url('storage/' . $berita->gambar);
            }
            if ($berita->pdf) {
                $berita->pdf_url = url('storage/' . $berita->pdf);
            }
        });

        return response()->json($beritas);
    }

    public function categories()
    {
        // Get all unique categories
        $categories = Berita::where('status', 'published')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();
        return response()->json($categories);
    }
}