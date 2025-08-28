<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanPengaduanAdmin;
use Illuminate\Http\Request;
use App\Http\Resources\LaporanPengaduanAdminResource;

class LaporanPengaduanAdminApiController extends Controller
{
    /**
     * Display a listing of published reports
     */
    public function index(Request $request)
    {
        $query = LaporanPengaduanAdmin::published()
            ->with('admin')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc');

        // Filter by year
        if ($request->filled('tahun')) {
            $query->byYear($request->tahun);
        }

        // Filter by month
        if ($request->filled('bulan')) {
            $query->byMonth($request->bulan);
        }

        // Search in title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('ringkasan', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 15);
        $laporanPengaduan = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => LaporanPengaduanAdminResource::collection($laporanPengaduan)
        ]);
    }

    /**
     * Display the specified resource
     */
    public function show(LaporanPengaduanAdmin $laporanPengaduanAdmin)
    {
        if (!$laporanPengaduanAdmin->is_published) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan'
            ], 404);
        }

        $laporanPengaduanAdmin->load('admin');
        
        return response()->json([
            'success' => true,
            'data' => new LaporanPengaduanAdminResource($laporanPengaduanAdmin)
        ]);
    }

    /**
     * Get statistics for published reports
     */
    public function statistics()
    {
        $statistics = [
            'total_published' => LaporanPengaduanAdmin::published()->count(),
            'total_reports' => LaporanPengaduanAdmin::published()->sum('total_pengaduan'),
            'processed_reports' => LaporanPengaduanAdmin::published()->sum('pengaduan_diproses'),
            'completed_reports' => LaporanPengaduanAdmin::published()->sum('pengaduan_selesai'),
            'rejected_reports' => LaporanPengaduanAdmin::published()->sum('pengaduan_ditolak'),
            'this_year_reports' => LaporanPengaduanAdmin::published()->byYear(date('Y'))->count(),
            'latest_report' => LaporanPengaduanAdmin::published()
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->first(),
        ];

        return response()->json([
            'success' => true,
            'data' => $statistics
        ]);
    }

    /**
     * Get available years
     */
    public function years()
    {
        $years = LaporanPengaduanAdmin::published()
            ->distinct()
            ->pluck('tahun')
            ->sort()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $years
        ]);
    }

    /**
     * Get available months
     */
    public function months()
    {
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return response()->json([
            'success' => true,
            'data' => $months
        ]);
    }

    /**
     * Get latest reports
     */
    public function latest(Request $request)
    {
        $limit = $request->get('limit', 5);
        
        $latestReports = LaporanPengaduanAdmin::published()
            ->with('admin')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => LaporanPengaduanAdminResource::collection($latestReports)
        ]);
    }

    /**
     * Download file
     */
    public function downloadFile(LaporanPengaduanAdmin $laporanPengaduanAdmin)
    {
        if (!$laporanPengaduanAdmin->is_published) {
            return response()->json(['message' => 'Laporan tidak ditemukan'], 404);
        }

        if (!$laporanPengaduanAdmin->file_lampiran) {
            return response()->json(['message' => 'File tidak tersedia'], 404);
        }

        $filePath = storage_path('app/public/' . $laporanPengaduanAdmin->file_lampiran);
        
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File tidak ditemukan di server'], 404);
        }

        return response()->download($filePath, $laporanPengaduanAdmin->file_name);
    }
}
