<template>
  <div class="page-wrapper">
    <div class="container">
      <div class="main-content">
        <div class="kabar-warga-section">
          <h2>Kabar Warga</h2>
  
          <!-- Loading state -->
          <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat data Kabar Warga...</p>
          </div>
  
          <!-- Error state -->
          <div v-else-if="error" class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle"></i>
            {{ error }}
            <br>
            <button @click="fetchKabarWarga" class="btn btn-sm btn-outline-danger mt-2">
              <i class="fas fa-redo"></i> Coba Lagi
            </button>
          </div>
  
          <!-- News grid -->
          <div v-else-if="newsItems.length > 0" class="kabar-warga-grid">
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
  
          <!-- Empty state -->
          <div v-else class="text-center py-5">
            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada berita Kabar Warga</h4>
            <p class="text-muted">Berita Kabar Warga akan segera ditampilkan di sini.</p>
          </div>
  
          <!-- Pagination -->
          <div v-if="!loading && !error && newsItems.length > 0" class="pagination">
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
import { ref, computed, onMounted } from 'vue';
import KabarWargaCard from '../components/kabarwarga/KabarWargaCard.vue';
import KategoriSidebar from '../components/kabarwarga/KategoriSidebar.vue';
import { beritaService } from '../service/api.js';

const newsItems = ref([]);
const categories = ref([]);
const loading = ref(true);
const error = ref(null);

const currentPage = ref(1);
const itemsPerPage = 6;

// Fetch Kabar Warga data from backend
const fetchKabarWarga = async () => {
  try {
    loading.value = true;
    error.value = null;

    const response = await beritaService.getBeritaByCategory('Kabar Warga');
    const data = response.data.data || response.data;

    // Transform data to match component structure
    newsItems.value = data.map(item => ({
      id: item.id,
      title: item.judul,
      date: new Date(item.created_at).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }),
      seats: '', // Not applicable for news
      txt: item.konten ? item.konten.substring(0, 150) + '...' : '',
      details: 'Read more',
      thumbImage: item.gambar ? `http://localhost:8000/storage/${item.gambar}` : null
    }));

  } catch (err) {
    console.error('Error fetching Kabar Warga:', err);
    error.value = 'Gagal memuat data Kabar Warga';
    // Fallback to empty array
    newsItems.value = [];
  } finally {
    loading.value = false;
  }
};

// Fetch categories
const fetchCategories = async () => {
  try {
    const response = await beritaService.getCategories();
    categories.value = response.data || [];
  } catch (err) {
    console.error('Error fetching categories:', err);
    categories.value = [];
  }
};

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

// Initialize data on component mount
onMounted(() => {
  fetchKabarWarga();
  fetchCategories();
});
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