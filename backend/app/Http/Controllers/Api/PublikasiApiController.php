<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublikasiApiController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $status = $request->get('status');
        
        $query = Publikasi::query()->where('is_published', true);
        
        // Filter by category
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        
        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('ringkasan', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%");
            });
        }
        
        // Filter by month (for pengaduan category)
        if ($bulan && $kategori === 'pengaduan') {
            $query->where('meta->bulan', $bulan);
        }
        
        // Filter by year
        if ($tahun) {
            $query->whereYear('published_at', $tahun);
        }
        
        // Filter by status (for pengaduan category)
        if ($status && $kategori === 'pengaduan') {
            $query->where('meta->status', $status);
        }
        
        $publikasi = $query->latest('published_at')->paginate(12);
        
        return response()->json([
            'success' => true,
            'data' => $publikasi->items(),
            'pagination' => [
                'current_page' => $publikasi->currentPage(),
                'last_page' => $publikasi->lastPage(),
                'per_page' => $publikasi->perPage(),
                'total' => $publikasi->total(),
            ]
        ]);
    }

    public function categories()
    {
        return response()->json([
            'pengaduan' => 'Laporan Pengaduan',
            'penerima' => 'Laporan Penerimaan',
            'surveikepuasan' => 'Survei Kepuasan Masyarakat',
            'surveievaluasi' => 'Survei Evaluasi Pelayanan Publik'
        ]);
    }

    public function show(Publikasi $publikasi)
    {
        if (!$publikasi->is_published) {
            abort(404);
        }
        return response()->json([
            'success' => true,
            'data' => $publikasi
        ]);
    }

    public function statistics(Request $request)
    {
        $kategori = $request->get('kategori');
        
        if ($kategori === 'pengaduan') {
            // Statistics specific to pengaduan category
            $totalPublished = Publikasi::where('kategori', 'pengaduan')
                ->where('is_published', true)
                ->count();
                
            $totalReports = Publikasi::where('kategori', 'pengaduan')
                ->where('is_published', true)
                ->count();
                
            $processedReports = Publikasi::where('kategori', 'pengaduan')
                ->where('is_published', true)
                ->where('meta->status', 'diproses')
                ->count();
                
            $completedReports = Publikasi::where('kategori', 'pengaduan')
                ->where('is_published', true)
                ->where('meta->status', 'selesai')
                ->count();
                
            return response()->json([
                'success' => true,
                'data' => [
                    'total_published' => $totalPublished,
                    'total_reports' => $totalReports,
                    'processed_reports' => $processedReports,
                    'completed_reports' => $completedReports
                ]
            ]);
        }
        
        // Default statistics for other categories
        $totalPublished = Publikasi::where('kategori', $kategori)
            ->where('is_published', true)
            ->count();
            
        return response()->json([
            'success' => true,
            'data' => [
                'total_published' => $totalPublished
            ]
        ]);
    }

    public function getMonths(Request $request)
    {
        $kategori = $request->get('kategori');
        
        if ($kategori === 'pengaduan') {
            // Get available months for pengaduan category
            $months = Publikasi::where('kategori', 'pengaduan')
                ->where('is_published', true)
                ->whereNotNull('meta->bulan')
                ->distinct()
                ->pluck('meta->bulan')
                ->filter()
                ->values();
                
            return response()->json([
                'success' => true,
                'data' => $months
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    public function getYears(Request $request)
    {
        $kategori = $request->get('kategori');
        
        $query = Publikasi::where('is_published', true);
        
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        
        $years = $query->whereNotNull('published_at')
            ->distinct()
            ->pluck(\DB::raw('YEAR(published_at)'))
            ->filter()
            ->sort()
            ->values();
            
        return response()->json([
            'success' => true,
            'data' => $years
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:pengaduan,penerima,surveikepuasan,surveievaluasi',
            'ringkasan' => 'nullable|string',
            'isi' => 'nullable|string',
            'file_path' => 'nullable|string',
            'published_at' => 'nullable|date',
            'meta' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['slug'] = \Str::slug($request->judul);
        $data['is_published'] = true;
        
        if (!$request->has('published_at')) {
            $data['published_at'] = now();
        }

        $publikasi = Publikasi::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Publikasi berhasil ditambahkan',
            'data' => $publikasi
        ], 201);
    }

    public function update(Request $request, Publikasi $publikasi)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|required|in:pengaduan,penerima,surveikepuasan,surveievaluasi',
            'ringkasan' => 'nullable|string',
            'isi' => 'nullable|string',
            'file_path' => 'nullable|string',
            'published_at' => 'nullable|date',
            'meta' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        
        if ($request->has('judul')) {
            $data['slug'] = \Str::slug($request->judul);
        }

        $publikasi->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Publikasi berhasil diperbarui',
            'data' => $publikasi
        ]);
    }

    public function destroy(Publikasi $publikasi)
    {
        $publikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Publikasi berhasil dihapus'
        ]);
    }
}


