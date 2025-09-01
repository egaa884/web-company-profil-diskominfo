# Halaman Detail Berita

## Deskripsi
Halaman detail berita adalah halaman yang menampilkan konten lengkap dari sebuah berita. Halaman ini tidak berdiri sendiri seperti halaman yang ada di navbar, tetapi muncul ketika user mengklik tombol "selengkapnya" atau card berita.

## Fitur yang Dibuat

### 1. Halaman Detail Berita (`/berita/:slug`)
- **File**: `frontend/src/views/BeritaDetail.vue`
- **Route**: `/berita/:slug` (ditambahkan di `frontend/src/router/index.js`)
- **Layout**: 
  - Detail berita di sebelah kiri (3 kolom)
  - Komponen LatestNews di sebelah kanan (1 kolom)

### 2. Komponen yang Diperbarui

#### LatestNews.vue
- **File**: `frontend/src/components/news/LatestNews.vue`
- **Perubahan**: 
  - Menambahkan prop `showMargin` untuk mengontrol margin-top
  - Di halaman detail berita, margin-top diset ke 0
  - Di halaman berita utama, margin-top tetap 17%

#### Service API
- **File**: `frontend/src/service/api.js`
- **Perubahan**: Menambahkan method `getBeritaBySlug(slug)` untuk mengambil berita berdasarkan slug

### 3. Backend API

#### Controller
- **File**: `backend/app/Http/Controllers/Api/BeritaApiController.php`
- **Perubahan**: Menambahkan method `showBySlug($slug)` untuk mengambil berita berdasarkan slug

#### Route
- **File**: `backend/routes/api.php`
- **Perubahan**: Menambahkan route `GET /api/berita/slug/{slug}`

## Cara Kerja

### 1. Navigasi ke Detail Berita
1. User mengklik card berita di halaman berita utama
2. Komponen `NewsCard.vue` menangani click event
3. Router navigasi ke `/berita/{slug}`
4. Halaman `BeritaDetail.vue` dimuat

### 2. Pengambilan Data
1. Halaman detail berita mengambil slug dari route parameter
2. API call ke `GET /api/berita/slug/{slug}`
3. Backend mencari berita berdasarkan slug
4. Data berita ditampilkan di halaman

### 3. Layout Halaman
```
┌─────────────────────────────────────────────────────────┐
│                         Navbar                          │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌─────────────────────────┐  ┌─────────────────────┐  │
│  │                         │  │                     │  │
│  │     Detail Berita       │  │    LatestNews       │  │
│  │     (3 kolom)           │  │   (1 kolom)         │  │
│  │                         │  │                     │  │
│  │  - Judul & Meta         │  │  - Berita Terbaru   │  │
│  │  - Gambar               │  │  - Tanpa margin     │  │
│  │  - Konten               │  │                     │  │
│  │  - Tags                 │  │                     │  │
│  │  - Berita Terkait       │  │                     │  │
│  │                         │  │                     │  │
│  └─────────────────────────┘  └─────────────────────┘  │
│                                                         │
├─────────────────────────────────────────────────────────┤
│                        Footer                           │
└─────────────────────────────────────────────────────────┘
```

## Fitur Halaman Detail

### 1. Header Berita
- Kategori berita (badge)
- Tanggal publikasi
- Tombol kembali
- Judul berita
- Informasi penulis

### 2. Konten Berita
- Gambar berita (jika ada)
- Konten HTML lengkap
- Tags (jika ada)

### 3. Berita Terkait
- Grid berita terkait (3 kolom)
- Berita diambil berdasarkan kategori atau berita terbaru
- Navigasi ke berita terkait

### 4. Sidebar
- Komponen LatestNews
- Tanpa margin-top untuk tampilan yang rapi

### 5. State Management
- **Loading**: Skeleton loading saat memuat data
- **Error**: Pesan error jika gagal memuat data
- **Not Found**: Halaman khusus jika berita tidak ditemukan

## Responsive Design
- **Desktop**: Layout 4 kolom (3:1)
- **Tablet**: Layout 2 kolom
- **Mobile**: Layout 1 kolom (stacked)

## Integrasi dengan Database
- Berita diambil dari tabel `beritas`
- Slug di-generate otomatis saat berita dibuat/diupdate
- Hanya berita dengan status 'published' yang ditampilkan
- Gambar disimpan di storage dengan path `berita/{filename}`

## Testing
1. Pastikan backend server berjalan di `http://localhost:8000`
2. Pastikan frontend server berjalan di `http://localhost:5173`
3. Buka halaman berita utama
4. Klik salah satu card berita
5. Pastikan halaman detail berita muncul dengan benar
6. Test navigasi ke berita terkait
7. Test tombol kembali

## Troubleshooting

### Berita tidak ditemukan
- Pastikan slug berita ada di database
- Pastikan berita memiliki status 'published'
- Cek console browser untuk error API

### Gambar tidak muncul
- Pastikan file gambar ada di storage
- Cek path gambar di database
- Pastikan storage link sudah dibuat

### Layout tidak rapi
- Pastikan Tailwind CSS ter-load dengan benar
- Cek responsive breakpoints
- Pastikan komponen LatestNews menggunakan prop `showMargin` yang benar
