<template>
  <div class="statistics-charts">
    <div class="row g-4">
      <!-- Monthly Berita Chart -->
      <div class="col-lg-6">
        <div class="chart-card">
          <div class="chart-header">
            <h5 class="chart-title">
              <i class="fas fa-chart-line"></i>
              Berita Per Bulan
            </h5>
            <div class="chart-controls">
              <select v-model="selectedPeriod" @change="updateChart" class="form-select form-select-sm">
                <option value="berita">Berita</option>
                <option value="comments">Komentar</option>
                <option value="laporan">Laporan</option>
              </select>
            </div>
          </div>
          <div class="chart-container">
            <canvas ref="chartCanvas" :width="chartWidth" :height="chartHeight"></canvas>
          </div>
        </div>
      </div>

      <!-- Category Distribution -->
      <div class="col-lg-6">
        <div class="chart-card">
          <div class="chart-header">
            <h5 class="chart-title">
              <i class="fas fa-chart-pie"></i>
              Distribusi Kategori Berita
            </h5>
          </div>
          <div class="chart-container">
            <canvas ref="pieChartCanvas" :width="chartWidth" :height="chartHeight"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Category Statistics Table -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="chart-card">
          <div class="chart-header">
            <h5 class="chart-title">
              <i class="fas fa-table"></i>
              Statistik Kategori
            </h5>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Kategori</th>
                  <th>Jumlah Berita</th>
                  <th>Persentase</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(count, category) in stats.categories.berita_by_category" :key="category">
                  <td>{{ category || 'Uncategorized' }}</td>
                  <td>{{ count }}</td>
                  <td>{{ calculatePercentage(count, totalBerita) }}%</td>
                  <td>
                    <span class="badge" :class="getStatusClass(count)">
                      {{ getStatusText(count) }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, nextTick } from 'vue'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  Filler
} from 'chart.js'
import { Line, Pie } from 'vue-chartjs'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  ArcElement,
  Title,
  Tooltip,
  Legend,
  Filler
)

const props = defineProps({
  stats: {
    type: Object,
    required: true
  }
})

const chartCanvas = ref(null)
const pieChartCanvas = ref(null)
const selectedPeriod = ref('berita')
const chartWidth = ref(400)
const chartHeight = ref(300)
let lineChart = null
let pieChart = null

const totalBerita = ref(0)

const updateChart = async () => {
  await nextTick()
  if (lineChart) {
    lineChart.destroy()
  }

  const ctx = chartCanvas.value.getContext('2d')
  const data = getChartData()

  lineChart = new ChartJS(ctx, {
    type: 'line',
    data: {
      labels: data.labels,
      datasets: [{
        label: getChartLabel(),
        data: data.values,
        borderColor: '#667eea',
        backgroundColor: 'rgba(102, 126, 234, 0.1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#667eea',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          titleColor: '#fff',
          bodyColor: '#fff',
          cornerRadius: 8,
          displayColors: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.1)'
          },
          ticks: {
            precision: 0
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      },
      interaction: {
        intersect: false,
        mode: 'index'
      }
    }
  })
}

const updatePieChart = async () => {
  await nextTick()
  if (pieChart) {
    pieChart.destroy()
  }

  const ctx = pieChartCanvas.value.getContext('2d')
  const categories = Object.keys(props.stats.categories.berita_by_category)
  const values = Object.values(props.stats.categories.berita_by_category)

  const colors = [
    '#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe',
    '#00f2fe', '#43e97b', '#38f9d7', '#fa709a', '#fee140'
  ]

  pieChart = new ChartJS(ctx, {
    type: 'pie',
    data: {
      labels: categories.map(cat => cat || 'Uncategorized'),
      datasets: [{
        data: values,
        backgroundColor: colors.slice(0, categories.length),
        borderColor: colors.slice(0, categories.length).map(color => color + 'dd'),
        borderWidth: 2,
        hoverBorderWidth: 3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            usePointStyle: true,
            font: {
              size: 12
            }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          titleColor: '#fff',
          bodyColor: '#fff',
          cornerRadius: 8,
          callbacks: {
            label: function(context) {
              const total = context.dataset.data.reduce((a, b) => a + b, 0)
              const percentage = ((context.parsed / total) * 100).toFixed(1)
              return `${context.label}: ${context.parsed} (${percentage}%)`
            }
          }
        }
      }
    }
  })
}

const getChartData = () => {
  const monthlyData = props.stats.monthly[`${selectedPeriod.value}_per_month`] || []
  return {
    labels: monthlyData.map(item => item.month),
    values: monthlyData.map(item => item.count)
  }
}

const getChartLabel = () => {
  const labels = {
    berita: 'Jumlah Berita',
    comments: 'Jumlah Komentar',
    laporan: 'Jumlah Laporan'
  }
  return labels[selectedPeriod.value] || 'Data'
}

const calculatePercentage = (count, total) => {
  if (total === 0) return 0
  return ((count / total) * 100).toFixed(1)
}

const getStatusClass = (count) => {
  if (count >= 10) return 'bg-success'
  if (count >= 5) return 'bg-warning'
  return 'bg-danger'
}

const getStatusText = (count) => {
  if (count >= 10) return 'Aktif'
  if (count >= 5) return 'Sedang'
  return 'Rendah'
}

const updateChartSize = () => {
  const container = chartCanvas.value?.parentElement
  if (container) {
    chartWidth.value = container.offsetWidth
    chartHeight.value = container.offsetHeight
  }
}

onMounted(async () => {
  totalBerita.value = props.stats.content.total_berita
  await nextTick()
  updateChartSize()
  updateChart()
  updatePieChart()

  window.addEventListener('resize', updateChartSize)
})

onUnmounted(() => {
  if (lineChart) {
    lineChart.destroy()
  }
  if (pieChart) {
    pieChart.destroy()
  }
  window.removeEventListener('resize', updateChartSize)
})

watch(() => props.stats, () => {
  totalBerita.value = props.stats.content.total_berita
  updateChart()
  updatePieChart()
}, { deep: true })
</script>

<style scoped>
.statistics-charts {
  margin-bottom: 2rem;
}

.chart-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  border: 1px solid #e9ecef;
  overflow: hidden;
}

.chart-header {
  padding: 1.5rem 1.5rem 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e9ecef;
  margin-bottom: 1rem;
}

.chart-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #2d3748;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.chart-title i {
  color: #667eea;
}

.chart-controls {
  display: flex;
  gap: 0.5rem;
}

.chart-container {
  padding: 0 1.5rem 1.5rem;
  height: 300px;
  position: relative;
}

.table-responsive {
  padding: 0 1.5rem 1.5rem;
}

.table {
  margin-bottom: 0;
}

.table th {
  background-color: #f8f9fa;
  border-bottom: 2px solid #dee2e6;
  font-weight: 600;
  color: #495057;
  padding: 0.75rem;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.table td {
  padding: 0.75rem;
  vertical-align: middle;
  border-bottom: 1px solid #e9ecef;
}

.table tbody tr:hover {
  background-color: #f8f9fa;
}

.badge {
  font-size: 0.75rem;
  padding: 0.375rem 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .chart-header {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }

  .chart-container {
    height: 250px;
  }

  .chart-controls {
    align-self: flex-end;
  }
}

@media (max-width: 576px) {
  .chart-card {
    margin-bottom: 1rem;
  }

  .chart-container {
    height: 200px;
    padding: 0 1rem 1rem;
  }

  .table-responsive {
    padding: 0 1rem 1rem;
  }

  .table th,
  .table td {
    padding: 0.5rem;
    font-size: 0.8rem;
  }
}
</style>