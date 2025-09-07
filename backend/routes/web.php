<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\InfografisController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\FaqController;
use Illuminate\Http\Request;

// Route Jembatan untuk Login Admin
// Middleware auth akan mencari rute bernama 'login', jadi kita definisikan di sini.
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


// Route untuk halaman depan
Route::get('/', function () {
    return view('welcome');
});

// Route untuk home (setelah login)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route login untuk web guard (redirect ke admin login)
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// Route test untuk debugging
Route::get('/test-user', function () {
    if (Auth::guard('admin')->check()) {
        $user = Auth::guard('admin')->user();
        return response()->json([
            'user' => $user->name,
            'role' => $user->role,
            'email' => $user->email
        ]);
    }
    return response()->json(['message' => 'Not logged in']);
});

// Route test untuk berita
Route::get('/test-berita-edit/{id}', function ($id) {
    if (Auth::guard('admin')->check()) {
        $user = Auth::guard('admin')->user();
        $allowedMethods = ['index', 'show', 'edit', 'update'];
        $currentMethod = 'edit';
        
        if ($user->role === 'user' && !in_array($currentMethod, $allowedMethods)) {
            return response()->json(['error' => 'Access denied for user']);
        }
        
        return response()->json([
            'user' => $user->name,
            'role' => $user->role,
            'method' => $currentMethod,
            'allowed' => in_array($currentMethod, $allowedMethods)
        ]);
    }
    return response()->json(['message' => 'Not logged in']);
})->middleware('auth:admin');

// Route untuk testing upload gambar
Route::get('/test-upload', function () {
    return view('test-upload');
});

Route::post('/test-upload', function (Request $request) {
    try {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('gambar');
        
        // Test upload sederhana
        $path = $file->store('test', 'public');
        
        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => asset('storage/' . $path),
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
            'original_name' => $file->getClientOriginalName()
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 400);
    }
});

// Prefix admin
Route::prefix('admin')->name('admin.')->group(function () {

    // Route untuk login dan logout admin (tanpa middleware auth)
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Group route untuk admin yang sudah login
    Route::middleware('auth:admin')->group(function () {

        // Route dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route untuk berita (CRUD lengkap) - urutan penting!
        Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
        Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
        Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');

        // Route untuk menghapus gambar individual dari galeri berita
        Route::delete('/berita/image/{imageId}', [BeritaController::class, 'deleteImage'])->name('berita.image.delete');

        // Route untuk infografis (CRUD lengkap)
        Route::get('/infografis', [InfografisController::class, 'index'])->name('infografis.index');
        Route::get('/infografis/create', [InfografisController::class, 'create'])->name('infografis.create');
        Route::post('/infografis', [InfografisController::class, 'store'])->name('infografis.store');
        Route::get('/infografis/{infografis}/edit', [InfografisController::class, 'edit'])->name('infografis.edit');
        Route::put('/infografis/{infografis}', [InfografisController::class, 'update'])->name('infografis.update');
        Route::delete('/infografis/{infografis}', [InfografisController::class, 'destroy'])->name('infografis.destroy');

        // Route untuk profil (CRUD)
        Route::resource('profil', ProfilController::class)->except(['show']);

        // Route untuk FAQ Category (CRUD)
        Route::resource('faq-categories', FaqCategoryController::class)->except(['show']);
        // Route untuk FAQ (CRUD)
        Route::resource('faqs', FaqController::class)->except(['show']);


        // Route untuk Laporan Pengaduan Admin (CRUD)
        Route::resource('laporan-pengaduan-admin', \App\Http\Controllers\Admin\LaporanPengaduanAdminController::class);
        Route::patch('/laporan-pengaduan-admin/{laporanPengaduanAdmin}/toggle-publish', [\App\Http\Controllers\Admin\LaporanPengaduanAdminController::class, 'togglePublish'])->name('laporan-pengaduan-admin.toggle-publish');
        Route::get('/laporan-pengaduan-admin/{laporanPengaduanAdmin}/download', [\App\Http\Controllers\Admin\LaporanPengaduanAdminController::class, 'downloadFile'])->name('laporan-pengaduan-admin.download');

        // Route untuk Publikasi (CRUD)
        Route::resource('publikasi', \App\Http\Controllers\Admin\PublikasiController::class);
        Route::get('/publikasi/{publikasi}/download', [\App\Http\Controllers\Admin\PublikasiController::class, 'download'])->name('publikasi.download');
    });
});