<template>
  <div class="latest-news">
    <h3 class="text-xl font-bold text-gray-800 mb-4 sticky-title">Berita Terbaru</h3>

    <div v-if="loading" class="latest-news-scrollable space-y-4">
      <div v-for="i in 3" :key="i" class="bg-white rounded-lg shadow-md overflow-hidden animate-pulse">
        <div class="w-full h-24 bg-gray-300"></div>
        <div class="p-3">
          <div class="h-4 bg-gray-300 rounded mb-2"></div>
          <div class="h-4 bg-gray-300 rounded w-3/4"></div>
        </div>
      </div>
    </div>
    
    <div v-else-if="latestNews.length > 0" class="latest-news-scrollable space-y-4">
      <div 
        v-for="(news, index) in latestNews" 
        :key="news.id || index"
        class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow duration-300"
        @click="handleClick(news)"
      >
        <div class="w-full h-24 bg-gray-400 overflow-hidden relative">
          <img
            v-if="news.gambar"
            :src="getImageUrlFromBerita(news)"
            :alt="news.judul"
            class="w-full h-full object-cover"
          />
          <div v-else class="w-full h-full flex items-center justify-center bg-gray-300">
            <span class="text-gray-500 text-xs">No Image</span>
          </div>

          <!-- PDF Badge Overlay -->
          <div v-if="news.lampiran_pdf || news.pdf_url" class="absolute top-1 right-1 bg-red-600 text-white px-1.5 py-0.5 rounded text-xs font-semibold shadow-md">
            <div class="flex items-center space-x-1">
              <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
              </svg>
              <span>PDF</span>
            </div>
          </div>
        </div>
        <div class="p-3">
          <h4 class="text-sm font-semibold text-gray-800 mb-1 line-clamp-2">
            {{ news.judul }}
          </h4>
          <p class="text-xs text-gray-500 mb-1">{{ formatDate(news.created_at) }}</p>
          <p class="text-xs text-gray-600 line-clamp-2">
            {{ truncatedContent(news.deskripsi_singkat || news.konten) }}
          </p>
        </div>
      </div>
    </div>
    
    <div v-else class="latest-news-scrollable text-center py-4">
      <p class="text-gray-500 text-sm">Tidak ada berita terbaru.</p>
    </div>
  </div>
</template>

<script>
import { beritaService } from '@/service/api.js'

export default {
  name: 'LatestNews',
  props: {
    showMargin: {
      type: Boolean,
      default: true
    }
  },
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
      if (imagePath.startsWith('http')) {
        return imagePath
      }
      const cleanPath = imagePath.replace(/^\/+/, '')
      return `http://localhost:8000/storage/${cleanPath}`
    },
    
    getImageUrlFromBerita(berita) {
      if (berita.gambar_url) {
        return berita.gambar_url
      }
      return this.getImageUrl(berita.gambar)
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
  /* Hapus margin-top di sini */
  margin-top: 0;
}

/* Container untuk konten yang bisa digulir */
.latest-news-scrollable {
  max-height: calc(100vh - 200px); /* Sesuaikan tinggi, di sini saya kurangi 200px untuk header dan judul */
  overflow-y: auto;
}

.sticky-title {
  position: sticky;
  top: 0;
  background: white; /* Beri warna latar belakang agar tidak transparan */
  z-index: 10; /* Pastikan judul berada di atas konten yang digulir */
  padding-top: 1rem;
  padding-bottom: 1rem;
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