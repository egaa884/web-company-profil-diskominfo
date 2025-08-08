# Troubleshooting Upload Gambar

## Masalah yang Sering Terjadi

### 1. Gambar Rusak Setelah Upload

**Penyebab:**
- File tidak valid atau corrupt
- MIME type tidak sesuai
- Ukuran file terlalu besar
- Permission folder storage tidak tepat
- Symbolic link tidak terbuat dengan benar

**Solusi yang Sudah Diterapkan:**

#### A. Validasi File yang Lebih Ketat
```php
// Cek validitas file
if (!$file->isValid()) {
    throw new \Exception('File tidak valid');
}

// Cek MIME type
$allowedMimes = ['image/jpeg', 'image/jpg', 'image/png'];
if (!in_array($file->getMimeType(), $allowedMimes)) {
    throw new \Exception('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
}

// Cek ukuran file (2MB)
if ($file->getSize() > 2 * 1024 * 1024) {
    throw new \Exception('Ukuran file terlalu besar. Maksimal 2MB.');
}
```

#### B. Optimasi Gambar dengan Intervention Image
```php
// Optimasi gambar menggunakan Intervention Image
try {
    $manager = new ImageManager(new Driver());
    $image = $manager->read(storage_path('app/public/' . $path));
    
    // Resize jika terlalu besar
    if ($image->width() > 1200) {
        $image->resize(1200, null);
    }
    
    // Kompres dan simpan gambar
    $image->save(storage_path('app/public/' . $path), 85);
} catch (\Exception $e) {
    Log::warning('Image optimization failed, using original', [
        'error' => $e->getMessage(),
        'path' => $path
    ]);
}
```

#### C. Penanganan Error yang Lebih Baik
```php
try {
    // Proses upload
    $data['gambar'] = $this->handleImageUpload($request->file('gambar'));
} catch (\Exception $e) {
    Log::error('Berita creation failed', [
        'error' => $e->getMessage(),
        'user_id' => Auth::guard('admin')->id()
    ]);
    
    return back()->withInput()->withErrors(['error' => 'Gagal menyimpan berita: ' . $e->getMessage()]);
}
```

### 2. Permission Folder Storage

**Perintah untuk memperbaiki permission:**
```bash
# Windows
icacls storage /grant Everyone:F /T

# Linux/Mac
chmod -R 755 storage
chown -R www-data:www-data storage
```

### 3. Symbolic Link

**Perintah untuk membuat symbolic link:**
```bash
php artisan storage:link
```

### 4. Konfigurasi Filesystem

Pastikan konfigurasi di `config/filesystems.php` sudah benar:
```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
    'throw' => false,
    'report' => false,
],
```

## Testing Upload

### Halaman Test Upload
Akses `/test-upload` untuk testing upload gambar secara real-time.

### Log Monitoring
Cek log Laravel di `storage/logs/laravel.log` untuk melihat error detail.

## Checklist Troubleshooting

- [ ] File gambar valid (JPG, JPEG, PNG)
- [ ] Ukuran file < 2MB
- [ ] Permission folder storage sudah benar
- [ ] Symbolic link sudah terbuat
- [ ] Konfigurasi filesystem sudah benar
- [ ] Package Intervention Image sudah terinstall
- [ ] Cache sudah di-clear

## Perintah Maintenance

```bash
# Clear semua cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Recreate symbolic link
php artisan storage:link --force

# Fix permission (Windows)
icacls storage /grant Everyone:F /T

# Fix permission (Linux/Mac)
chmod -R 755 storage
chown -R www-data:www-data storage
```

## Debugging

### 1. Cek File yang Diupload
```php
Log::info('File upload info', [
    'original_name' => $file->getClientOriginalName(),
    'mime_type' => $file->getMimeType(),
    'size' => $file->getSize(),
    'is_valid' => $file->isValid(),
    'error' => $file->getError()
]);
```

### 2. Cek Path Storage
```php
Log::info('Storage path info', [
    'storage_path' => storage_path('app/public'),
    'public_path' => public_path('storage'),
    'exists' => Storage::disk('public')->exists($path)
]);
```

### 3. Test Upload Sederhana
Gunakan route `/test-upload` untuk testing upload tanpa validasi kompleks. 