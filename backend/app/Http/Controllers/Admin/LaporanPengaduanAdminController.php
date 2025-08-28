<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPengaduanAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LaporanPengaduanAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporanPengaduan = LaporanPengaduanAdmin::with('admin')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(15);

        $statistics = [
            'total' => LaporanPengaduanAdmin::count(),
            'published' => LaporanPengaduanAdmin::where('is_published', true)->count(),
            'draft' => LaporanPengaduanAdmin::where('is_published', false)->count(),
            'this_year' => LaporanPengaduanAdmin::where('tahun', date('Y'))->count(),
        ];

        return view('admin.laporan_pengaduan_admin.index', compact('laporanPengaduan', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $tahunList = range(date('Y') - 2, date('Y') + 1);

        return view('admin.laporan_pengaduan_admin.create', compact('bulanList', 'tahunList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|integer|min:2020|max:2030',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
            'ringkasan' => 'nullable|string',
            'total_pengaduan' => 'required|integer|min:0',
            'pengaduan_diproses' => 'required|integer|min:0',
            'pengaduan_selesai' => 'required|integer|min:0',
            'pengaduan_ditolak' => 'required|integer|min:0',
            'catatan_admin' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        // Check if report for this month and year already exists
        $existingReport = LaporanPengaduanAdmin::where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

        if ($existingReport) {
            return back()->withErrors(['bulan' => 'Laporan untuk bulan ' . $request->bulan . ' tahun ' . $request->tahun . ' sudah ada.']);
        }

        $data = $request->all();
        $data['admin_id'] = Auth::id();

        // Handle file upload
        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $fileName = 'laporan_pengaduan_' . Str::slug($request->bulan) . '_' . $request->tahun . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('laporan_pengaduan', $fileName, 'public');
            $data['file_lampiran'] = $filePath;
        }

        // Set publication date if published
        if ($request->boolean('is_published')) {
            $data['tanggal_publikasi'] = now();
        }

        LaporanPengaduanAdmin::create($data);

        return redirect()->route('admin.laporan-pengaduan-admin.index')
            ->with('success', 'Laporan pengaduan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanPengaduanAdmin $laporanPengaduanAdmin)
    {
        $laporanPengaduanAdmin->load('admin');
        return view('admin.laporan_pengaduan_admin.show', compact('laporanPengaduanAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanPengaduanAdmin $laporanPengaduanAdmin)
    {
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $tahunList = range(date('Y') - 2, date('Y') + 1);

        return view('admin.laporan_pengaduan_admin.edit', compact('laporanPengaduanAdmin', 'bulanList', 'tahunList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaporanPengaduanAdmin $laporanPengaduanAdmin)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'bulan' => 'required|string|max:20',
            'tahun' => 'required|integer|min:2020|max:2030',
            'file_lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
            'ringkasan' => 'nullable|string',
            'total_pengaduan' => 'required|integer|min:0',
            'pengaduan_diproses' => 'required|integer|min:0',
            'pengaduan_selesai' => 'required|integer|min:0',
            'pengaduan_ditolak' => 'required|integer|min:0',
            'catatan_admin' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        // Check if report for this month and year already exists (excluding current record)
        $existingReport = LaporanPengaduanAdmin::where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('id', '!=', $laporanPengaduanAdmin->id)
            ->first();

        if ($existingReport) {
            return back()->withErrors(['bulan' => 'Laporan untuk bulan ' . $request->bulan . ' tahun ' . $request->tahun . ' sudah ada.']);
        }

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('file_lampiran')) {
            // Delete old file if exists
            if ($laporanPengaduanAdmin->file_lampiran) {
                Storage::disk('public')->delete($laporanPengaduanAdmin->file_lampiran);
            }

            $file = $request->file('file_lampiran');
            $fileName = 'laporan_pengaduan_' . Str::slug($request->bulan) . '_' . $request->tahun . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('laporan_pengaduan', $fileName, 'public');
            $data['file_lampiran'] = $filePath;
        }

        // Handle publication status
        if ($request->boolean('is_published') && !$laporanPengaduanAdmin->is_published) {
            $data['tanggal_publikasi'] = now();
        } elseif (!$request->boolean('is_published')) {
            $data['tanggal_publikasi'] = null;
        }

        $laporanPengaduanAdmin->update($data);

        return redirect()->route('admin.laporan-pengaduan-admin.index')
            ->with('success', 'Laporan pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanPengaduanAdmin $laporanPengaduanAdmin)
    {
        // Delete file if exists
        if ($laporanPengaduanAdmin->file_lampiran) {
            Storage::disk('public')->delete($laporanPengaduanAdmin->file_lampiran);
        }

        $laporanPengaduanAdmin->delete();

        return redirect()->route('admin.laporan-pengaduan-admin.index')
            ->with('success', 'Laporan pengaduan berhasil dihapus.');
    }

    /**
     * Toggle publication status
     */
    public function togglePublish(LaporanPengaduanAdmin $laporanPengaduanAdmin)
    {
        $laporanPengaduanAdmin->update([
            'is_published' => !$laporanPengaduanAdmin->is_published,
            'tanggal_publikasi' => !$laporanPengaduanAdmin->is_published ? now() : null,
        ]);

        $status = $laporanPengaduanAdmin->is_published ? 'dipublikasi' : 'disimpan sebagai draft';
        
        return redirect()->route('admin.laporan-pengaduan-admin.index')
            ->with('success', "Laporan pengaduan berhasil {$status}.");
    }

    /**
     * Download the attached file
     */
    public function downloadFile(LaporanPengaduanAdmin $laporanPengaduanAdmin)
    {
        if (!$laporanPengaduanAdmin->file_lampiran) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $laporanPengaduanAdmin->file_lampiran);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        return response()->download($filePath, $laporanPengaduanAdmin->file_name);
    }
}
