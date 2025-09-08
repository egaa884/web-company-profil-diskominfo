<template>
  <div class="news-page min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3">
          <HotNews />
          <NewsGrid :selectedCategory="selectedCategory" />
        </div>

        <div class="lg:col-span-1">
          <div class="sticky-sidebar">
            <LatestNews />
            <CategoryList @category-selected="handleCategorySelected" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HotNews from '@/components/news/HotNews.vue'
import NewsGrid from '@/components/news/NewsGrid.vue'
import LatestNews from '@/components/news/LatestNews.vue'


export default {
  name: 'Beritakominfo',
  components: {
    HotNews,
    NewsGrid,
    LatestNews
  },
  data() {
    return {
      selectedCategory: 'Berita Kominfo Madiun'
    }
  },
  methods: {
    handleCategorySelected(category) {
      this.selectedCategory = category
    }
  }
}
</script>

<style scoped>
.news-page {
  font-family: 'Inter', sans-serif;
  top: 10px;
}

/* CSS baru untuk sticky sidebar */
.sticky-sidebar {
  position: sticky;
  top: 100px; /* Jarak dari atas saat sticky, sesuaikan dengan tinggi header Anda */
  align-self: flex-start; /* Memastikan sidebar tidak meregang */
  max-height: calc(100vh - 120px); /* Menentukan tinggi agar bisa digulir */
  overflow-y: auto; /* Mengaktifkan scrolling vertikal */
}

/* Perbaikan untuk LatestNews */
/* Jika LatestNews memiliki margin-top default, ini akan menimpanya agar menempel ke atas */
.latest-news {
  margin-top: 0 !important;
}
</style>