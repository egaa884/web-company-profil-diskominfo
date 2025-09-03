<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Chatbot AI endpoint
Route::post('/chat', [ChatController::class, 'chat']);

use App\Http\Controllers\Api\ProfilApiController;
use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\FaqCategoryController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\LaporanPengaduanController;

// Public API routes for berita
Route::get('berita', [BeritaApiController::class, 'index']);
Route::get('berita/latest', [BeritaApiController::class, 'latest']);
Route::get('berita/hot', [BeritaApiController::class, 'hotNews']);
Route::get('berita/categories', [BeritaApiController::class, 'categories']);
Route::get('berita/category/{category}', [BeritaApiController::class, 'byCategory']);
Route::get('berita/slug/{slug}', [BeritaApiController::class, 'showBySlug']);
Route::get('berita/{berita}', [BeritaApiController::class, 'show']);

// Public API routes for profil
Route::get('profil', [ProfilApiController::class, 'index']);
Route::get('profil/categories', [ProfilApiController::class, 'categories']);
Route::get('profil/all-categories', [ProfilApiController::class, 'getAllCategories']);
Route::get('profil/category/{kategori}', [ProfilApiController::class, 'byCategory']);
Route::get('profil/{profil}', [ProfilApiController::class, 'show']);

// Public API routes for laporan pengaduan
Route::get('laporan-pengaduan', [LaporanPengaduanController::class, 'index']);
Route::get('laporan-pengaduan/categories', [LaporanPengaduanController::class, 'categories']);
Route::get('laporan-pengaduan/statistics', [LaporanPengaduanController::class, 'statistics']);
Route::post('laporan-pengaduan', [LaporanPengaduanController::class, 'store']);
Route::get('laporan-pengaduan/{laporanPengaduan}', [LaporanPengaduanController::class, 'show']);

// Public API routes for laporan pengaduan admin
Route::get('laporan-pengaduan-admin', [\App\Http\Controllers\Api\LaporanPengaduanAdminApiController::class, 'index']);
Route::get('laporan-pengaduan-admin/statistics', [\App\Http\Controllers\Api\LaporanPengaduanAdminApiController::class, 'statistics']);
Route::get('laporan-pengaduan-admin/years', [\App\Http\Controllers\Api\LaporanPengaduanAdminApiController::class, 'years']);
Route::get('laporan-pengaduan-admin/months', [\App\Http\Controllers\Api\LaporanPengaduanAdminApiController::class, 'months']);
Route::get('laporan-pengaduan-admin/latest', [\App\Http\Controllers\Api\LaporanPengaduanAdminApiController::class, 'latest']);
Route::get('laporan-pengaduan-admin/{laporanPengaduanAdmin}', [\App\Http\Controllers\Api\LaporanPengaduanAdminApiController::class, 'show']);
Route::get('laporan-pengaduan-admin/{laporanPengaduanAdmin}/download', [\App\Http\Controllers\Api\LaporanPengaduanAdminApiController::class, 'downloadFile']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('profil', ProfilApiController::class)->except(['index', 'show']);
    Route::post('profil/{profil}/upload-pdf', [ProfilApiController::class, 'uploadPdf']);
    Route::post('profil/{profil}/upload-gambar', [ProfilApiController::class, 'uploadGambar']);
    
    // Protected API routes for laporan pengaduan (admin only)
    Route::apiResource('laporan-pengaduan', LaporanPengaduanController::class)->except(['index', 'show', 'store']);
    Route::patch('laporan-pengaduan/{laporanPengaduan}/status', [LaporanPengaduanController::class, 'updateStatus']);
    Route::get('laporan-pengaduan/{laporanPengaduan}/download', [LaporanPengaduanController::class, 'downloadAttachment']);
});

Route::get('faq-categories', [FaqCategoryController::class, 'index']);
Route::apiResource('faq-categories', FaqCategoryController::class)->except(['index']);
Route::get('faqs', [FaqController::class, 'index']);
Route::apiResource('faqs', FaqController::class)->except(['index']);