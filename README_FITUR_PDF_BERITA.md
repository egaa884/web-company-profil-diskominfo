# Fitur Lampiran PDF Berita

## Deskripsi
Fitur ini memungkinkan admin untuk menambahkan lampiran PDF pada berita dan menampilkannya di halaman detail berita dengan viewer yang responsif.

## Fitur yang Ditambahkan

### 1. Backend (Laravel)

#### Migrasi Database
- Menambahkan kolom `lampiran_pdf` (string, nullable) untuk menyimpan path file PDF
- Menambahkan kolom `nama_pembuat` (string, nullable) untuk nama pembuat berita
- Menambahkan kolom `deskripsi_singkat` (text, nullable) untuk deskripsi singkat berita

#### Model Berita
- Memperbarui `$fillable` untuk menambahkan field baru
- Field baru: `lampiran_pdf`, `nama_pembuat`, `deskripsi_singkat`

#### Controller Admin
- Menambahkan method `handlePdfUpload()` untuk menangani upload file PDF
- Memperbarui validasi di method `store()` dan `update()`
- Menambahkan validasi file PDF (maksimal 10MB, format PDF)
- Menambahkan penghapusan file PDF lama saat update/delete

#### API Controller
- Menambahkan `pdf_url` ke response API untuk setiap berita
- PDF URL akan otomatis ditambahkan jika file PDF ada

### 2. Frontend (Vue.js)

#### Komponen PdfViewer
- Komponen responsif untuk menampilkan PDF
- Fitur download dan buka di tab baru
- Loading state dan error handling
- Design yang modern dan sesuai tema

#### BeritaDetail.vue
- Menambahkan informasi pembuat berita
- Menampilkan deskripsi singkat (jika ada)
- Menambahkan komponen PdfViewer (hanya jika ada PDF)
- Responsive design untuk semua ukuran layar

### 3. Admin Panel

#### Form Create Berita
- Field "Nama Pembuat" (opsional)
- Field "Deskripsi Singkat" (opsional)
- Field "Lampiran PDF" dengan validasi
- Preview file PDF yang dipilih

#### Form Edit Berita
- Menampilkan PDF yang sudah ada
- Link untuk melihat PDF yang ada
- Preview PDF baru yang dipilih

## Cara Penggunaan

### Untuk Admin

1. **Membuat Berita Baru:**
   - Isi judul, konten, dan informasi lainnya
   - Upload gambar thumbnail (opsional)
   - Upload file PDF (opsional)
   - Isi nama pembuat dan deskripsi singkat (opsional)
   - Publish berita

2. **Mengedit Berita:**
   - Edit informasi berita yang ada
   - Ganti atau tambah lampiran PDF
   - PDF lama akan otomatis dihapus jika diganti

### Untuk User

1. **Melihat Berita:**
   - Buka halaman detail berita
   - Jika ada lampiran PDF, akan muncul di bawah konten
   - Bisa download atau buka PDF di tab baru

## Validasi File

### Gambar
- Format: JPG, JPEG, PNG
- Ukuran maksimal: 2MB

### PDF
- Format: PDF
- Ukuran maksimal: 10MB

## Struktur File

```
backend/
├── database/migrations/
│   └── 2025_01_20_000000_add_lampiran_pdf_to_beritas_table.php
├── app/Models/
│   └── Berita.php (updated)
├── app/Http/Controllers/
│   ├── Admin/BeritaController.php (updated)
│   └── Api/BeritaApiController.php (updated)
└── resources/views/admin/berita/
    ├── create.blade.php (updated)
    └── edit.blade.php (updated)

frontend/
└── src/
    ├── components/news/
    │   └── PdfViewer.vue (new)
    └── views/
        └── BeritaDetail.vue (updated)
```

## Responsive Design

### Desktop (1024px+)
- PDF viewer tinggi 600px
- Layout 2 kolom dengan sidebar

### Tablet (768px - 1023px)
- PDF viewer tinggi 400px
- Layout responsif dengan flexbox

### Mobile (< 768px)
- PDF viewer tinggi 300px
- Layout single column
- Tombol download dan buka di tengah

## Keamanan

1. **Validasi File:**
   - Cek MIME type untuk mencegah upload file berbahaya
   - Batasan ukuran file untuk mencegah DoS

2. **Storage:**
   - File disimpan di `storage/app/public/pdf/`
   - Nama file di-generate secara random untuk keamanan

3. **Access Control:**
   - Hanya admin yang bisa upload PDF
   - File PDF bisa diakses publik untuk viewing

## Troubleshooting

### PDF Tidak Muncul
1. Cek apakah file PDF ada di storage
2. Cek permission folder storage
3. Cek apakah symbolic link sudah dibuat

### Upload Gagal
1. Cek ukuran file (maksimal 10MB)
2. Cek format file (harus PDF)
3. Cek permission folder upload

### PDF Viewer Error
1. Cek apakah URL PDF benar
2. Cek CORS policy jika PDF dari domain lain
3. Cek browser support untuk PDF viewing

## Dependencies

### Backend
- Laravel 10+
- Intervention Image (untuk optimasi gambar)
- File storage system

### Frontend
- Vue.js 3
- Tailwind CSS
- PDF.js (browser built-in)

## Future Enhancements

1. **PDF Thumbnail Generation**
   - Generate thumbnail otomatis dari halaman pertama PDF

2. **PDF Search**
   - Fitur pencarian dalam konten PDF

3. **PDF Annotation**
   - Fitur highlight dan komentar pada PDF

4. **Multiple PDF Support**
   - Support untuk multiple PDF per berita

5. **PDF Versioning**
   - Track perubahan PDF dan history

