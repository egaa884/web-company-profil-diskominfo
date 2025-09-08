<template>
  <div class="tentang-page min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <HeroSection />

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <div class="max-w-4xl mx-auto">
        <!-- Loading state -->
        <div v-if="loading" class="space-y-6">
          <div class="animate-pulse">
            <div class="h-8 bg-gray-300 rounded w-3/4 mb-4"></div>
            <div class="h-4 bg-gray-300 rounded w-full mb-2"></div>
            <div class="h-4 bg-gray-300 rounded w-5/6 mb-2"></div>
            <div class="h-4 bg-gray-300 rounded w-4/6"></div>
          </div>
        </div>

        <!-- Content -->
        <div v-else class="bg-white rounded-lg shadow-lg p-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">
            {{ profilData?.judul || 'Tentang Dinas Komunikasi dan Informatika Kota Madiun' }}
          </h1>

          <div v-if="profilData?.gambar" class="mb-8 text-center">
            <img
              :src="getImageUrl(profilData.gambar)"
              :alt="'Foto Dinas Kominfo Madiun'"
              class="max-w-full h-auto rounded-lg shadow-md mx-auto"
            />
          </div>

          <!-- PDF Attachment Section -->
          <div v-if="profilData?.pdf" class="mb-8">
            <!-- isi PDF tetap sama -->
          </div>

          <!-- Display content from backend -->
          <div v-if="profilData?.konten"
               class="tentang-content text-gray-700 leading-relaxed max-w-none"
               v-html="profilData.konten">
          </div>

          <!-- Fallback message -->
          <div v-else class="text-center py-8">
            <div class="text-gray-500">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">Konten belum tersedia</h3>
              <p class="mt-1 text-sm text-gray-500">Data profil untuk kategori "Tentang" sedang dalam proses pembuatan.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HeroSection from '@/components/global/HeroSection.vue'
import { profilService } from '@/service/api.js'

export default {
  name: 'Tentang',
  components: {
    HeroSection
  },
  data() {
    return {
      profilData: null,
      loading: false
    }
  },
  async mounted() {
    await this.fetchProfilData()
  },
  methods: {
    async fetchProfilData() {
      try {
        this.loading = true
        const response = await profilService.getProfilByCategory('tentang')
        this.profilData = response.data
      } catch (error) {
        console.error('Error fetching tentang data:', error)
        this.profilData = null
      } finally {
        this.loading = false
      }
    },
    getImageUrl(imagePath) {
      if (!imagePath) return null
      if (imagePath.startsWith('http')) {
        return imagePath
      }
      return `http://localhost:8000/storage/${imagePath}`
    },
    getPdfUrl(pdfPath) {
      if (!pdfPath) return null
      if (pdfPath.startsWith('http')) {
        return pdfPath
      }
      return `http://localhost:8000/storage/${pdfPath}`
    },
    formatDate(dateString) {
      if (!dateString) return 'Tanggal tidak tersedia'
      try {
        const date = new Date(dateString)
        return date.toLocaleDateString('id-ID', {
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        })
      } catch (error) {
        return 'Tanggal tidak valid'
      }
    }
  }
}
</script>

<style>
.tentang-page {
  font-family: 'Inter', sans-serif;
}

/* Konten backend */
.tentang-content {
  font-size: 1rem;
  line-height: 1.8;
  color: #374151;
  text-align: justify;
  word-wrap: break-word;
}

/* Paragraph rules */
.tentang-content p {
  margin-bottom: 1rem !important;
  line-height: 1.6 !important;
  margin-top: 0 !important;
  text-align: justify !important;
  word-wrap: break-word !important;
}

.tentang-content p + p {
  margin-top: 0.75rem !important;
}

.tentang-content p:last-child {
  margin-bottom: 0;
}

/* Heading hierarchy */
.tentang-content h1 {
  color: #1f2937;
  font-weight: 700;
  font-size: 2rem;
  margin-top: 3rem;
  margin-bottom: 1.5rem;
  line-height: 1.3;
  border-bottom: 2px solid #e5e7eb;
  padding-bottom: 0.5rem;
}

.tentang-content h2 {
  color: #1f2937;
  font-weight: 600;
  font-size: 1.5rem;
  margin-top: 2.5rem;
  margin-bottom: 1.25rem;
  line-height: 1.4;
  border-left: 4px solid #3b82f6;
  padding-left: 1rem;
}

.tentang-content h3 {
  color: #1f2937;
  font-weight: 600;
  font-size: 1.25rem;
  margin-top: 2rem;
  margin-bottom: 1rem;
  line-height: 1.4;
}

.tentang-content h4 {
  color: #1f2937;
  font-weight: 600;
  font-size: 1.125rem;
  margin-top: 1.75rem;
  margin-bottom: 0.875rem;
  line-height: 1.4;
}

/* List styling */
.tentang-content ul,
.tentang-content ol {
  margin-bottom: 1.5rem;
  padding-left: 2rem;
  line-height: 1.7;
}

.tentang-content ul li {
  list-style-type: disc;
  margin-bottom: 0.75rem;
}

.tentang-content ol li {
  list-style-type: decimal;
  margin-bottom: 0.75rem;
}

/* Blockquote */
.tentang-content blockquote {
  border-left: 4px solid #d1d5db;
  padding: 1rem 1.5rem;
  margin: 2rem 0;
  font-style: italic;
  color: #6b7280;
  background-color: #f9fafb;
  border-radius: 0.375rem;
}

/* Table styling */
.tentang-content table {
  width: 100%;
  border-collapse: collapse;
  margin: 2rem 0;
  font-size: 0.875rem;
}

.tentang-content th,
.tentang-content td {
  border: 1px solid #e5e7eb;
  padding: 0.75rem;
  text-align: left;
}

.tentang-content th {
  background-color: #f9fafb;
  font-weight: 600;
  color: #1f2937;
}

.tentang-content tr:nth-child(even) {
  background-color: #f9fafb;
}

/* Media query */
@media (max-width: 768px) {
  .tentang-content h1 {
    font-size: 1.75rem;
    margin-top: 2.5rem;
  }

  .tentang-content h2 {
    font-size: 1.375rem;
    margin-top: 2rem;
  }

  .tentang-content h3 {
    font-size: 1.125rem;
    margin-top: 1.75rem;
  }

  .tentang-content ul,
  .tentang-content ol {
    padding-left: 1.5rem;
  }
}
</style>
