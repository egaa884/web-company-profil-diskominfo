<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login dengan guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = Auth::guard('admin')->user();
        
        // Cek apakah role adalah admin atau user
        if (!in_array($admin->role, ['admin', 'user'])) {
            return redirect()->route('admin.login')->with('error', 'Role tidak valid.');
        }

        return $next($request);
    }
}
