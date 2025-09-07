<template>
  <div class="page-wrapper">
    <div class="container">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3">
          <div class="kabar-warga-section">
            <h2>Kabar Warga</h2>
            <div v-if="newsItems.length > 0" class="kabar-warga-grid">
              <NewsCard 
                v-for="item in displayedNews"
                :key="item.id"
                :title="item.title"
                :date="item.created_at"
                :category="item.category"
                :description="item.konten"
                :image="item.gambar"
                :slug="item.slug" 
              />
            </div>
            <div v-else class="text-center p-8 text-gray-500">
              <p>Tidak ada berita yang ditemukan.</p>
            </div>
            <div class="pagination" v-if="totalPages > 1">
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
        
        <div class="lg:col-span-1">
          <div class="sticky-sidebar">
            <LatestNews />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import NewsCard from '@/components/global/NewsCard.vue';
import LatestNews from '@/components/news/LatestNews.vue';

const newsItems = ref([]);
const currentPage = ref(1);
const itemsPerPage = 6;

const fetchKabarWarga = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/berita/category/Kabar%20Warga');
    
    if (response.data && response.data.data) {
      newsItems.value = response.data.data;
    } else {
      console.error('API response format is not as expected:', response.data);
      newsItems.value = [];
    }
  } catch (error) {
    console.error('Gagal mengambil data kabar warga:', error);
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

onMounted(() => {
  fetchKabarWarga();
});
</script>

<style scoped>
.page-wrapper { background-color: #f0f2f5; margin-top:6%;}
.header-placeholder, .footer-placeholder { background-color: #1a1a1a; color: #fff; padding: 20px; text-align: center; }
.container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
.kabar-warga-section { flex: 1; }
.h2 {font-weight: 100;}
.kabar-warga-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 20px; }
h2, h3 { border-bottom: 2px solid #ccc; padding-bottom: 10px; margin-bottom: 20px; }
.pagination { margin-top: 20px; text-align: center; }
.pagination button { background-color: #fff; border: 1px solid #ccc; padding: 8px 12px; cursor: pointer; border-radius: 4px; }
.pagination button.active { background-color: #007bff; color: white; border-color: #007bff; }

/* CSS baru untuk sticky sidebar */
.sticky-sidebar {
  position: sticky;
  top: 100px; /* Sesuaikan dengan tinggi header Anda */
  align-self: flex-start;
  height: calc(100vh - 120px); 
  overflow-y: auto; 
}

/* Perbaikan untuk LatestNews */
.latest-news {
  margin-top: 0 !important;
}
</style>