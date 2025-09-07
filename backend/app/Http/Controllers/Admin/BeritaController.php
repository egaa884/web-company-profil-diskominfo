<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        
        $this->middleware(function ($request, $next) {
            $user = Auth::guard('admin')->user();
            
            if ($user->role === 'user') {
                $allowedMethods = ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'];
                if (!in_array($request->route()->getActionMethod(), $allowedMethods)) {
                    return redirect()->route('admin.berita.index')->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
                }
            }
            
            return $next($request);
        });
    }

    // Menampilkan daftar berita dengan pagination dan filter
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category');
        
        if ($selectedCategory) {
            $beritas = Berita::where('category', $selectedCategory)->latest()->paginate(10);
        } else {
            $beritas = Berita::latest()->paginate(10);
        }
        
        $categories = self::categories(); 

        return view('admin.berita.index', compact('beritas', 'categories', 'selectedCategory'));
    }

    public function show(Berita $berita)
    {
        \Log::info('User trying to view berita', [
            'berita_id' => $berita->id,
            'berita_judul' => $berita->judul,
            'user_id' => Auth::guard('admin')->user()->id ?? 'not logged in'
        ]);
        
        return view('admin.berita.show', compact('berita'));
    }

    public static function categories()
    {
        return [
            'Berita Kominfo Madiun',
            'Madiun Today',
            'Kabar Warga',
            'Arsip Berita',
            'Radio Suara Madiun',
            'Siaran Pers Madiun',
            'Infografis Madiun',
        ];
    }

    private function generateUniqueSlug($title, $excludeId = null)
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        $query = Berita::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $query = Berita::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            $counter++;
        }

        return $slug;
    }

    public function create()
    {
        $categories = self::categories();
        return view('admin.berita.create', compact('categories'));
    }

    private function handleImageUpload($file, $oldImage = null)
    {
        try {
            if (!$file->isValid()) {
                throw new \Exception('File tidak valid');
            }

            $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                throw new \Exception('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
            }

            if ($file->getSize() > 2 * 1024 * 1024) {
                throw new \Exception('Ukuran file terlalu besar. Maksimal 2MB.');
            }

            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'berita/' . $fileName;

            $file->storeAs('berita', $fileName, 'public');

            try {
                $manager = new ImageManager(new Driver());
                $image = $manager->read(storage_path('app/public/' . $path));
                
                if ($image->width() > 1200) {
                    $image->resize(1200, null);
                }
                
                $image->save(storage_path('app/public/' . $path), 85);
            } catch (\Exception $e) {
                Log::warning('Image optimization failed, using original', [
                    'error' => $e->getMessage(),
                    'path' => $path
                ]);
            }

            Log::info('Image uploaded successfully', ['path' => $path]);
            return $path;

        } catch (\Exception $e) {
            Log::error('Image upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            throw $e;
        }
    }

    private function handlePdfUpload($file, $oldPdf = null)
    {
        try {
            if (!$file->isValid()) {
                throw new \Exception('File tidak valid');
            }

            $allowedMimes = ['application/pdf'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                throw new \Exception('Format file tidak didukung. Gunakan file PDF.');
            }

            if ($file->getSize() > 10 * 1024 * 1024) {
                throw new \Exception('Ukuran file terlalu besar. Maksimal 10MB.');
            }

            if ($oldPdf && Storage::disk('public')->exists($oldPdf)) {
                Storage::disk('public')->delete($oldPdf);
            }

            $fileName = time() . '_' . Str::random(10) . '.pdf';
            $path = 'pdf/' . $fileName;

            $file->storeAs('pdf', $fileName, 'public');

            Log::info('PDF uploaded successfully', ['path' => $path]);
            return $path;

        } catch (\Exception $e) {
            Log::error('PDF upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);
            throw $e;
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'konten' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'lampiran_pdf' => 'nullable|mimes:pdf|max:10240',
                'status' => 'required|in:draft,published',
                'category' => 'required|string',
                // Hapus validasi ini jika kolom tidak ada di database
                'nama_pembuat' => 'nullable|string|max:255', 
                'deskripsi_singkat' => 'nullable|string', 
            ]);

            // Mengambil semua data kecuali yang tidak ada di database
            $data = $request->except(['nama_pembuat', 'deskripsi_singkat']);
            $data['slug'] = $this->generateUniqueSlug($request->judul);
            $data['admin_id'] = Auth::guard('admin')->id();

            if ($request->hasFile('gambar')) {
                $data['gambar'] = $this->handleImageUpload($request->file('gambar'));
            }

            if ($request->hasFile('lampiran_pdf')) {
                $data['lampiran_pdf'] = $this->handlePdfUpload($request->file('lampiran_pdf'));
            }

            if ($request->status === 'published') {
                $data['published_at'] = now();
            }

            Berita::create($data);
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Berita creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::guard('admin')->id()
            ]);
            
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan berita: ' . $e->getMessage()]);
        }
    }

    public function edit(Berita $berita)
    {
        $user = Auth::guard('admin')->user();
        \Log::info('User trying to edit berita', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
            'berita_id' => $berita->id
        ]);
        $categories = self::categories();
        return view('admin.berita.edit', compact('berita', 'categories'));
    }

    public function update(Request $request, Berita $berita)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'konten' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'lampiran_pdf' => 'nullable|mimes:pdf|max:10240',
                'status' => 'required|in:draft,published',
                'category' => 'required|string',
                // Hapus validasi ini jika kolom tidak ada di database
                'nama_pembuat' => 'nullable|string|max:255',
                'deskripsi_singkat' => 'nullable|string',
            ]);
            
            // Mengambil semua data kecuali yang tidak ada di database
            $data = $request->except(['nama_pembuat', 'deskripsi_singkat']);
            $data['slug'] = $this->generateUniqueSlug($request->judul, $berita->id);

            if ($request->hasFile('gambar')) {
                $data['gambar'] = $this->handleImageUpload($request->file('gambar'), $berita->gambar);
            }

            if ($request->hasFile('lampiran_pdf')) {
                $data['lampiran_pdf'] = $this->handlePdfUpload($request->file('lampiran_pdf'), $berita->lampiran_pdf);
            }

            if ($request->status === 'published' && !$berita->published_at) {
                $data['published_at'] = now();
            }

            $berita->update($data);
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Berita update failed', [
                'error' => $e->getMessage(),
                'berita_id' => $berita->id,
                'user_id' => Auth::guard('admin')->id()
            ]);
            
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui berita: ' . $e->getMessage()]);
        }
    }

    public function destroy(Berita $berita)
    {
        try {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            if ($berita->lampiran_pdf && Storage::disk('public')->exists($berita->lampiran_pdf)) {
                Storage::disk('public')->delete($berita->lampiran_pdf);
            }

            $berita->delete();
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Berita deletion failed', [
                'error' => $e->getMessage(),
                'berita_id' => $berita->id
            ]);
            
            return back()->withErrors(['error' => 'Gagal menghapus berita: ' . $e->getMessage()]);
        }
    }
}