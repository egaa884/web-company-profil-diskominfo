<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Middleware untuk membatasi akses dashboard hanya untuk admin
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (Auth::guard('admin')->user()->role !== 'admin') {
                return redirect()->route('admin.berita.index')->with('error', 'Anda tidak memiliki akses ke dashboard.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}