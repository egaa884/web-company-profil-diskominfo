<template>
  <div>
    <HeroSection />
    
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Memuat data laporan pengaduan...</p>
    </div>
    
    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <div class="error-message">
        <h3>Terjadi Kesalahan</h3>
        <p>{{ error }}</p>
        <button @click="fetchLaporanPengaduan" class="retry-button">Coba Lagi</button>
      </div>
    </div>
    
    <!-- Content -->
    <div v-else>

      
      <!-- Statistics Section -->
      <div v-if="statistics" class="statistics-section">
        <div class="container mx-auto px-4 py-8">
          <h2 class="text-2xl font-bold text-center mb-8">Statistik Laporan Pengaduan</h2>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-card bg-blue-500 text-white">
              <h3>Total Laporan</h3>
              <p class="text-3xl font-bold">{{ statistics.total_published || 0 }}</p>
            </div>
            <div class="stat-card bg-green-500 text-white">
              <h3>Total Pengaduan</h3>
              <p class="text-3xl font-bold">{{ statistics.total_reports || 0 }}</p>
            </div>
            <div class="stat-card bg-blue-600 text-white">
              <h3>Diproses</h3>
              <p class="text-3xl font-bold">{{ statistics.processed_reports || 0 }}</p>
            </div>
            <div class="stat-card bg-green-600 text-white">
              <h3>Selesai</h3>
              <p class="text-3xl font-bold">{{ statistics.completed_reports || 0 }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Filter Section -->
      <div class="filter-section bg-gray-100 py-6">
        <div class="container mx-auto px-4">
          <div class="flex flex-wrap gap-4 items-center justify-center mb-4">
            <select v-model="filters.bulan" @change="applyFilters" class="filter-select">
              <option value="">Semua Bulan</option>
              <option v-for="month in categories" :key="month" :value="month">
                {{ month }}
              </option>
            </select>
            
            <select v-model="filters.tahun" @change="applyFilters" class="filter-select">
              <option value="">Semua Tahun</option>
              <option value="2023">2023</option>
              <option value="2024">2024</option>
              <option value="2025">2025</option>
              <option value="2026">2026</option>
            </select>
            
            <input 
              v-model="filters.search" 
              @input="applyFilters" 
              type="text" 
              placeholder="Cari laporan..." 
              class="filter-input"
            >
          </div>
          
          <!-- Info -->
          <div class="flex justify-center">
            <div class="info-box">
              <i class="fas fa-info-circle"></i>
              <span>Laporan dibuat oleh Admin Diskominfo Kota Madiun</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Laporan List -->
      <CardList :cards="laporanList" />
      
      <!-- Pagination -->
      <div v-if="pagination && pagination.last_page > 1" class="pagination-section">
        <div class="container mx-auto px-4 py-6">
          <div class="flex justify-center items-center space-x-2">
            <button 
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="pagination-button"
              :class="{ 'disabled': pagination.current_page === 1 }"
            >
              Sebelumnya
            </button>
            
            <span class="pagination-info">
              Halaman {{ pagination.current_page }} dari {{ pagination.last_page }}
            </span>
            
            <button 
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="pagination-button"
              :class="{ 'disabled': pagination.current_page === pagination.last_page }"
            >
              Selanjutnya
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import HeroSection from '@/components/laporanpengaduanadmin/HeroSection.vue';
import CardList from '@/components/laporanpengaduanadmin/CardList.vue';
import { laporanPengaduanAdminService } from '@/service/api.js';

export default {
  name: 'LaporanPengaduan',
  components: {
    HeroSection,
    CardList
  },
  setup() {
    const loading = ref(true);
    const error = ref(null);
    const laporanList = ref([]);
    const statistics = ref(null);
    const categories = ref([]);
    const pagination = ref(null);
    const filters = ref({
      bulan: '',
      tahun: '',
      search: ''
    });


    const fetchLaporanPengaduan = async () => {
      try {
        loading.value = true;
        error.value = null;
        
        console.log('Fetching admin laporan pengaduan...');
        
        const params = {
          page: pagination.value?.current_page || 1,
          ...filters.value
        };
        
        console.log('Request params:', params);
        
        const response = await laporanPengaduanAdminService.getAllLaporanPengaduanAdmin(params);
        
        console.log('Response received:', response);
        console.log('Response data:', response.data);
        
        if (response.data && response.data.data) {
          laporanList.value = response.data.data.map(item => ({
            id: item.id,
            foto: item.file_lampiran ? item.file_lampiran : '/src/assets/img/berita/laporan1.jpeg',
            judul: item.full_title,
            tanggal: new Date(item.tanggal_publikasi || item.created_at).toLocaleDateString('id-ID', {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            }),
            penjelasan: item.deskripsi,
            status: item.published_label,
            prioritas: `${item.total_pengaduan} Total`,
            kategori: item.kategori,
            link: `#laporan-${item.id}`,
            period: item.period,
            total_pengaduan: item.total_pengaduan,
            pengaduan_selesai: item.pengaduan_selesai,
            pengaduan_diproses: item.pengaduan_diproses,
            pengaduan_ditolak: item.pengaduan_ditolak,
            file_lampiran: item.file_lampiran
          }));
          
          pagination.value = response.data;
          console.log('Data processed successfully. Total items:', laporanList.value.length);
        } else {
          console.error('Invalid response structure:', response);
          error.value = 'Format data tidak valid. Silakan coba lagi.';
        }
      } catch (err) {
        console.error('Error fetching admin laporan pengaduan:', err);
        console.error('Error details:', {
          message: err.message,
          status: err.response?.status,
          data: err.response?.data
        });
        
        if (err.code === 'ECONNREFUSED') {
          error.value = 'Tidak dapat terhubung ke server. Pastikan backend berjalan di port 8000.';
        } else if (err.code === 'ECONNABORTED') {
          error.value = 'Request timeout. Server mungkin lambat atau tidak merespons.';
        } else if (err.response?.status === 500) {
          error.value = 'Server error. Ada masalah di backend.';
        } else {
          error.value = 'Gagal memuat data laporan pengaduan. Silakan coba lagi.';
        }
      } finally {
        loading.value = false;
      }
    };

    const fetchStatistics = async () => {
      try {
        const response = await laporanPengaduanAdminService.getStatistics();
        statistics.value = response.data.data;
      } catch (err) {
        console.error('Error fetching admin statistics:', err);
        // Tidak set error utama karena ini bukan data kritis
      }
    };

    const fetchCategories = async () => {
      try {
        const response = await laporanPengaduanAdminService.getMonths();
        categories.value = response.data.data;
      } catch (err) {
        console.error('Error fetching months:', err);
        // Tidak set error utama karena ini bukan data kritis
      }
    };

    const applyFilters = () => {
      pagination.value = null;
      fetchLaporanPengaduan();
    };

    const changePage = (page) => {
      if (page >= 1 && page <= pagination.value?.last_page) {
        pagination.value.current_page = page;
        fetchLaporanPengaduan();
      }
    };



    onMounted(async () => {
      try {
        // Fetch data secara parallel tapi handle error secara individual
        await Promise.allSettled([
          fetchStatistics(),
          fetchCategories(),
          fetchLaporanPengaduan()
        ]);
      } catch (err) {
        console.error('Error in onMounted:', err);
        error.value = 'Gagal memuat data. Silakan coba lagi.';
      }
    });

          return {
        loading,
        error,
        laporanList,
        statistics,
        categories,
        pagination,
        filters,
        fetchLaporanPengaduan,
        applyFilters,
        changePage
      };
  }
};
</script>

<style scoped>
/* Loading Styles */
.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 4rem 2rem;
  text-align: center;
  margin-top:6%;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 1rem;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Error Styles */
.error-container {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4rem 2rem;
}

.error-message {
  text-align: center;
  max-width: 500px;
}

.error-message h3 {
  color: #e74c3c;
  margin-bottom: 1rem;
}



/* Info Box Styles */
.info-box {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 20px;
  background-color: #e3f2fd;
  color: #1976d2;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
}

.info-box i {
  font-size: 16px;
}

.retry-button {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 0.375rem;
  cursor: pointer;
  margin-top: 1rem;
  transition: background-color 0.2s;
}

.retry-button:hover {
  background-color: #2980b9;
}

/* Statistics Styles */
.statistics-section {
  background-color: #f8f9fa;
}

.stat-card {
  padding: 1.5rem;
  border-radius: 0.5rem;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.stat-card h3 {
  font-size: 1rem;
  margin-bottom: 0.5rem;
  opacity: 0.9;
}

/* Filter Styles */
.filter-select, .filter-input {
  padding: 0.5rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  background-color: white;
  min-width: 150px;
}

.filter-input {
  min-width: 200px;
}

.filter-select:focus, .filter-input:focus {
  outline: none;
  border-color: #3498db;
  box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

/* Pagination Styles */
.pagination-section {
  background-color: #f8f9fa;
}

.pagination-button {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
  transition: background-color 0.2s;
}

.pagination-button:hover:not(.disabled) {
  background-color: #2980b9;
}

.pagination-button.disabled {
  background-color: #bdc3c7;
  cursor: not-allowed;
}

.pagination-info {
  padding: 0.5rem 1rem;
  background-color: white;
  border-radius: 0.375rem;
  border: 1px solid #d1d5db;
}

/* Action Button */
.action-button {
  background-color: #27ae60;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 0.375rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.action-button:hover {
  background-color: #229954;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 1rem;
}

.modal-content {
  background: white;
  border-radius: 8px;
  max-width: 90vw;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.modal-header h3 {
  margin: 0;
  color: #2c3e50;
  font-size: 1.5rem;
}

.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #6b7280;
  padding: 0;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: background-color 0.2s;
}

.modal-close:hover {
  background-color: #f3f4f6;
}

.modal-body {
  padding: 1.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .filter-section .flex {
    flex-direction: column;
    align-items: stretch;
  }
  
  .filter-select, .filter-input {
    min-width: auto;
    width: 100%;
  }
  
  .modal-content {
    max-width: 95vw;
    max-height: 95vh;
  }
  
  .modal-header,
  .modal-body {
    padding: 1rem;
  }
}
</style>