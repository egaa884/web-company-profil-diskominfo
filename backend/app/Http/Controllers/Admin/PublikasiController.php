<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    public function index()
    {
        $publikasis = Publikasi::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.publikasi.index', compact('publikasis'));
    }

    public function create()
    {
        return view('admin.publikasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:pengaduan,penerima,surveikepuasan,surveievaluasi',
            'ringkasan' => 'nullable|string',
            'isi' => 'nullable|string',
            'file_path' => 'nullable|string',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:10240', // 10MB max
            'published_at' => 'nullable|date',
            'is_published' => 'boolean'
        ]);

        // Handle file upload if provided
        $filePath = $request->file_path;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store file in public/uploads/publikasi directory
            $filePath = $file->storeAs('uploads/publikasi', $fileName, 'public');
            $filePath = '/storage/' . $filePath;
        }

        // Generate slug from judul
        $slug = Str::slug($request->judul);
        
        // Ensure slug is unique
        $counter = 1;
        $originalSlug = $slug;
        while (Publikasi::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $publikasi = Publikasi::create([
            'judul' => $request->judul,
            'slug' => $slug,
            'kategori' => $request->kategori,
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'file_path' => $filePath,
            'published_at' => $request->published_at ?: now(),
            'is_published' => $request->has('is_published'),
            'meta' => $this->generateMetaData($request->kategori)
        ]);

        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Publikasi berhasil ditambahkan!');
    }

    public function show($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        return view('admin.publikasi.show', compact('publikasi'));
    }

    public function edit($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        return view('admin.publikasi.edit', compact('publikasi'));
    }

    public function update(Request $request, $id)
    {
        $publikasi = Publikasi::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:pengaduan,penerima,surveikepuasan,surveievaluasi',
            'ringkasan' => 'nullable|string',
            'isi' => 'nullable|string',
            'file_path' => 'nullable|string',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:10240',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean'
        ]);

        // Handle file upload if provided
        $filePath = $request->file_path;
        if ($request->hasFile('file_upload')) {
            // Delete old file if exists
            if ($publikasi->file_path && Storage::disk('public')->exists(str_replace('/storage/', '', $publikasi->file_path))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $publikasi->file_path));
            }
            
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store file in public/uploads/publikasi directory
            $filePath = $file->storeAs('uploads/publikasi', $fileName, 'public');
            $filePath = '/storage/' . $filePath;
        }

        // Generate new slug if judul changed
        $slug = $publikasi->slug;
        if ($publikasi->judul !== $request->judul) {
            $slug = Str::slug($request->judul);
            
            // Ensure slug is unique
            $counter = 1;
            $originalSlug = $slug;
            while (Publikasi::where('slug', $slug)->where('id', '!=', $publikasi->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $publikasi->update([
            'judul' => $request->judul,
            'slug' => $slug,
            'kategori' => $request->kategori,
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'file_path' => $filePath,
            'published_at' => $request->published_at ?: $publikasi->published_at,
            'is_published' => $request->has('is_published'),
            'meta' => $this->generateMetaData($request->kategori)
        ]);

        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Publikasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        // Delete associated file if exists
        if ($publikasi->file_path && Storage::disk('public')->exists(str_replace('/storage/', '', $publikasi->file_path))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $publikasi->file_path));
        }
        
        $publikasi->delete();
        
        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Publikasi berhasil dihapus!');
    }

    private function generateMetaData($kategori)
    {
        switch ($kategori) {
            case 'pengaduan':
                return [
                    'status' => 'pending',
                    'total_laporan' => 0
                ];
            case 'surveikepuasan':
                return [
                    'tahun' => date('Y'),
                    'total_responden' => 0,
                    'tingkat_kepuasan' => 0
                ];
            case 'surveievaluasi':
                return [
                    'tahun' => date('Y'),
                    'total_responden' => 0,
                    'skor_evaluasi' => 0
                ];
            default:
                return [];
        }
    }
}


