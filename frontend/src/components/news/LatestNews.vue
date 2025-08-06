<template>
  <div class="latest-news">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Berita Terbaru</h3>
    
    <!-- Loading state -->
    <div v-if="loading" class="space-y-4">
      <div v-for="i in 3" :key="i" class="bg-white rounded-lg shadow-md overflow-hidden animate-pulse">
        <div class="w-full h-24 bg-gray-300"></div>
        <div class="p-3">
          <div class="h-4 bg-gray-300 rounded mb-2"></div>
          <div class="h-4 bg-gray-300 rounded w-3/4"></div>
        </div>
      </div>
    </div>
    
    <!-- Latest news content -->
    <div v-else-if="latestNews.length > 0" class="space-y-4">
      <div 
        v-for="(news, index) in latestNews" 
        :key="news.id || index"
        class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow duration-300"
        @click="handleClick(news)"
      >
        <div class="w-full h-24 bg-gray-400 overflow-hidden">
          <img 
            v-if="news.gambar" 
            :src="getImageUrl(news.gambar)" 
            :alt="news.judul"
            class="w-full h-full object-cover"
          />
          <div v-else class="w-full h-full flex items-center justify-center bg-gray-300">
            <span class="text-gray-500 text-xs">No Image</span>
          </div>
        </div>
        <div class="p-3">
          <h4 class="text-sm font-semibold text-gray-800 mb-1 line-clamp-2">
            {{ news.judul }}
          </h4>
          <p class="text-xs text-gray-500 mb-1">{{ formatDate(news.created_at) }}</p>
          <p class="text-xs text-gray-600 line-clamp-2">
            {{ truncatedContent(news.konten) }}
          </p>
        </div>
      </div>
    </div>
    
    <!-- Empty state -->
    <div v-else class="text-center py-4">
      <p class="text-gray-500 text-sm">Tidak ada berita terbaru.</p>
    </div>
  </div>
</template>

<script>
import { beritaService } from '@/service/api.js'

export default {
  name: 'LatestNews',
  data() {
    return {
      latestNews: [],
      loading: false
    }
  },
  async mounted() {
    await this.fetchLatestNews()
  },
  methods: {
    async fetchLatestNews() {
      try {
        this.loading = true
        const response = await beritaService.getLatestBerita()
        this.latestNews = response.data || []
      } catch (error) {
        console.error('Error fetching latest news:', error)
        this.latestNews = []
      } finally {
        this.loading = false
      }
    },
    getImageUrl(imagePath) {
      if (!imagePath) return null
      // If it's already a full URL, return as is
      if (imagePath.startsWith('http')) {
        return imagePath
      }
      // Otherwise, construct the full URL
      return `http://localhost:8000/storage/${imagePath}`
    },
    formatDate(dateString) {
      if (!dateString) return ''
      const date = new Date(dateString)
      return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
      })
    },
    truncatedContent(content) {
      if (!content) return ''
      return content.length > 100 
        ? content.substring(0, 100) + '...' 
        : content
    },
    handleClick(news) {
      if (news.slug) {
        this.$router.push(`/berita/${news.slug}`)
      }
    }
  }
}
</script>

<style scoped>
.latest-news {
  margin-top: 17%;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> 