<template>
  <div class="page-wrapper">
    <div class="container">
      <div class="main-content">
        <div class="kabar-warga-section">
          <h2>Kabar Warga</h2>
          <div class="kabar-warga-grid">
            <KabarWargaCard 
              v-for="item in displayedNews"
              :key="item.id"
              :title="item.title"
              :date="item.date"
              :seats="item.seats"
              :txt="item.txt"
              :details="item.details"
              :thumbImage="item.thumbImage"
            />
          </div>
          <div class="pagination">
            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">‹</button>
            <button
              v-for="page in totalPages"
              :key="page"
              @click="goToPage(page)"
              :class="{ active: currentPage === page }"
            >
              {{ page }}
            </button>
            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">›</button>
          </div>
        </div>
      </div>
      <KategoriSidebar :categories="categories" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import KabarWargaCard from '../components/kabarwarga/KabarWargaCard.vue';
import KategoriSidebar from '../components/kabarwarga/KategoriSidebar.vue';

// Impor gambar lokal secara eksplisit menggunakan alias @
import image1 from '@/assets/img/1.jpeg';
import image3 from '@/assets/img/3.jpg';
import image4 from '@/assets/img/4.jpg';
import image5 from '@/assets/img/5.jpg';
import image6 from '@/assets/img/6.jpg';

const newsItems = ref([
  { id: 1, title: 'Artificial Intelligence Dalam Ruang Persidangan', date: 'november 2 - 4', seats: 'seats remaining: 2', txt: 'Join us for our Live Infinity Session in beautiful New York City.', details: 'event details', thumbImage: image1 },
  { id: 3, title: 'Cegah Stunting dan Anemia, RSU Darmayu Edukasi Gizi Seimbang untuk Generasi Muda', date: 'january 5 - 7', seats: 'seats remaining: 10', txt: 'This is a 3 day intensive workshop where you\'ll learn how to become a better version of...', details: 'event details', thumbImage: image3 },
  { id: 4, title: 'Memahami KBLI: Kunci Sukses Perizinan Usaha dan Investasi di Madiun', date: 'february 1 - 3', seats: 'seats remaining: 8', txt: 'Join us for our Live Infinity Session in beautiful New York City.', details: 'event details', thumbImage: image4 },
  { id: 5, title: 'Baznas Kota Madiun Gencar Edukasi Zakat dan Luncurkan Program Masyarakat', date: 'march 20 - 22', seats: 'seats remaining: 3', txt: 'A 3 day intensive workshop where you\'ll learn how to become a better version of...', details: 'event details', thumbImage: image5 },
  { id: 6, title: 'Kota Madiun Perkuat Kesehatan Santri Melalui 15 Poskestren', date: 'april 15 - 17', seats: 'seats remaining: 1', txt: 'This is a 3 day intensive workshop where you\'ll learn how to become a better version of...', details: 'event details', thumbImage: image6 },
]);

const categories = ref([
  'Dokumen', 'Standar Operasional Prosedur (SOP)', 'Laporan Kinerja',
  'Layanan Penerimaan Layanan Publik', 'Layanan Pengaduan Pelayanan Publik',
  'Berita', 'Informasi'
]);

const currentPage = ref(1);
const itemsPerPage = 6;

const displayedNews = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return newsItems.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(newsItems.value.length / itemsPerPage));

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};
</script>

<style scoped>
.page-wrapper { background-color: #f0f2f5; margin-top:6%;}
.header-placeholder, .footer-placeholder { background-color: #1a1a1a; color: #fff; padding: 20px; text-align: center; }
.container { max-width: 1200px; margin: 40px auto; padding: 0 20px; display: flex; gap: 30px; }
.main-content { flex: 1; } /* Perubahan: hapus display: flex dan gap: 20px; */
.kabar-warga-section { flex: 1; } /* Perubahan: flex menjadi 1 */
.h2 {font-weight: 100;}
.kabar-warga-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 20px; }
h2, h3 { border-bottom: 2px solid #ccc; padding-bottom: 10px; margin-bottom: 20px; }
.pagination { margin-top: 20px; text-align: center; }
.pagination button { background-color: #fff; border: 1px solid #ccc; padding: 8px 12px; cursor: pointer; border-radius: 4px; }
.pagination button.active { background-color: #007bff; color: white; border-color: #007bff; }
</style>