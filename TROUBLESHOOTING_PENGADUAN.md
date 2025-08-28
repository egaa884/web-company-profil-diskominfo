# Troubleshooting Laporan Pengaduan

## Masalah: Error "Gagal memuat data laporan pengaduan"

### Langkah-langkah Debugging:

#### 1. Periksa Backend Server
```bash
# Pastikan Laravel server berjalan
cd backend
php artisan serve --host=0.0.0.0 --port=8000
```

#### 2. Test API Endpoint
```bash
# Test dengan PowerShell
Invoke-WebRequest -Uri "http://localhost:8000/api/laporan-pengaduan" -Method GET

# Atau dengan curl (jika tersedia)
curl http://localhost:8000/api/laporan-pengaduan
```

#### 3. Periksa Frontend Server
```bash
# Pastikan Vue dev server berjalan
cd frontend
npm run dev
```

#### 4. Periksa Console Browser
- Buka Developer Tools (F12)
- Lihat tab Console untuk error messages
- Lihat tab Network untuk request/response

#### 5. Periksa CORS
- Pastikan `backend/config/cors.php` mengizinkan origin `http://localhost:5173`
- Restart backend server setelah mengubah CORS

#### 6. Periksa Database
```bash
cd backend
php artisan migrate:status
php artisan db:seed --class=LaporanPengaduanSeeder
```

### Kemungkinan Penyebab Error:

1. **Backend server tidak berjalan**
   - Solusi: Jalankan `php artisan serve`

2. **CORS error**
   - Solusi: Periksa konfigurasi CORS dan restart server

3. **Database kosong**
   - Solusi: Jalankan seeder untuk data dummy

4. **Network timeout**
   - Solusi: Tingkatkan timeout di API client

5. **Invalid response format**
   - Solusi: Periksa struktur response dari backend

### Debugging yang Sudah Ditambahkan:

1. **Retry mechanism** - API akan mencoba 3 kali jika gagal
2. **Detailed error logging** - Console akan menampilkan detail error
3. **Better error messages** - Pesan error yang lebih spesifik
4. **Timeout increase** - Timeout ditingkatkan dari 10s ke 30s

### Cara Test:

1. Buka browser ke `http://localhost:5173/pengaduan`
2. Buka Developer Tools (F12)
3. Lihat Console untuk log messages
4. Jika masih error, lihat Network tab untuk detail request/response
