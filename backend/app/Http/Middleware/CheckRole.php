<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah pengguna sudah login dengan guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = Auth::guard('admin')->user();
        
        // Jika role adalah 'admin', berikan akses penuh
        if ($role === 'admin' && $admin->role === 'admin') {
            return $next($request);
        }
        
        // Jika role adalah 'user', hanya berikan akses ke berita
        if ($role === 'user' && $admin->role === 'user') {
            // Cek apakah route yang diakses adalah untuk berita
            $currentRoute = $request->route()->getName();
            if (str_contains($currentRoute, 'berita')) {
                return $next($request);
            }
            
            // Jika bukan route berita, redirect ke halaman berita
            return redirect()->route('admin.berita.index')->with('error', 'Anda hanya dapat mengakses halaman berita.');
        }
        
        // Jika role tidak sesuai, redirect ke login
        return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}

