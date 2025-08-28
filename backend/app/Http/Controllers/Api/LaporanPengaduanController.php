<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LaporanPengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LaporanPengaduan::with('admin');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('prioritas') && $request->prioritas !== '') {
            $query->where('prioritas', $request->prioritas);
        }

        // Search
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('nama_pelapor', 'like', "%{$search}%")
                  ->orWhere('email_pelapor', 'like', "%{$search}%")
                  ->orWhere('kategori_pengaduan', 'like', "%{$search}%");
            });
        }

        $laporanPengaduan = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $laporanPengaduan->items(),
            'pagination' => [
                'current_page' => $laporanPengaduan->currentPage(),
                'last_page' => $laporanPengaduan->lastPage(),
                'per_page' => $laporanPengaduan->perPage(),
                'total' => $laporanPengaduan->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori_pengaduan' => 'required|string|max:255',
            'nama_pelapor' => 'required|string|max:255',
            'email_pelapor' => 'required|email|max:255',
            'telepon_pelapor' => 'required|string|max:20',
            'alamat_pelapor' => 'required|string',
            'nik_pelapor' => 'required|string|size:16',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'prioritas' => 'required|in:rendah,normal,tinggi,kritis',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['tanggal_pengaduan'] = now();

        if ($request->hasFile('file_lampiran')) {
            $data['file_lampiran'] = $request->file('file_lampiran')->store('laporan-pengaduan', 'public');
        }

        $laporanPengaduan = LaporanPengaduan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Laporan pengaduan berhasil ditambahkan',
            'data' => $laporanPengaduan->load('admin')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanPengaduan $laporanPengaduan)
    {
        return response()->json([
            'success' => true,
            'data' => $laporanPengaduan->load('admin')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaporanPengaduan $laporanPengaduan)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori_pengaduan' => 'required|string|max:255',
            'nama_pelapor' => 'required|string|max:255',
            'email_pelapor' => 'required|email|max:255',
            'telepon_pelapor' => 'required|string|max:20',
            'alamat_pelapor' => 'required|string',
            'nik_pelapor' => 'required|string|size:16',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'prioritas' => 'required|in:rendah,normal,tinggi,kritis',
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        if ($request->hasFile('file_lampiran')) {
            // Delete old file if exists
            if ($laporanPengaduan->file_lampiran) {
                Storage::disk('public')->delete($laporanPengaduan->file_lampiran);
            }
            $data['file_lampiran'] = $request->file('file_lampiran')->store('laporan-pengaduan', 'public');
        }

        // Set completion date if status is completed
        if ($request->status === 'selesai' && $laporanPengaduan->status !== 'selesai') {
            $data['tanggal_selesai'] = now();
        }

        $laporanPengaduan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Laporan pengaduan berhasil diperbarui',
            'data' => $laporanPengaduan->load('admin')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanPengaduan $laporanPengaduan)
    {
        // Delete file if exists
        if ($laporanPengaduan->file_lampiran) {
            Storage::disk('public')->delete($laporanPengaduan->file_lampiran);
        }

        $laporanPengaduan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Laporan pengaduan berhasil dihapus'
        ]);
    }

    /**
     * Get categories
     */
    public function categories()
    {
        $categories = [
            'Pelayanan Publik',
            'Infrastruktur',
            'Administrasi',
            'Keamanan',
            'Kesehatan',
            'Pendidikan',
            'Transportasi',
            'Lingkungan',
        ];

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => LaporanPengaduan::count(),
            'pending' => LaporanPengaduan::pending()->count(),
            'diproses' => LaporanPengaduan::diproses()->count(),
            'selesai' => LaporanPengaduan::selesai()->count(),
            'ditolak' => LaporanPengaduan::ditolak()->count(),
            'prioritas_tinggi' => LaporanPengaduan::prioritasTinggi()->count(),
            'prioritas_kritis' => LaporanPengaduan::prioritasKritis()->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Update status of the complaint
     */
    public function updateStatus(Request $request, LaporanPengaduan $laporanPengaduan)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ];

        // Set completion date if status is completed
        if ($request->status === 'selesai' && $laporanPengaduan->status !== 'selesai') {
            $data['tanggal_selesai'] = now();
        }

        $laporanPengaduan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Status laporan pengaduan berhasil diperbarui',
            'data' => $laporanPengaduan->load('admin')
        ]);
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(LaporanPengaduan $laporanPengaduan)
    {
        if (!$laporanPengaduan->file_lampiran) {
            return response()->json([
                'success' => false,
                'message' => 'File lampiran tidak ditemukan'
            ], 404);
        }

        $path = storage_path('app/public/' . $laporanPengaduan->file_lampiran);
        
        if (!file_exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'File lampiran tidak ditemukan'
            ], 404);
        }

        return response()->download($path, $laporanPengaduan->file_name);
    }
}
