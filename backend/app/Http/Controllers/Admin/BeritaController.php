<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function __construct()
    {
        // Middleware untuk membatasi akses berdasarkan role
        $this->middleware('auth:admin');
        
        // Middleware untuk membatasi akses berdasarkan role
        $this->middleware(function ($request, $next) {
            $user = Auth::guard('admin')->user();
            
            // Jika user dengan role 'user', izinkan akses ke semua method berita
            if ($user->role === 'user') {
                $allowedMethods = ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'];
                if (!in_array($request->route()->getActionMethod(), $allowedMethods)) {
                    return redirect()->route('admin.berita.index')->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
                }
            }
            
            return $next($request);
        });
    }

    // Menampilkan daftar berita dengan pagination
    public function index()
    {
        $beritas = Berita::latest()->paginate(10); // Menggunakan pagination
        return view('admin.berita.index', compact('beritas'));
    }

    // Menampilkan detail berita (untuk user)
    public function show(Berita $berita)
    {
        // Debug: cek berita
        \Log::info('User trying to view berita', [
            'berita_id' => $berita->id,
            'berita_judul' => $berita->judul,
            'user_id' => Auth::guard('admin')->user()->id ?? 'not logged in'
        ]);
        
        return view('admin.berita.show', compact('berita'));
    }

    // Daftar kategori berita
    private static function categories()
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

    // Menampilkan form untuk membuat berita baru
    public function create()
    {
        $categories = self::categories();
        return view('admin.berita.create', compact('categories'));
    }

    // Menyimpan berita baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published',
            'category' => 'required|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);
        $data['admin_id'] = Auth::guard('admin')->id();

        // Menyimpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        // Jika status published, set published_at
        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit berita
    public function edit(Berita $berita)
    {
        // Debug: cek role user
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

    // Memperbarui data berita di database
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published',
            'category' => 'required|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);

        // Memperbarui gambar jika ada
        if ($request->hasFile('gambar')) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        // Jika status published dan belum ada published_at
        if ($request->status === 'published' && !$berita->published_at) {
            $data['published_at'] = now();
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    // Menghapus berita
    public function destroy(Berita $berita)
    {
        // Hapus gambar jika ada
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
