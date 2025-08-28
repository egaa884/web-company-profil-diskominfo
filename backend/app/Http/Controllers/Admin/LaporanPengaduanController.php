<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LaporanPengaduanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

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

        return view('admin.laporan_pengaduan.index', compact('laporanPengaduan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.laporan_pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
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

        $data = $request->all();
        $data['admin_id'] = Auth::guard('admin')->id();
        $data['tanggal_pengaduan'] = now();

        if ($request->hasFile('file_lampiran')) {
            $data['file_lampiran'] = $request->file('file_lampiran')->store('laporan-pengaduan', 'public');
        }

        LaporanPengaduan::create($data);

        return redirect()->route('admin.laporan-pengaduan.index')
            ->with('success', 'Laporan pengaduan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanPengaduan $laporanPengaduan)
    {
        return view('admin.laporan_pengaduan.show', compact('laporanPengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanPengaduan $laporanPengaduan)
    {
        return view('admin.laporan_pengaduan.edit', compact('laporanPengaduan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaporanPengaduan $laporanPengaduan)
    {
        $request->validate([
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

        return redirect()->route('admin.laporan-pengaduan.index')
            ->with('success', 'Laporan pengaduan berhasil diperbarui.');
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

        return redirect()->route('admin.laporan-pengaduan.index')
            ->with('success', 'Laporan pengaduan berhasil dihapus.');
    }

    /**
     * Update status of the complaint
     */
    public function updateStatus(Request $request, LaporanPengaduan $laporanPengaduan)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $data = [
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ];

        // Set completion date if status is completed
        if ($request->status === 'selesai' && $laporanPengaduan->status !== 'selesai') {
            $data['tanggal_selesai'] = now();
        }

        $laporanPengaduan->update($data);

        return redirect()->route('admin.laporan-pengaduan.index')
            ->with('success', 'Status laporan pengaduan berhasil diperbarui.');
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(LaporanPengaduan $laporanPengaduan)
    {
        if (!$laporanPengaduan->file_lampiran) {
            return redirect()->back()->with('error', 'File lampiran tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $laporanPengaduan->file_lampiran);
        
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File lampiran tidak ditemukan.');
        }

        return response()->download($path, $laporanPengaduan->file_name);
    }
}
