<template>
  <div class="berita-detail-page min-h-screen bg-gray-50">
    <!-- Loading state -->
    <div v-if="loading" class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3">
          <div class="bg-white rounded-lg shadow-md p-6 animate-pulse">
            <div class="h-8 bg-gray-300 rounded mb-4"></div>
            <div class="h-4 bg-gray-300 rounded mb-2"></div>
            <div class="h-4 bg-gray-300 rounded w-3/4 mb-6"></div>
            <div class="h-64 bg-gray-300 rounded mb-6"></div>
            <div class="space-y-3">
              <div class="h-4 bg-gray-300 rounded"></div>
              <div class="h-4 bg-gray-300 rounded"></div>
              <div class="h-4 bg-gray-300 rounded w-5/6"></div>
            </div>
          </div>
        </div>
        <div class="lg:col-span-1">
          <LatestNews />
        </div>
      </div>
    </div>

    <!-- Error state -->
    <div v-else-if="error" class="container mx-auto px-4 py-8">
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ error }}</span>
      </div>
    </div>

    <!-- Content -->
    <div v-else-if="berita" class="container mx-auto px-4 py-8 mt-16">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Left Column - Berita Detail -->
        <div class="lg:col-span-3">
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200">
              <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                  <span v-if="berita.kategori" class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                    {{ berita.kategori }}
                  </span>
                  <span class="text-sm text-gray-500">{{ formatDate(berita.created_at) }}</span>
                </div>
                <button 
                  @click="$router.go(-1)" 
                  class="text-gray-500 hover:text-gray-700 transition-colors"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                  </svg>
                </button>
              </div>
              
              <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ berita.judul }}</h1>
              
              <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <div class="flex items-center space-x-4">
                  <span>Oleh: {{ berita.nama_pembuat || 'Admin Diskominfo' }}</span>
                  <span>•</span>
                  <span>{{ formatDate(berita.created_at) }}</span>
                </div>
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  {{ berita.views || 0 }} views
                </div>
              </div>

              <!-- Deskripsi singkat -->
              <div v-if="berita.deskripsi_singkat" class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-r">
                <p class="text-gray-700 italic">{{ berita.deskripsi_singkat }}</p>
              </div>
            </div>

            <!-- Image -->
            <div v-if="berita.gambar" class="w-full h-96 bg-gray-200 overflow-hidden">
              <img 
                :src="getImageUrlFromBerita(berita)" 
                :alt="berita.judul"
                class="w-full h-full object-cover"
                @error="handleImageError"
                @load="handleImageLoad"
              />
            </div>

            <!-- Content -->
            <div class="p-6">
              <div class="prose prose-lg max-w-none">
                <div v-html="berita.konten"></div>
              </div>
              
              <!-- Lampiran PDF -->
              <div v-if="berita.pdf_url" class="mt-8 pt-6 border-t border-gray-200">
                <PdfViewer 
                  :pdf-url="berita.pdf_url" 
                  :file-name="getPdfFileName(berita.lampiran_pdf)"
                />
              </div>
              
              <!-- Tags -->
              <div v-if="berita.tags && berita.tags.length > 0" class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Tags:</h3>
                <div class="flex flex-wrap gap-2">
                  <span 
                    v-for="tag in berita.tags" 
                    :key="tag"
                    class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded"
                  >
                    {{ tag }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Related News Section -->
          <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div 
                v-for="relatedNews in relatedNews" 
                :key="relatedNews.id"
                class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow duration-300"
                @click="navigateToNews(relatedNews.slug)"
              >
                <div class="w-full h-32 bg-gray-400 overflow-hidden relative">
                  <img 
                    v-if="relatedNews.gambar" 
                    :src="getImageUrlFromBerita(relatedNews)" 
                    :alt="relatedNews.judul"
                    class="w-full h-full object-cover"
                    @error="handleRelatedImageError"
                  />
                  <div v-else class="w-full h-full flex items-center justify-center bg-gray-300">
                    <span class="text-gray-500 text-xs">No Image</span>
                  </div>
                </div>
                <div class="p-4">
                  <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ relatedNews.judul }}</h4>
                  <p class="text-sm text-gray-500 mb-2">{{ formatDate(relatedNews.created_at) }}</p>
                  <p class="text-sm text-gray-600 line-clamp-2">
                    {{ truncatedContent(relatedNews.konten) }}
                  </p>
                </div>
              </div>
            </div>
          </div>
    
          <!-- Comments Section -->
          <div class="mt-12">
            <CommentsSection :berita-id="berita.id" />
          </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="lg:col-span-1">
          <LatestNews :showMargin="false" />
        </div>
      </div>
    </div>

    <!-- Not found state -->
    <div v-else class="container mx-auto px-4 py-8">
      <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Berita Tidak Ditemukan</h1>
        <p class="text-gray-600 mb-6">Berita yang Anda cari tidak ditemukan atau telah dihapus.</p>
        <button 
          @click="$router.push('/berita')" 
          class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors"
        >
          Kembali ke Berita
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { beritaService } from '@/service/api.js'
import LatestNews from '@/components/news/LatestNews.vue'
import PdfViewer from '@/components/news/PdfViewer.vue'
import CommentsSection from '@/components/news/CommentsSection.vue'

export default {
  name: 'BeritaDetail',
  components: {
    LatestNews,
    PdfViewer,
    CommentsSection
  },
  data() {
    return {
      berita: null,
      relatedNews: [],
      loading: true,
      error: null
    }
  },
  async mounted() {
    await this.fetchBeritaDetail()
  },
  watch: {
    '$route.params.slug': {
      handler() {
        this.fetchBeritaDetail()
      },
      immediate: true
    }
  },
  methods: {
    async fetchBeritaDetail() {
      try {
        this.loading = true
        this.error = null

        const slug = this.$route.params.slug
        const response = await beritaService.getBeritaBySlug(slug)

        if (response.data) {
          this.berita = response.data
          await this.fetchRelatedNews()
          // Track view after successfully loading berita
          await this.trackView()
        } else {
          this.berita = null
        }
      } catch (error) {
        console.error('Error fetching berita detail:', error)
        this.error = 'Gagal memuat detail berita. Silakan coba lagi.'
        this.berita = null
      } finally {
        this.loading = false
      }
    },
    
    async fetchRelatedNews() {
      try {
        // Fetch related news based on category or other criteria
        const response = await beritaService.getAllBerita({ 
          limit: 6,
          exclude: this.berita.id 
        })
        this.relatedNews = response.data?.data || []
      } catch (error) {
        console.error('Error fetching related news:', error)
        this.relatedNews = []
      }
    },
    
    getImageUrl(imagePath) {
      if (!imagePath) return null
      // If it's already a full URL, return as is
      if (imagePath.startsWith('http')) {
        return imagePath
      }
      // Remove any leading slashes to avoid double slashes
      const cleanPath = imagePath.replace(/^\/+/, '')
      // Construct the full URL
      return `http://localhost:8000/storage/${cleanPath}`
    },
    
    getImageUrlFromBerita(berita) {
      // Use gambar_url if available (from backend), otherwise construct URL
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
        month: 'long',
        year: 'numeric'
      })
    },
    
    truncatedContent(content) {
      if (!content) return ''
      return content.length > 100 
        ? content.substring(0, 100) + '...' 
        : content
    },
    
    navigateToNews(slug) {
      if (slug) {
        this.$router.push(`/berita/${slug}`)
      }
    },
    
    handleImageError(event) {
      console.warn('Image failed to load:', event.target.src)
      // Hide the image on error
      event.target.style.display = 'none'
    },
    
    handleImageLoad(event) {
      // Image loaded successfully
    },
    
    handleRelatedImageError(event) {
      console.warn('Related image failed to load:', event.target.src)
      // Hide the image and show placeholder
      event.target.style.display = 'none'
      const parent = event.target.parentElement
      if (parent) {
        parent.innerHTML = '<div class="w-full h-full flex items-center justify-center bg-gray-300"><span class="text-gray-500 text-xs">No Image</span></div>'
      }
    },
    
    getPdfFileName(pdfPath) {
      if (!pdfPath) return 'document.pdf'
      // Extract filename from path
      const parts = pdfPath.split('/')
      return parts[parts.length - 1] || 'document.pdf'
    },

    async trackView() {
      if (!this.berita || !this.berita.id) return

      const viewKey = `viewed_news_${this.berita.id}`

      // Check if this news has already been viewed from this device
      if (localStorage.getItem(viewKey)) {
        return // Already viewed, don't increment
      }

      try {
        // Generate a simple device ID (in a real app, you might use a more sophisticated approach)
        const deviceId = this.generateDeviceId()

        // Call the increment view API
        await beritaService.incrementView(this.berita.id, { device_id: deviceId })

        // Mark as viewed in localStorage
        localStorage.setItem(viewKey, 'true')
      } catch (error) {
        console.error('Error tracking view:', error)
        // Don't show error to user, just log it
      }
    },

    generateDeviceId() {
      // Generate a simple device identifier
      // In production, you might want to use a more robust method
      let deviceId = localStorage.getItem('device_id')
      if (!deviceId) {
        deviceId = 'device_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9)
        localStorage.setItem('device_id', deviceId)
      }
      return deviceId
    }
  }
}
</script>

<style scoped>
.berita-detail-page {
  font-family: 'Inter', sans-serif;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.prose {
  color: #374151;
  line-height: 1.75;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
  color: #111827;
  font-weight: 600;
  margin-top: 1.5em;
  margin-bottom: 0.5em;
}

.prose p {
  margin-bottom: 1em;
}

.prose img {
  border-radius: 0.5rem;
  margin: 1.5em 0;
}

.prose a {
  color: #2563eb;
  text-decoration: underline;
}

.prose a:hover {
  color: #1d4ed8;
}

.prose ul, .prose ol {
  margin: 1em 0;
  padding-left: 1.5em;
}

.prose li {
  margin: 0.5em 0;
}

.prose blockquote {
  border-left: 4px solid #e5e7eb;
  padding-left: 1em;
  margin: 1.5em 0;
  font-style: italic;
  color: #6b7280;
}
</style>
