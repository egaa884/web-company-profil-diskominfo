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
use App\Http\Controllers\Api\PublikasiApiController;
use App\Http\Controllers\Api\ProfilePageController;
use App\Http\Controllers\Api\NewProfilePageController;

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

// New Profile Page API routes (separate from existing profil system)
Route::prefix('profile-page')->group(function () {
    Route::get('sekilas-dinas', [ProfilePageController::class, 'getSekilasDinas']);
    Route::get('visi-misi', [ProfilePageController::class, 'getVisiMisi']);
    Route::get('kantor-dinas', [ProfilePageController::class, 'getKantorDinas']);
    Route::get('struktur-organisasi', [ProfilePageController::class, 'getStrukturOrganisasi']);
    Route::get('tugas-pokok-fungsi', [ProfilePageController::class, 'getTugasPokokFungsi']);
    Route::get('standar-pelayanan', [ProfilePageController::class, 'getStandarPelayanan']);
    Route::get('all', [ProfilePageController::class, 'getAllProfileData']);
});

// New Database-driven Profile Page API routes
Route::prefix('new-profile-page')->group(function () {
    Route::get('sekilas-dinas', [NewProfilePageController::class, 'getSekilasDinas']);
    Route::get('visi-misi', [NewProfilePageController::class, 'getVisiMisi']);
    Route::get('kantor-dinas', [NewProfilePageController::class, 'getKantorDinas']);
    Route::get('struktur-organisasi', [NewProfilePageController::class, 'getStrukturOrganisasi']);
    Route::get('tugas-pokok-fungsi', [NewProfilePageController::class, 'getTugasPokokFungsi']);
    Route::get('standar-pelayanan', [NewProfilePageController::class, 'getStandarPelayanan']);
    Route::get('all', [NewProfilePageController::class, 'getAllProfileData']);
});

// Public API routes for publikasi (unified - replaces separate laporan-pengaduan routes)
Route::get('publikasi', [PublikasiApiController::class, 'index']);
Route::get('publikasi/categories', [PublikasiApiController::class, 'categories']);
Route::get('publikasi/statistics', [PublikasiApiController::class, 'statistics']);
Route::get('publikasi/months', [PublikasiApiController::class, 'getMonths']);
Route::get('publikasi/years', [PublikasiApiController::class, 'getYears']);
Route::get('publikasi/{publikasi}', [PublikasiApiController::class, 'show']);

// Public API routes for laporan pengaduan admin (kept for backward compatibility)
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
    
    // Protected API routes for publikasi (admin only)
    Route::apiResource('publikasi', PublikasiApiController::class)->except(['index', 'show', 'categories', 'statistics', 'months', 'years']);
});

Route::get('faq-categories', [FaqCategoryController::class, 'index']);
Route::apiResource('faq-categories', FaqCategoryController::class)->except(['index']);
Route::get('faqs', [FaqController::class, 'index']);
Route::apiResource('faqs', FaqController::class)->except(['index']);