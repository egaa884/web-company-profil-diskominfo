<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infografis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InfografisController extends Controller
{
    public function __construct()
    {
        // Middleware untuk membatasi akses infografis hanya untuk admin
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (Auth::guard('admin')->user()->role !== 'admin') {
                return redirect()->route('admin.berita.index')->with('error', 'Anda tidak memiliki akses ke halaman infografis.');
            }
            return $next($request);
        });
    }

    // Menampilkan daftar infografis
    public function index()
    {
        $infografis = Infografis::latest()->get(); // Mengambil semua infografis terbaru
        return view('admin.infografis.index', compact('infografis'));
    }

    // Menampilkan form untuk menambah infografis
    public function create()
    {
        return view('admin.infografis.create');
    }

    // Menyimpan infografis baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required' => 'Judul infografis harus diisi.',
            'deskripsi.required' => 'Deskripsi infografis harus diisi.',
            'tanggal.required' => 'Tanggal infografis harus diisi.',
        ]);

        // Menyimpan gambar
        $gambarPath = $request->file('gambar')->store('infografis', 'public');

        // Menyimpan infografis ke database
        Infografis::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => Carbon::parse($request->tanggal), // Convert to Carbon instance
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.infografis.index')->with('success', 'Infografis berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit infografis
    public function edit(Infografis $infografis)
    {
        $infografis->tanggal = \Carbon\Carbon::parse($infografis->tanggal);
        return view('admin.infografis.edit', compact('infografis'));
    }

    // Memperbarui infografis di database
    public function update(Request $request, Infografis $infografis)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required' => 'Judul infografis harus diisi.',
            'deskripsi.required' => 'Deskripsi infografis harus diisi.',
            'tanggal.required' => 'Tanggal infografis harus diisi.',
        ]);

        // Jika ada gambar baru, hapus gambar lama dan simpan gambar baru
        if ($request->hasFile('gambar')) {
            // Cek jika gambar lama ada dan hapus dari penyimpanan
            if ($infografis->gambar && Storage::disk('public')->exists($infografis->gambar)) {
                Storage::disk('public')->delete($infografis->gambar);
            }

            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->storeAs('infografis', time() . '-' . $request->file('gambar')->getClientOriginalName(), 'public');

            
            $infografis->gambar = $gambarPath;
        }

        // Update infografis
        $infografis->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => Carbon::parse($request->tanggal), // Convert to Carbon instance
        ]);

        return redirect()->route('admin.infografis.index')->with('success', 'Infografis berhasil diperbarui.');
    }

    // Menghapus infografis
    public function destroy(Infografis $infografis)
    {
        // Hapus gambar dari storage jika ada
        if ($infografis->gambar && Storage::disk('public')->exists($infografis->gambar)) {
            Storage::disk('public')->delete($infografis->gambar);
        }

        // Hapus infografis dari database
        $infografis->delete();

        return redirect()->route('admin.infografis.index')->with('success', 'Infografis berhasil dihapus.');
    }
}
