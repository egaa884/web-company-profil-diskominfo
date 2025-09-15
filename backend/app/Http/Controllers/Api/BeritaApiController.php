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
            if ($berita->lampiran_pdf) {
                // Handle both old format (pdf/filename.pdf) and new format (berita/filename.pdf)
                $pdfPath = $berita->lampiran_pdf;
                if (!str_contains($pdfPath, '/')) {
                    // If no directory specified, assume it's in berita directory
                    $pdfPath = 'berita/' . $pdfPath;
                }
                $berita->pdf_url = url('storage/' . $pdfPath);
            }
        });

        return response()->json($beritas);
    }

    public function show(Berita $berita)
    {
        // Load images relationship
        $berita->load('images');

        // Increment view count (pastikan method ini ada di model Berita)
        // $berita->incrementViews(); 

        // Add full image URL if image exists
        if ($berita->gambar) {
            $berita->gambar_url = url('storage/' . $berita->gambar);
        }

        // Add full PDF URL if PDF exists
        if ($berita->lampiran_pdf) {
            // Handle both old format (pdf/filename.pdf) and new format (berita/filename.pdf)
            $pdfPath = $berita->lampiran_pdf;
            if (!str_contains($pdfPath, '/')) {
                // If no directory specified, assume it's in berita directory
                $pdfPath = 'berita/' . $pdfPath;
            }
            $berita->pdf_url = url('storage/' . $pdfPath);
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
        if ($berita->lampiran_pdf) {
            // Handle both old format (pdf/filename.pdf) and new format (berita/filename.pdf)
            $pdfPath = $berita->lampiran_pdf;
            if (!str_contains($pdfPath, '/')) {
                // If no directory specified, assume it's in berita directory
                $pdfPath = 'berita/' . $pdfPath;
            }
            $berita->pdf_url = url('storage/' . $pdfPath);
        }

        return response()->json($berita);
    }

    public function latest()
    {
        // Get latest 3 berita for the frontend news section, prioritizing those with images
        $beritas = Berita::with('images')->where('status', 'published')
            ->whereNotNull('gambar')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // If we don't have 3 items with images, get additional items without images
        if ($beritas->count() < 3) {
            $additionalCount = 3 - $beritas->count();
            $additionalBeritas = Berita::with('images')->where('status', 'published')
                ->whereNull('gambar')
                ->whereNotIn('id', $beritas->pluck('id'))
                ->orderBy('created_at', 'desc')
                ->limit($additionalCount)
                ->get();

            $beritas = $beritas->merge($additionalBeritas);
        }

        // Add full image URL and PDF URL for each berita
        $beritas->each(function ($berita) {
            if ($berita->gambar) {
                $berita->gambar_url = url('storage/' . $berita->gambar);
            }
            if ($berita->lampiran_pdf) {
                // Handle both old format (pdf/filename.pdf) and new format (berita/filename.pdf)
                $pdfPath = $berita->lampiran_pdf;
                if (!str_contains($pdfPath, '/')) {
                    // If no directory specified, assume it's in berita directory
                    $pdfPath = 'berita/' . $pdfPath;
                }
                $berita->pdf_url = url('storage/' . $pdfPath);
            }
        });

        return response()->json($beritas);
    }

    public function hotNews()
    {
        // Get hot/featured news based on is_hot flag, ordered by creation date
        $beritas = Berita::with('images')->where('status', 'published')
            ->where('is_hot', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // If no hot news is set, fall back to latest news (for backward compatibility)
        if ($beritas->isEmpty()) {
            $beritas = Berita::with('images')->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Add full image URL and PDF URL for each berita
        $beritas->each(function ($berita) {
            if ($berita->gambar) {
                $berita->gambar_url = url('storage/' . $berita->gambar);
            }
            if ($berita->lampiran_pdf) {
                // Handle both old format (pdf/filename.pdf) and new format (berita/filename.pdf)
                $pdfPath = $berita->lampiran_pdf;
                if (!str_contains($pdfPath, '/')) {
                    // If no directory specified, assume it's in berita directory
                    $pdfPath = 'berita/' . $pdfPath;
                }
                $berita->pdf_url = url('storage/' . $pdfPath);
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
            if ($berita->lampiran_pdf) {
                // Handle both old format (pdf/filename.pdf) and new format (berita/filename.pdf)
                $pdfPath = $berita->lampiran_pdf;
                if (!str_contains($pdfPath, '/')) {
                    // If no directory specified, assume it's in berita directory
                    $pdfPath = 'berita/' . $pdfPath;
                }
                $berita->pdf_url = url('storage/' . $pdfPath);
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

    public function getAdjacentNews($slug)
    {
        $currentBerita = Berita::where('slug', $slug)->where('status', 'published')->first();

        if (!$currentBerita) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        // Get previous news (older than current)
        $previous = Berita::where('status', 'published')
            ->where('created_at', '<', $currentBerita->created_at)
            ->orderBy('created_at', 'desc')
            ->first();

        // Get next news (newer than current)
        $next = Berita::where('status', 'published')
            ->where('created_at', '>', $currentBerita->created_at)
            ->orderBy('created_at', 'asc')
            ->first();

        $result = [];

        if ($previous) {
            $result['previous'] = [
                'id' => $previous->id,
                'judul' => $previous->judul,
                'slug' => $previous->slug,
                'gambar_url' => $previous->gambar ? url('storage/' . $previous->gambar) : null
            ];
        }

        if ($next) {
            $result['next'] = [
                'id' => $next->id,
                'judul' => $next->judul,
                'slug' => $next->slug,
                'gambar_url' => $next->gambar ? url('storage/' . $next->gambar) : null
            ];
        }

        return response()->json($result);
    }

    public function incrementView(Request $request, Berita $berita)
    {
        // Validate request
        $request->validate([
            'device_id' => 'required|string',
        ]);

        $deviceId = $request->device_id;

        // Check if this device has already viewed this berita
        // For simplicity, we'll use a cache or database approach
        // In a real app, you might want to create a separate table for view tracking
        $cacheKey = "berita_view_{$berita->id}_{$deviceId}";

        if (!cache()->has($cacheKey)) {
            // First view from this device, increment the count
            $berita->incrementViews();

            // Cache for 24 hours to prevent multiple views from same device
            cache()->put($cacheKey, true, 1440); // 1440 minutes = 24 hours

            return response()->json(['success' => true, 'message' => 'View counted']);
        }

        return response()->json(['success' => false, 'message' => 'View already counted for this device']);
    }
}