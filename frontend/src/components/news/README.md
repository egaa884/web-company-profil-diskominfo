# Komponen Berita

Dokumentasi untuk komponen-komponen berita yang digunakan dalam aplikasi Kominfo Madiun.

## Struktur Komponen

### 1. HotNews.vue
Komponen untuk menampilkan berita utama (hot news) dengan layout horizontal.
- **Props**: Tidak ada
- **Fitur**: 
  - Judul berita utama
  - Deskripsi berita
  - Tanggal publikasi
  - Gambar placeholder dengan warna #8F8F8F

### 2. NewsCard.vue
Komponen kartu berita individual yang dapat digunakan kembali.
- **Props**:
  - `title` (String): Judul berita
  - `date` (String): Tanggal publikasi
  - `description` (String): Deskripsi berita
- **Fitur**:
  - Gambar placeholder dengan warna #8F8F8F
  - Text truncation untuk judul dan deskripsi
  - Hover effect

### 3. NewsGrid.vue
Komponen grid untuk menampilkan multiple kartu berita.
- **Props**: Tidak ada
- **Fitur**:
  - Grid responsive (1 kolom di mobile, 2 di tablet, 3 di desktop)
  - Menggunakan NewsCard component
  - Data berita statis (dapat diubah menjadi props atau API call)

### 4. LatestNews.vue
Komponen sidebar untuk menampilkan berita terbaru.
- **Props**: Tidak ada
- **Fitur**:
  - Layout vertikal dengan gambar di atas
  - Gambar placeholder dengan warna #8F8F8F
  - Text truncation untuk deskripsi

### 5. CategoryList.vue
Komponen sidebar untuk menampilkan daftar kategori.
- **Props**: Tidak ada
- **Fitur**:
  - Background biru muda
  - Link kategori yang dapat diklik
  - Hover effect

## Penggunaan

```vue
<template>
  <div class="news-page">
    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
          <HotNews />
          <NewsGrid />
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
          <LatestNews />
          <CategoryList />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HotNews from '@/components/news/HotNews.vue'
import NewsGrid from '@/components/news/NewsGrid.vue'
import LatestNews from '@/components/news/LatestNews.vue'
import CategoryList from '@/components/news/CategoryList.vue'

export default {
  components: {
    HotNews,
    NewsGrid,
    LatestNews,
    CategoryList
  }
}
</script>
```

## Styling

Semua komponen menggunakan Tailwind CSS dengan:
- Warna gambar placeholder: #8F8F8F
- Responsive design
- Hover effects
- Shadow dan rounded corners
- Text truncation untuk overflow

## Integrasi dengan Backend

Untuk integrasi dengan backend Laravel, komponen dapat dimodifikasi untuk:
1. Menggunakan props untuk data dinamis
2. Menambahkan API calls untuk fetch data
3. Menambahkan loading states
4. Menambahkan error handling 