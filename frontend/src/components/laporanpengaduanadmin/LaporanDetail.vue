<template>
  <div class="laporan-detail">
    <!-- Header Section -->
    <div class="detail-header">
      <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h1 class="text-3xl font-bold text-gray-800 mb-2">
                {{ laporan.judul || 'Laporan Pengaduan Pelayanan Publik' }}
              </h1>
              <div class="flex items-center space-x-4 text-sm text-gray-600">
                <span class="flex items-center">
                  <i class="fas fa-calendar-alt mr-2"></i>
                  {{ formatDate(laporan.tanggal_publikasi || laporan.created_at) }}
                </span>
                <span class="flex items-center">
                  <i class="fas fa-tag mr-2"></i>
                  Kategori: {{ laporan.kategori || 'Laporan Pengaduan Pelayanan Publik' }}
                </span>
                <span class="flex items-center">
                  <i class="fas fa-eye mr-2"></i>
                  {{ laporan.views || 0 }} Dilihat
                </span>
              </div>
            </div>
            <div class="flex space-x-2">
              <button @click="shareLaporan" class="btn-share">
                <i class="fas fa-share-alt"></i>
                Bagikan
              </button>
              <button @click="downloadLaporan" v-if="laporan.file_lampiran" class="btn-download">
                <i class="fas fa-download"></i>
                Download
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Section -->
    <div class="detail-content">
      <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Main Content -->
          <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
              <!-- Laporan Information -->
              <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                  Informasi Laporan
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="info-item">
                    <label class="text-sm font-medium text-gray-600">Periode Laporan</label>
                    <p class="text-lg font-semibold text-gray-800">
                      {{ laporan.bulan || 'Juni' }} {{ laporan.tahun || '2025' }}
                    </p>
                  </div>
                  <div class="info-item">
                    <label class="text-sm font-medium text-gray-600">Status Publikasi</label>
                    <span :class="getStatusClass(laporan.is_published)">
                      {{ laporan.is_published ? 'Dipublikasi' : 'Draft' }}
                    </span>
                  </div>
                  <div class="info-item">
                    <label class="text-sm font-medium text-gray-600">Tanggal Publikasi</label>
                    <p class="text-lg font-semibold text-gray-800">
                      {{ formatDate(laporan.tanggal_publikasi) }}
                    </p>
                  </div>
                  <div class="info-item">
                    <label class="text-sm font-medium text-gray-600">Dibuat Oleh</label>
                    <p class="text-lg font-semibold text-gray-800">
                      {{ laporan.admin?.name || 'Admin Diskominfo' }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- Statistics -->
              <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                  Statistik Pengaduan
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                  <div class="stat-card bg-blue-50 border-l-4 border-blue-500">
                    <div class="p-4">
                      <div class="text-2xl font-bold text-blue-600">
                        {{ laporan.total_pengaduan || 0 }}
                      </div>
                      <div class="text-sm text-gray-600">Total Pengaduan</div>
                    </div>
                  </div>
                  <div class="stat-card bg-yellow-50 border-l-4 border-yellow-500">
                    <div class="p-4">
                      <div class="text-2xl font-bold text-yellow-600">
                        {{ laporan.pengaduan_diproses || 0 }}
                      </div>
                      <div class="text-sm text-gray-600">Sedang Diproses</div>
                    </div>
                  </div>
                  <div class="stat-card bg-green-50 border-l-4 border-green-500">
                    <div class="p-4">
                      <div class="text-2xl font-bold text-green-600">
                        {{ laporan.pengaduan_selesai || 0 }}
                      </div>
                      <div class="text-sm text-gray-600">Selesai</div>
                    </div>
                  </div>
                  <div class="stat-card bg-red-50 border-l-4 border-red-500">
                    <div class="p-4">
                      <div class="text-2xl font-bold text-red-600">
                        {{ laporan.pengaduan_ditolak || 0 }}
                      </div>
                      <div class="text-sm text-gray-600">Ditolak</div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Description -->
              <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                  Deskripsi Laporan
                </h2>
                <div class="prose max-w-none">
                  <p class="text-gray-700 leading-relaxed">
                    {{ laporan.deskripsi || 'Berikut ini terlampir Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Juni Tahun 2025' }}
                  </p>
                </div>
              </div>

              <!-- Summary -->
              <div class="mb-8" v-if="laporan.ringkasan">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                  Ringkasan
                </h2>
                <div class="bg-gray-50 rounded-lg p-6">
                  <p class="text-gray-700 leading-relaxed">
                    {{ laporan.ringkasan }}
                  </p>
                </div>
              </div>

              <!-- Admin Notes -->
              <div class="mb-8" v-if="laporan.catatan_admin">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                  Catatan Admin
                </h2>
                <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
                  <p class="text-gray-700 leading-relaxed">
                    {{ laporan.catatan_admin }}
                  </p>
                </div>
              </div>

              <!-- File Attachment -->
              <div v-if="laporan.file_lampiran">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                  Lampiran Berita
                </h2>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                  <!-- PDF Preview Header -->
                  <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                      <div class="flex items-center">
                        <div class="bg-red-100 p-3 rounded-lg mr-4">
                          <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                        </div>
                        <div>
                          <h3 class="font-semibold text-gray-800 text-lg">
                            {{ getFileName(laporan.file_lampiran) }}
                          </h3>
                          <p class="text-sm text-gray-600 mt-1">
                            Laporan Pengaduan Pelayanan Publik Diskominfo Kota Madiun
                          </p>
                          <div class="flex items-center mt-2 text-xs text-gray-500">
                            <span class="mr-4">
                              <i class="fas fa-calendar-alt mr-1"></i>
                              {{ formatDate(laporan.tanggal_publikasi) }}
                            </span>
                            <span>
                              <i class="fas fa-file-alt mr-1"></i>
                              PDF Document
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="flex space-x-2">
                        <button @click="previewPDF" class="btn-preview">
                          <i class="fas fa-eye mr-2"></i>
                          Preview
                        </button>
                        <button @click="downloadLaporan" :disabled="isDownloading" class="btn-download-primary">
                          <div v-if="isDownloading" class="flex items-center">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                            <span>{{ Math.round(downloadProgress) }}%</span>
                          </div>
                          <div v-else class="flex items-center">
                            <i class="fas fa-download mr-2"></i>
                            Download File
                          </div>
                        </button>
                      </div>
                    </div>
                  </div>
                  
                  <!-- PDF Preview Area -->
                  <div v-if="showPreview" class="p-4">
                    <div class="bg-gray-100 rounded-lg p-4">
                      <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                          <i class="fas fa-file-pdf text-red-500 text-2xl mr-2"></i>
                          <span class="text-gray-700 font-medium">Preview PDF</span>
                        </div>
                        <button @click="showPreview = false" class="text-gray-500 hover:text-gray-700">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                      
                      <!-- PDF Thumbnail -->
                      <div class="mb-4">
                        <div class="bg-white border border-gray-300 rounded-lg p-4 flex items-center justify-center">
                          <div class="text-center">
                            <div class="bg-red-100 p-4 rounded-lg inline-block mb-3">
                              <i class="fas fa-file-pdf text-red-500 text-3xl"></i>
                            </div>
                            <p class="text-sm text-gray-600">{{ getFileName(laporan.file_lampiran) }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ getFileSize(laporan.file_lampiran) }}</p>
                          </div>
                        </div>
                      </div>
                      
                      <!-- PDF Viewer -->
                      <div class="bg-white border border-gray-300 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 border-b border-gray-300 flex items-center justify-between">
                          <span class="text-sm text-gray-600">PDF Viewer</span>
                          <div class="flex space-x-2">
                            <button class="text-gray-500 hover:text-gray-700 text-sm">
                              <i class="fas fa-search-plus"></i>
                            </button>
                            <button class="text-gray-500 hover:text-gray-700 text-sm">
                              <i class="fas fa-search-minus"></i>
                            </button>
                            <button class="text-gray-500 hover:text-gray-700 text-sm">
                              <i class="fas fa-expand"></i>
                            </button>
                          </div>
                        </div>
                        <iframe 
                          v-if="laporan.file_lampiran"
                          :src="laporan.file_lampiran + '#toolbar=0&navpanes=0&scrollbar=0'"
                          class="w-full h-96"
                          frameborder="0">
                        </iframe>
                        <div v-else class="h-96 flex items-center justify-center bg-gray-50">
                          <div class="text-center">
                            <i class="fas fa-file-pdf text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">PDF tidak tersedia untuk preview</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- File Info -->
                  <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                      <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span class="text-gray-600">Format: {{ getFileType(laporan.file_lampiran) }}</span>
                      </div>
                      <div class="flex items-center">
                        <i class="fas fa-weight-hanging text-orange-500 mr-2"></i>
                        <span class="text-gray-600">Ukuran: {{ getFileSize(laporan.file_lampiran) }}</span>
                      </div>
                      <div class="flex items-center">
                        <i class="fas fa-download text-green-500 mr-2"></i>
                        <span class="text-gray-600">Tersedia untuk download</span>
                      </div>
                      <div class="flex items-center">
                        <i class="fas fa-eye text-purple-500 mr-2"></i>
                        <span class="text-gray-600">Dapat di-preview</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="lg:col-span-1">
            <!-- Tags -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Tags</h3>
              <div class="flex flex-wrap gap-2">
                <span class="tag">Informasi Secara Berkala</span>
                <span class="tag">Laporan Pengaduan</span>
                <span class="tag">Pelayanan Publik</span>
                <span class="tag">Diskominfo Kota Madiun</span>
              </div>
            </div>

            <!-- Related Reports -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Terkait</h3>
              <div class="space-y-3">
                <div v-for="report in relatedReports" :key="report.id" class="related-item">
                  <a :href="report.link" class="block hover:bg-gray-50 p-3 rounded-lg transition-colors">
                    <h4 class="font-medium text-gray-800 text-sm mb-1">
                      {{ report.title }}
                    </h4>
                    <p class="text-xs text-gray-600">
                      {{ report.date }}
                    </p>
                  </a>
                </div>
              </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-lg p-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Kominfo Kota Madiun</h3>
              <div class="space-y-3 text-sm text-gray-600">
                <div class="flex items-start">
                  <i class="fas fa-map-marker-alt text-blue-500 mt-1 mr-3"></i>
                  <div>
                    <p>Jl. Perintis Kemerdekaan No. 32</p>
                    <p>Kel. Kartoharjo, Kecamatan Kartoharjo,</p>
                    <p>Kota Madiun, Jawa Timur.</p>
                  </div>
                </div>
                <div class="flex items-start">
                  <i class="fas fa-clock text-blue-500 mt-1 mr-3"></i>
                  <div>
                    <p class="font-medium">Jam Pelayanan :</p>
                    <p>Senin - Kamis (07.00 - 15.30)</p>
                    <p>Jumat (06.30 - 14.30)</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LaporanDetail',
  props: {
    laporan: {
      type: Object,
      required: true,
      default: () => ({
        judul: 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Juni Tahun 2025',
        bulan: 'Juni',
        tahun: '2025',
        deskripsi: 'Berikut ini terlampir Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Juni Tahun 2025',
        is_published: true,
        tanggal_publikasi: new Date(),
        total_pengaduan: 0,
        pengaduan_diproses: 0,
        pengaduan_selesai: 0,
        pengaduan_ditolak: 0,
        file_lampiran: null,
        admin: { name: 'Admin Diskominfo' }
      })
    }
  },
  data() {
    return {
      showPreview: false,
      isDownloading: false,
      downloadProgress: 0,
      relatedReports: [
        {
          id: 1,
          title: 'Laporan Pengaduan Pelayanan Publik Bulan Mei 2025',
          date: '23 Jun 2025',
          link: '#'
        },
        {
          id: 2,
          title: 'Laporan Pengaduan Pelayanan Publik Bulan April 2025',
          date: '23 May 2025',
          link: '#'
        },
        {
          id: 3,
          title: 'Laporan Pengaduan Pelayanan Publik Bulan Maret 2025',
          date: '23 Apr 2025',
          link: '#'
        }
      ]
    }
  },
  methods: {
    formatDate(date) {
      if (!date) return 'N/A';
      const d = new Date(date);
      return d.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
      });
    },
    getStatusClass(isPublished) {
      return isPublished 
        ? 'px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium'
        : 'px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium';
    },
    getFileName(filePath) {
      if (!filePath) return 'N/A';
      return filePath.split('/').pop();
    },
    getFileSize(filePath) {
      // Simulasi file size untuk demo
      if (!filePath) return 'N/A';
      const sizes = ['2.5 MB', '1.8 MB', '3.2 MB', '2.1 MB', '2.8 MB'];
      const randomIndex = Math.floor(Math.random() * sizes.length);
      return sizes[randomIndex];
    },
    getFileType(filePath) {
      if (!filePath) return 'N/A';
      const extension = filePath.split('.').pop().toLowerCase();
      const typeMap = {
        'pdf': 'PDF Document',
        'doc': 'Word Document',
        'docx': 'Word Document',
        'xls': 'Excel Spreadsheet',
        'xlsx': 'Excel Spreadsheet'
      };
      return typeMap[extension] || 'Document';
    },
    shareLaporan() {
      if (navigator.share) {
        navigator.share({
          title: this.laporan.judul,
          text: this.laporan.deskripsi,
          url: window.location.href
        });
      } else {
        // Fallback untuk browser yang tidak mendukung Web Share API
        navigator.clipboard.writeText(window.location.href);
        alert('Link telah disalin ke clipboard!');
      }
    },
    previewPDF() {
      this.showPreview = !this.showPreview;
    },
    async downloadLaporan() {
      if (this.laporan.file_lampiran) {
        try {
          this.isDownloading = true;
          this.downloadProgress = 0;
          
          // Simulasi progress download
          const progressInterval = setInterval(() => {
            if (this.downloadProgress < 90) {
              this.downloadProgress += Math.random() * 20;
            }
          }, 200);
          
          // Download file
          const link = document.createElement('a');
          link.href = this.laporan.file_lampiran;
          link.download = this.getFileName(this.laporan.file_lampiran);
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          
          // Complete progress
          this.downloadProgress = 100;
          clearInterval(progressInterval);
          
          // Reset after 2 seconds
          setTimeout(() => {
            this.isDownloading = false;
            this.downloadProgress = 0;
          }, 2000);
          
        } catch (error) {
          console.error('Download error:', error);
          this.isDownloading = false;
          this.downloadProgress = 0;
        }
      }
    }
  }
}
</script>

<style scoped>
.laporan-detail {
  background-color: #f8f9fa;
  min-height: 100vh;
  margin-top:5.7%;
}

.detail-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.btn-share {
  @apply bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2;
}

.btn-download {
  @apply bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2;
}

.btn-preview {
  @apply bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2;
}

.btn-download-primary {
  @apply bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center;
}

.btn-download-primary:disabled {
  @apply bg-gray-400 cursor-not-allowed;
}

.info-item {
  @apply p-4 bg-gray-50 rounded-lg;
}

.stat-card {
  @apply rounded-lg transition-transform duration-200 hover:scale-105;
}

.tag {
  @apply bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium;
}

.related-item {
  @apply border-b border-gray-200 last:border-b-0;
}

.prose {
  @apply text-gray-700;
}

.prose p {
  @apply mb-4;
}

.prose p:last-child {
  @apply mb-0;
}
</style>
