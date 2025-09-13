<template>
  <div class="statistics-cards">
    <div class="row g-4">
      <!-- Content Statistics -->
      <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-primary">
          <div class="stat-icon">
            <i class="fas fa-newspaper"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">{{ formatNumber(stats.content.total_berita) }}</h3>
            <p class="stat-label">Total Berita</p>
            <div class="stat-subtext">
              <span class="text-success">{{ formatNumber(stats.content.berita_published) }} published</span> |
              <span class="text-warning">{{ formatNumber(stats.content.berita_draft) }} draft</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-success">
          <div class="stat-icon">
            <i class="fas fa-comments"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">{{ formatNumber(stats.interaction.total_comments) }}</h3>
            <p class="stat-label">Total Komentar</p>
            <div class="stat-subtext">
              <span class="text-success">{{ formatNumber(stats.interaction.comments_approved) }} approved</span> |
              <span class="text-warning">{{ formatNumber(stats.interaction.comments_pending) }} pending</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-info">
          <div class="stat-icon">
            <i class="fas fa-file-alt"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">{{ formatNumber(stats.content.total_publikasi) }}</h3>
            <p class="stat-label">Total Publikasi</p>
            <div class="stat-subtext">
              <span class="text-primary">{{ formatNumber(stats.interaction.total_laporan_pengaduan) }} laporan</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-warning">
          <div class="stat-icon">
            <i class="fas fa-users"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">{{ formatNumber(stats.users.total_users) }}</h3>
            <p class="stat-label">Total Users</p>
            <div class="stat-subtext">
              <span class="text-info">{{ formatNumber(stats.users.total_admins) }} admins</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Statistics Row -->
      <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-secondary">
          <div class="stat-icon">
            <i class="fas fa-user-tie"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">{{ formatNumber(stats.content.total_profil) }}</h3>
            <p class="stat-label">Total Profil</p>
            <div class="stat-subtext">
              <span class="text-success">{{ formatNumber(stats.content.profil_active) }} active</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-danger">
          <div class="stat-icon">
            <i class="fas fa-question-circle"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">{{ formatNumber(stats.content.total_faq) }}</h3>
            <p class="stat-label">Total FAQ</p>
            <div class="stat-subtext">
              <span class="text-info">{{ formatNumber(stats.content.total_faq_categories) }} categories</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-dark">
          <div class="stat-icon">
            <i class="fas fa-eye"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">{{ formatNumber(stats.performance.total_views) }}</h3>
            <p class="stat-label">Total Views</p>
            <div class="stat-subtext">
              <span class="text-warning">{{ formatNumber(Math.round(stats.performance.average_views_per_berita)) }} avg per berita</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stat-card stat-card-light">
          <div class="stat-icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <div class="stat-content">
            <h3 class="stat-number">{{ formatNumber(stats.content.total_infografis) }}</h3>
            <p class="stat-label">Infografis</p>
            <div class="stat-subtext">
              <span class="text-primary">Visual content</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  stats: {
    type: Object,
    required: true
  }
})

const formatNumber = (num) => {
  if (num >= 1000000) {
    return (num / 1000000).toFixed(1) + 'M'
  } else if (num >= 1000) {
    return (num / 1000).toFixed(1) + 'K'
  }
  return num.toString()
}
</script>

<style scoped>
.statistics-cards {
  margin-bottom: 2rem;
}

.stat-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  display: flex;
  align-items: center;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  border: 1px solid #e9ecef;
  position: relative;
  overflow: hidden;
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #667eea, #764ba2);
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.stat-card-primary::before { background: linear-gradient(90deg, #667eea, #764ba2); }
.stat-card-success::before { background: linear-gradient(90deg, #48bb78, #38a169); }
.stat-card-info::before { background: linear-gradient(90deg, #17a2b8, #138496); }
.stat-card-warning::before { background: linear-gradient(90deg, #ffc107, #e0a800); }
.stat-card-danger::before { background: linear-gradient(90deg, #dc3545, #c82333); }
.stat-card-secondary::before { background: linear-gradient(90deg, #6c757d, #545b62); }
.stat-card-dark::before { background: linear-gradient(90deg, #343a40, #23272b); }
.stat-card-light::before { background: linear-gradient(90deg, #f8f9fa, #e9ecef); }

.stat-icon {
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  margin-right: 1rem;
  flex-shrink: 0;
}

.stat-card-primary .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
.stat-card-success .stat-icon { background: linear-gradient(135deg, #48bb78, #38a169); color: white; }
.stat-card-info .stat-icon { background: linear-gradient(135deg, #17a2b8, #138496); color: white; }
.stat-card-warning .stat-icon { background: linear-gradient(135deg, #ffc107, #e0a800); color: white; }
.stat-card-danger .stat-icon { background: linear-gradient(135deg, #dc3545, #c82333); color: white; }
.stat-card-secondary .stat-icon { background: linear-gradient(135deg, #6c757d, #545b62); color: white; }
.stat-card-dark .stat-icon { background: linear-gradient(135deg, #343a40, #23272b); color: white; }
.stat-card-light .stat-icon { background: linear-gradient(135deg, #f8f9fa, #e9ecef); color: #6c757d; }

.stat-content {
  flex: 1;
  min-width: 0;
}

.stat-number {
  font-size: 2rem;
  font-weight: 700;
  color: #2d3748;
  margin-bottom: 0.25rem;
  line-height: 1;
}

.stat-label {
  font-size: 0.9rem;
  color: #718096;
  font-weight: 600;
  margin-bottom: 0.25rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.stat-subtext {
  font-size: 0.75rem;
  color: #a0aec0;
  line-height: 1.2;
}

.stat-subtext span {
  font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
  .stat-card {
    padding: 1rem;
  }

  .stat-icon {
    width: 40px;
    height: 40px;
    font-size: 16px;
    margin-right: 0.75rem;
  }

  .stat-number {
    font-size: 1.5rem;
  }

  .stat-label {
    font-size: 0.8rem;
  }

  .stat-subtext {
    font-size: 0.7rem;
  }
}

@media (max-width: 576px) {
  .stat-card {
    flex-direction: column;
    text-align: center;
    padding: 1rem 0.75rem;
  }

  .stat-icon {
    margin-right: 0;
    margin-bottom: 0.75rem;
  }

  .stat-content {
    text-align: center;
  }
}
</style>