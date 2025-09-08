<template>
  <div class="hot-news">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 mt-5 pl-4 relative inline-block"> HOT NEWS
      <img
        :src="hotNewsLogo"
        alt="Hot News Logo"
        class="absolute -top-2 left-full ml-1 w-6 h-6" />
    </h2>
    
    <!-- Loading state -->
    <div v-if="loading" class="bg-white rounded-lg shadow-md p-6">
      <div class="flex justify-center items-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <span class="ml-2 text-gray-600">Memuat hot news...</span>
      </div>
    </div>
    
    <!-- Hot news content -->
    <div v-else-if="hotNews" class="bg-white rounded-lg shadow-md p-6">
      <div class="flex gap-6">
        <div class="flex-1">
          <div v-if="hotNews.category" class="mb-2">
            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
              {{ hotNews.category }}
            </span>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-3 cursor-pointer hover:text-blue-600" @click="handleClick">
            {{ hotNews.judul }}
          </h3>
          <p class="text-gray-600 mb-4 line-clamp-3">
            {{ truncatedContent }}
          </p>
          <p class="text-sm text-gray-500">{{ formatDate(hotNews.created_at) }}</p>
        </div>
        <div class="w-64 h-48 bg-gray-400 rounded-lg flex-shrink-0 overflow-hidden">
          <img
            v-if="hotNews.gambar_url"
            :src="hotNews.gambar_url"
            :alt="hotNews.judul"
            class="w-full h-full object-cover"
          />
          <div v-else class="w-full h-full flex items-center justify-center bg-gray-300">
            <span class="text-gray-500 text-sm">No Image</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Empty state -->
    <div v-else class="bg-white rounded-lg shadow-md p-6">
      <div class="text-center py-8">
        <p class="text-gray-500">Tidak ada hot news saat ini.</p>
      </div>
    </div>
  </div>
</template>

<script>
import hotNewsLogo from '../../assets/img/fire.png';
import { beritaService } from '@/service/api.js'

export default {
  name: 'HotNews',
  data() { 
    return {
      hotNewsLogo: hotNewsLogo,
      hotNews: null,
      loading: false
    };
  },
  computed: {
    truncatedContent() {
      if (!this.hotNews?.konten) return ''
      return this.hotNews.konten.length > 200 
        ? this.hotNews.konten.substring(0, 200) + '...' 
        : this.hotNews.konten
    }
  },
  async mounted() {
    await this.fetchHotNews()
  },
  methods: {
    async fetchHotNews() {
      try {
        this.loading = true
        const response = await beritaService.getHotNews()
        // Get the first news item as hot news
        this.hotNews = response.data[0] || null
      } catch (error) {
        console.error('Error fetching hot news:', error)
        this.hotNews = null
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
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
      })
    },
    handleClick() {
      if (this.hotNews?.slug) {
        this.$router.push(`/berita/${this.hotNews.slug}`)
      }
    }
  }
}
</script>

<style scoped>
.hot-news {
  margin-bottom: 2rem;
  margin-top: 5%;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> 