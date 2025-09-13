<template>
  <div class="admin-dashboard">
    <!-- Loading State -->
    <div v-if="loading" class="loading-container">
      <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-muted">Memuat data dashboard...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="error-container">
      <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Gagal memuat data:</strong> {{ error }}
        <button @click="loadStatistics" class="btn btn-sm btn-outline-danger ms-3">
          <i class="fas fa-redo"></i> Coba Lagi
        </button>
      </div>
    </div>

    <!-- Dashboard Content -->
    <div v-else>
      <!-- Welcome Section -->
      <div class="welcome-section mb-4">
        <div class="welcome-content">
          <h1 class="welcome-title">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard Admin
          </h1>
          <p class="welcome-subtitle">
            Selamat datang, {{ adminName }}! Berikut ringkasan aktivitas sistem hari ini.
          </p>
          <div class="last-updated">
            <small class="text-muted">
              <i class="fas fa-clock"></i>
              Terakhir diperbarui: {{ formatDateTime(lastUpdated) }}
            </small>
          </div>
        </div>
        <div class="welcome-actions">
          <button @click="refreshData" class="btn btn-primary" :disabled="loading">
            <i class="fas fa-sync-alt" :class="{ 'fa-spin': loading }"></i>
            Refresh Data
          </button>
        </div>
      </div>

      <!-- Statistics Cards -->
      <StatisticsCards :stats="statistics" />

      <!-- Charts Section -->
      <StatisticsCharts :stats="statistics" />

      <!-- Recent Activity Section -->
      <RecentActivity :stats="statistics" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import StatisticsCards from './StatisticsCards.vue'
import StatisticsCharts from './StatisticsCharts.vue'
import RecentActivity from './RecentActivity.vue'

// Reactive data
const statistics = ref({})
const loading = ref(true)
const error = ref(null)
const lastUpdated = ref(null)
const adminName = ref('Admin')

// Load statistics from API
const loadStatistics = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await axios.get('/api/admin/statistics', {
      headers: {
        'Authorization': `Bearer ${getAuthToken()}`,
        'Accept': 'application/json'
      }
    })

    if (response.data.success) {
      statistics.value = response.data.data
      lastUpdated.value = response.data.timestamp
      adminName.value = getAdminName()
    } else {
      throw new Error(response.data.message || 'Failed to load statistics')
    }
  } catch (err) {
    console.error('Statistics loading error:', err)
    error.value = err.response?.data?.message || err.message || 'Failed to load statistics'
  } finally {
    loading.value = false
  }
}

// Refresh data
const refreshData = () => {
  loadStatistics()
}

// Get auth token from localStorage or wherever it's stored
const getAuthToken = () => {
  // This should be replaced with your actual auth token retrieval logic
  return localStorage.getItem('admin_token') || ''
}

// Get admin name from localStorage or wherever it's stored
const getAdminName = () => {
  // This should be replaced with your actual admin name retrieval logic
  return localStorage.getItem('admin_name') || 'Admin'
}

// Format date time
const formatDateTime = (dateString) => {
  if (!dateString) return 'Never'
  const date = new Date(dateString)
  return date.toLocaleString('id-ID', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Auto-refresh every 5 minutes
let refreshInterval = null

const startAutoRefresh = () => {
  refreshInterval = setInterval(() => {
    if (!loading.value) {
      loadStatistics()
    }
  }, 5 * 60 * 1000) // 5 minutes
}

const stopAutoRefresh = () => {
  if (refreshInterval) {
    clearInterval(refreshInterval)
    refreshInterval = null
  }
}

// Lifecycle hooks
onMounted(() => {
  loadStatistics()
  startAutoRefresh()
})

// Cleanup on unmount
import { onUnmounted } from 'vue'
onUnmounted(() => {
  stopAutoRefresh()
})
</script>

<style scoped>
.admin-dashboard {
  padding: 1.5rem;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
}

.loading-container,
.error-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 50vh;
}

.loading-spinner {
  text-align: center;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
}

.welcome-section {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-radius: 20px;
  padding: 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  position: relative;
  overflow: hidden;
}

.welcome-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #667eea, #764ba2);
}

.welcome-content {
  flex: 1;
}

.welcome-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #2d3748;
  margin-bottom: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.welcome-title i {
  color: #667eea;
}

.welcome-subtitle {
  font-size: 1.1rem;
  color: #718096;
  font-weight: 400;
  margin-bottom: 0.5rem;
}

.last-updated {
  margin-top: 0.5rem;
}

.last-updated small {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.welcome-actions {
  flex-shrink: 0;
  margin-left: 2rem;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea, #764ba2);
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 10px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.btn-primary:disabled {
  opacity: 0.6;
  transform: none;
  cursor: not-allowed;
}

/* Alert styling */
.alert {
  border-radius: 12px;
  border: none;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.alert-danger {
  background: linear-gradient(135deg, #fee2e2, #fecaca);
  color: #dc2626;
}

/* Responsive Design */
@media (max-width: 768px) {
  .admin-dashboard {
    padding: 1rem;
  }

  .welcome-section {
    flex-direction: column;
    text-align: center;
    padding: 1.5rem;
    gap: 1rem;
  }

  .welcome-title {
    font-size: 2rem;
    flex-direction: column;
    gap: 0.5rem;
  }

  .welcome-actions {
    margin-left: 0;
  }

  .welcome-actions .btn {
    width: 100%;
  }
}

@media (max-width: 576px) {
  .welcome-title {
    font-size: 1.8rem;
  }

  .welcome-subtitle {
    font-size: 1rem;
  }
}

/* Animation for loading */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.admin-dashboard > div {
  animation: fadeIn 0.5s ease-out;
}
</style>