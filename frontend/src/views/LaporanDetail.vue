<template>
  <div>
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin"></i>
        <p>Memuat detail laporan...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <div class="error-message">
        <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Terjadi Kesalahan</h3>
        <p class="text-gray-600 mb-4">{{ error }}</p>
        <button @click="fetchLaporanDetail" class="retry-button">
          <i class="fas fa-redo mr-2"></i>
          Coba Lagi
        </button>
      </div>
    </div>

    <!-- Content -->
    <div v-else>
      <LaporanDetail :laporan="laporanData" />
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import LaporanDetail from '@/components/laporanpengaduanadmin/LaporanDetail.vue';
import { laporanPengaduanAdminService } from '@/service/api.js';

export default {
  name: 'LaporanDetailPage',
  components: {
    LaporanDetail
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const loading = ref(true);
    const error = ref(null);
    const laporanData = ref({});

    const fetchLaporanDetail = async () => {
      try {
        loading.value = true;
        error.value = null;
        
        const laporanId = route.params.id;
        console.log('Fetching laporan detail for ID:', laporanId);
        
        const response = await laporanPengaduanAdminService.getLaporanPengaduanAdminById(laporanId);
        
        console.log('Laporan detail response:', response);
        console.log('Response data:', response.data);
        console.log('Response success:', response.data?.success);
        
        if (response.data && response.data.success) {
          laporanData.value = response.data.data;
          console.log('Laporan data set:', laporanData.value);
        } else {
          console.error('Response tidak berhasil:', response.data);
          throw new Error('Data laporan tidak ditemukan atau response tidak valid');
        }
      } catch (err) {
        console.error('Error fetching laporan detail:', err);
        
        if (err.response?.status === 404) {
          error.value = 'Laporan tidak ditemukan';
        } else if (err.code === 'ECONNREFUSED') {
          error.value = 'Tidak dapat terhubung ke server. Pastikan backend berjalan di port 8000.';
        } else if (err.code === 'ECONNABORTED') {
          error.value = 'Request timeout. Server mungkin lambat atau tidak merespons.';
        } else if (err.response?.status === 500) {
          error.value = 'Server error (500). Ada masalah di backend.';
        } else if (err.response?.status === 403) {
          error.value = 'Akses ditolak (403).';
        } else {
          console.error('Full error object:', err);
          error.value = `Gagal memuat detail laporan: ${err.message || 'Unknown error'}`;
        }
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchLaporanDetail();
    });

    return {
      loading,
      error,
      laporanData,
      fetchLaporanDetail
    };
  }
};
</script>

<style scoped>
.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 60vh;
  background-color: #f8f9fa;
}

.loading-spinner {
  text-align: center;
  color: #6b7280;
}

.loading-spinner i {
  font-size: 3rem;
  margin-bottom: 1rem;
  color: #3b82f6;
}

.loading-spinner p {
  font-size: 1.1rem;
  font-weight: 500;
}

.error-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 60vh;
  background-color: #f8f9fa;
}

.error-message {
  text-align: center;
  max-width: 500px;
  padding: 2rem;
}

.retry-button {
  background-color: #3b82f6;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 0.375rem;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
  display: inline-flex;
  align-items: center;
}

.retry-button:hover {
  background-color: #2563eb;
}
</style>
