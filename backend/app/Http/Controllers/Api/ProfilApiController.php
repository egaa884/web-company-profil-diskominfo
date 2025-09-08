<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Profil::query();
        
        // Filter by category if provided
        if ($request->has('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }
        
        return $query->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori' => 'required|string',
            'konten' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('profil', 'public');
        }

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('profil', 'public');
        }

        $profil = Profil::create($data);
        return response()->json($profil, 201);
    }

    public function show(Profil $profil)
    {
        return $profil;
    }

    public function update(Request $request, Profil $profil)
    {
        $data = $request->validate([
            'kategori' => 'required|string',
            'konten' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            if ($profil->gambar) {
                Storage::disk('public')->delete($profil->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('profil', 'public');
        }

        if ($request->hasFile('pdf')) {
            if ($profil->pdf) {
                Storage::disk('public')->delete($profil->pdf);
            }
            $data['pdf'] = $request->file('pdf')->store('profil', 'public');
        }

        $profil->update($data);
        return $profil;
    }

    public function destroy(Profil $profil)
    {
        if ($profil->pdf) {
            Storage::disk('public')->delete($profil->pdf);
        }
        if ($profil->gambar) {
            Storage::disk('public')->delete($profil->gambar);
        }
        $profil->delete();
        return response()->json(['message' => 'deleted']);
    }

    public function uploadPdf(Request $request, Profil $profil)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:2048',
        ]);
        if ($profil->pdf) {
            Storage::disk('public')->delete($profil->pdf);
        }
        $profil->pdf = $request->file('pdf')->store('profil', 'public');
        $profil->save();
        return $profil;
    }

    public function uploadGambar(Request $request, Profil $profil)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($profil->gambar) {
            Storage::disk('public')->delete($profil->gambar);
        }
        $profil->gambar = $request->file('gambar')->store('profil', 'public');
        $profil->save();
        return $profil;
    }

    public function byCategory($kategori)
    {
        $profil = Profil::whereRaw('LOWER(kategori) = ?', [strtolower($kategori)])->first();
        return response()->json($profil);
    }

    public function categories()
    {
        // Get all unique categories
        $categories = Profil::distinct()
            ->pluck('kategori')
            ->filter()
            ->values();
        return response()->json($categories);
    }

    public function getAllCategories()
    {
        // Get all profil data grouped by category
        $profils = Profil::all()->groupBy('kategori');
        return response()->json($profils);
    }
} 