<template>
  <div v-if="pdfUrl" class="pdf-viewer-container">
    <div class="pdf-header">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-3">
          <div class="pdf-icon">
            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
            </svg>
          </div>
          <div>
            <h3 class="text-lg font-semibold text-gray-800">Lampiran PDF</h3>
            <p class="text-sm text-gray-600">Dokumen terkait berita ini</p>
          </div>
        </div>
        <div class="flex items-center space-x-2">
          <button 
            @click="downloadPdf"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Download
          </button>
          <button 
            @click="openInNewTab"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            Buka
          </button>
        </div>
      </div>
    </div>

    <div class="pdf-content">
      <div class="pdf-iframe-container">
        <iframe
          :src="pdfUrl"
          class="pdf-iframe"
          frameborder="0"
          @load="handlePdfLoad"
          @error="handlePdfError"
        ></iframe>
      </div>
      
      <!-- Loading state -->
      <div v-if="loading" class="pdf-loading">
        <div class="flex flex-col items-center justify-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
          <p class="text-gray-600">Memuat dokumen PDF...</p>
        </div>
      </div>

      <!-- Error state -->
      <div v-if="error" class="pdf-error">
        <div class="flex flex-col items-center justify-center py-12">
          <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-800 mb-2">Gagal Memuat PDF</h3>
          <p class="text-gray-600 text-center mb-4">{{ error }}</p>
          <button 
            @click="retryLoad"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Coba Lagi
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PdfViewer',
  props: {
    pdfUrl: {
      type: String,
      required: true
    },
    fileName: {
      type: String,
      default: 'document.pdf'
    }
  },
  data() {
    return {
      loading: true,
      error: null
    }
  },
  mounted() {
    this.loading = true
    this.error = null
  },
  methods: {
    handlePdfLoad() {
      this.loading = false
      this.error = null
    },
    
    handlePdfError() {
      this.loading = false
      this.error = 'Dokumen PDF tidak dapat dimuat. Silakan coba lagi atau download file untuk melihat isinya.'
    },
    
    downloadPdf() {
      const link = document.createElement('a')
      link.href = this.pdfUrl
      link.download = this.fileName
      link.target = '_blank'
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
    },
    
    openInNewTab() {
      window.open(this.pdfUrl, '_blank')
    },
    
    retryLoad() {
      this.loading = true
      this.error = null
      // Force iframe reload
      const iframe = this.$el.querySelector('.pdf-iframe')
      if (iframe) {
        iframe.src = this.pdfUrl
      }
    }
  }
}
</script>

<style scoped>
.pdf-viewer-container {
  @apply bg-white rounded-lg shadow-md border border-gray-200;
}

.pdf-header {
  @apply p-6 border-b border-gray-200;
}

.pdf-icon {
  @apply p-2 bg-red-50 rounded-lg;
}

.pdf-content {
  @apply relative;
}

.pdf-iframe-container {
  @apply relative w-full;
}

.pdf-iframe {
  @apply w-full;
  height: 600px;
  min-height: 400px;
}

.pdf-loading,
.pdf-error {
  @apply absolute inset-0 bg-white flex items-center justify-center;
}

/* Responsive design */
@media (max-width: 768px) {
  .pdf-header {
    @apply p-4;
  }
  
  .pdf-iframe {
    height: 400px;
    min-height: 300px;
  }
  
  .pdf-header .flex {
    @apply flex-col space-y-3;
  }
  
  .pdf-header .flex > div:last-child {
    @apply w-full;
  }
  
  .pdf-header .flex > div:last-child .flex {
    @apply justify-center;
  }
}

@media (max-width: 480px) {
  .pdf-iframe {
    height: 300px;
    min-height: 250px;
  }
  
  .pdf-header h3 {
    @apply text-base;
  }
  
  .pdf-header p {
    @apply text-xs;
  }
}
</style>
