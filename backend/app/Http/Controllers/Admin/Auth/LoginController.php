<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi inputan email dan password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Ambil kredensial dari request
        $credentials = $request->only('email', 'password');

        // Cek apakah kredensial valid
        if (Auth::guard('admin')->attempt($credentials)) {
            // Ambil user yang sedang login
            $user = Auth::guard('admin')->user();

            // Cek role user dan arahkan ke halaman yang sesuai
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'user') {
                return redirect()->route('admin.berita.index');
            }

            // Default jika role tidak dikenali
            return redirect()->route('admin.berita.index');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->with('error', 'Email atau password salah');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
