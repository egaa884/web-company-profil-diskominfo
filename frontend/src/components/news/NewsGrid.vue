<template>
  <div class="news-grid">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">
      {{ selectedCategory === 'all' ? 'SEMUA BERITA' : `BERITA ${selectedCategory.toUpperCase()}` }}
    </h2>
    
    <!-- Loading state -->
    <div v-if="loading" class="flex justify-center items-center py-8">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
      <span class="ml-2 text-gray-600">Memuat berita...</span>
    </div>
    
    <!-- News grid -->
    <div v-else-if="newsList.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <NewsCard 
        v-for="(news, index) in newsList" 
        :key="news.id || index"
        :title="news.judul"
        :date="formatDate(news.created_at)"
        :description="news.konten"
        :image="news.gambar"
        :category="news.category"
        :slug="news.slug"
      />
    </div>
    
    <!-- Empty state -->
    <div v-else class="text-center py-8">
      <p class="text-gray-500">Tidak ada berita yang ditemukan untuk kategori ini.</p>
    </div>
    
    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="mt-8 flex justify-center">
      <nav class="flex space-x-2">
        <button 
          v-for="page in pagination.last_page" 
          :key="page"
          @click="changePage(page)"
          :class="[
            'px-3 py-2 rounded-md text-sm font-medium',
            page === pagination.current_page 
              ? 'bg-blue-600 text-white' 
              : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
          ]"
        >
          {{ page }}
        </button>
      </nav>
    </div>
  </div>
</template>

<script>
import NewsCard from '@/components/global/NewsCard.vue'
import { beritaService } from '@/service/api.js'

export default {
  name: 'NewsGrid',
  components: {
    NewsCard
  },
  props: {
    selectedCategory: {
      type: String,
      default: 'all'
    }
  },
  data() {
    return {
      newsList: [],
      loading: false,
      pagination: null,
      currentPage: 1
    }
  },
  watch: {
    selectedCategory: {
      handler() {
        this.currentPage = 1
        this.fetchNews()
      },
      immediate: true
    }
  },
  methods: {
    async fetchNews() {
      try {
        this.loading = true
        const params = {
          page: this.currentPage
        }
        
        if (this.selectedCategory !== 'all') {
          params.category = this.selectedCategory
        }
        
        const response = await beritaService.getAllBerita(params)
        this.newsList = response.data.data || response.data
        this.pagination = response.data.meta || null
      } catch (error) {
        console.error('Error fetching news:', error)
        this.newsList = []
      } finally {
        this.loading = false
      }
    },
    changePage(page) {
      this.currentPage = page
      this.fetchNews()
    },
    formatDate(dateString) {
      if (!dateString) return ''
      const date = new Date(dateString)
      return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
      })
    }
  }
}
</script>

<style scoped>
.news-grid {
  margin-bottom: 2rem;
}
</style> 