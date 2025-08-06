# Sistem Role Kominfo Admin

## Overview
Sistem ini memiliki 2 role utama untuk mengelola akses pengguna:

### 1. Role Admin (Akses Penuh)
- **Email**: admin@kominfo.com
- **Password**: admin123
- **Hak Akses**:
  - Dashboard
  - Berita (CRUD lengkap: Create, Read, Update, Delete)
  - Infografis (CRUD lengkap: Create, Read, Update, Delete)

### 2. Role User (Akses Terbatas)
- **Email**: user@kominfo.com
- **Password**: user123
- **Hak Akses**:
  - Berita (CRUD lengkap: Create, Read, Update, Delete)

## Implementasi Teknis

### Middleware
1. **CheckRole.php**: Mengatur akses berdasarkan role
   - Admin: Akses penuh ke semua fitur
   - User: Akses penuh ke berita, tidak bisa akses dashboard dan infografis

2. **AdminMiddleware.php**: Memvalidasi login admin dan role yang valid

### Routes
Routes dikelompokkan berdasarkan role:
```php
// Route untuk role admin (akses penuh)
Route::middleware('role:admin')->group(function () {
    // Semua route CRUD untuk berita dan infografis
});

// Route untuk role user (hanya akses berita)
Route::middleware('role:user')->group(function () {
    // Hanya route view untuk berita
});
```

### Controllers
1. **BeritaController**: 
   - Admin: CRUD lengkap (Create, Read, Update, Delete)
   - User: CRUD lengkap (Create, Read, Update, Delete)

2. **DashboardController**: Hanya admin yang bisa akses
3. **InfografisController**: Hanya admin yang bisa akses

### Views
1. **Sidebar**: Menampilkan menu sesuai role
2. **Berita Index**: Tombol aksi sesuai role
   - Admin: Create, Edit, Delete
   - User: Create, Edit, Delete
3. **Berita Show**: Halaman detail berita untuk user

### Database
- Tabel `admins` memiliki kolom `role` dengan nilai 'admin' atau 'user'
- Seeder `AdminSeeder` membuat 2 akun default

## Cara Penggunaan

### Login sebagai Admin
1. Buka `/admin/login`
2. Masukkan email: `admin@kominfo.com`
3. Masukkan password: `admin123`
4. Akses penuh ke semua fitur

### Login sebagai User
1. Buka `/admin/login`
2. Masukkan email: `user@kominfo.com`
3. Masukkan password: `user123`
4. Akses penuh ke berita (CRUD lengkap)

## Keamanan
- Setiap route dilindungi middleware role
- User dengan role 'user' tidak bisa mengakses halaman admin
- User tidak bisa akses dashboard dan infografis
- Redirect otomatis jika mencoba akses yang tidak diizinkan
- Pesan error yang informatif

## Menambah Role Baru
Untuk menambah role baru:
1. Tambahkan role di middleware `CheckRole.php`
2. Buat route group baru dengan middleware role
3. Update sidebar untuk menampilkan menu sesuai role
4. Update seeder jika diperlukan 