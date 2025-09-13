<template>
  <div class="recent-activity">
    <div class="row g-4">
      <!-- Latest Berita -->
      <div class="col-lg-4">
        <div class="activity-card">
          <div class="activity-header">
            <h5 class="activity-title">
              <i class="fas fa-newspaper"></i>
              Berita Terbaru
            </h5>
            <router-link to="/admin/berita" class="btn btn-sm btn-outline-primary">
              Lihat Semua
            </router-link>
          </div>
          <div class="activity-list">
            <div v-for="berita in stats.recent.latest_berita" :key="berita.id" class="activity-item">
              <div class="activity-icon">
                <i class="fas fa-file-alt" :class="getStatusIcon(berita.status)"></i>
              </div>
              <div class="activity-content">
                <h6 class="activity-title">{{ truncateText(berita.judul, 40) }}</h6>
                <div class="activity-meta">
                  <small class="text-muted">
                    <i class="fas fa-user"></i> {{ berita.admin_name }}
                  </small>
                  <small class="text-muted">
                    <i class="fas fa-clock"></i> {{ berita.created_at }}
                  </small>
                </div>
              </div>
              <div class="activity-status">
                <span class="badge" :class="getStatusBadge(berita.status)">
                  {{ berita.status }}
                </span>
              </div>
            </div>
            <div v-if="stats.recent.latest_berita.length === 0" class="empty-state">
              <i class="fas fa-newspaper fa-2x text-muted"></i>
              <p class="text-muted">Belum ada berita</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Latest Comments -->
      <div class="col-lg-4">
        <div class="activity-card">
          <div class="activity-header">
            <h5 class="activity-title">
              <i class="fas fa-comments"></i>
              Komentar Terbaru
            </h5>
            <router-link to="/admin/comments" class="btn btn-sm btn-outline-success">
              Lihat Semua
            </router-link>
          </div>
          <div class="activity-list">
            <div v-for="comment in stats.recent.latest_comments" :key="comment.id" class="activity-item">
              <div class="activity-icon">
                <i class="fas fa-comment" :class="getCommentIcon(comment.is_approved)"></i>
              </div>
              <div class="activity-content">
                <h6 class="activity-title">{{ truncateText(comment.comment, 35) }}</h6>
                <div class="activity-meta">
                  <small class="text-muted">
                    <i class="fas fa-user"></i> {{ comment.name }}
                  </small>
                  <small class="text-muted">
                    <i class="fas fa-clock"></i> {{ comment.created_at }}
                  </small>
                </div>
                <div class="activity-meta">
                  <small class="text-primary">
                    <i class="fas fa-newspaper"></i> {{ truncateText(comment.berita_title, 25) }}
                  </small>
                </div>
              </div>
              <div class="activity-status">
                <span class="badge" :class="getCommentBadge(comment.is_approved)">
                  {{ comment.is_approved ? 'Approved' : 'Pending' }}
                </span>
              </div>
            </div>
            <div v-if="stats.recent.latest_comments.length === 0" class="empty-state">
              <i class="fas fa-comments fa-2x text-muted"></i>
              <p class="text-muted">Belum ada komentar</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Latest Laporan -->
      <div class="col-lg-4">
        <div class="activity-card">
          <div class="activity-header">
            <h5 class="activity-title">
              <i class="fas fa-file-alt"></i>
              Laporan Terbaru
            </h5>
            <router-link to="/admin/laporan-pengaduan-admin" class="btn btn-sm btn-outline-info">
              Lihat Semua
            </router-link>
          </div>
          <div class="activity-list">
            <div v-for="laporan in stats.recent.latest_laporan" :key="laporan.id" class="activity-item">
              <div class="activity-icon">
                <i class="fas fa-file-alt" :class="getLaporanIcon(laporan.status)"></i>
              </div>
              <div class="activity-content">
                <h6 class="activity-title">{{ truncateText(laporan.judul, 40) }}</h6>
                <div class="activity-meta">
                  <small class="text-muted">
                    <i class="fas fa-user"></i> {{ laporan.admin_name }}
                  </small>
                  <small class="text-muted">
                    <i class="fas fa-clock"></i> {{ laporan.created_at }}
                  </small>
                </div>
              </div>
              <div class="activity-status">
                <span class="badge" :class="getLaporanBadge(laporan.status)">
                  {{ laporan.status }}
                </span>
              </div>
            </div>
            <div v-if="stats.recent.latest_laporan.length === 0" class="empty-state">
              <i class="fas fa-file-alt fa-2x text-muted"></i>
              <p class="text-muted">Belum ada laporan</p>
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

const truncateText = (text, maxLength) => {
  if (!text) return ''
  return text.length > maxLength ? text.substring(0, maxLength) + '...' : text
}

const getStatusIcon = (status) => {
  const icons = {
    published: 'text-success',
    draft: 'text-warning'
  }
  return icons[status] || 'text-secondary'
}

const getStatusBadge = (status) => {
  const badges = {
    published: 'bg-success',
    draft: 'bg-warning text-dark'
  }
  return badges[status] || 'bg-secondary'
}

const getCommentIcon = (isApproved) => {
  return isApproved ? 'text-success' : 'text-warning'
}

const getCommentBadge = (isApproved) => {
  return isApproved ? 'bg-success' : 'bg-warning text-dark'
}

const getLaporanIcon = (status) => {
  const icons = {
    completed: 'text-success',
    pending: 'text-warning',
    in_progress: 'text-info'
  }
  return icons[status] || 'text-secondary'
}

const getLaporanBadge = (status) => {
  const badges = {
    completed: 'bg-success',
    pending: 'bg-warning text-dark',
    in_progress: 'bg-info'
  }
  return badges[status] || 'bg-secondary'
}
</script>

<style scoped>
.recent-activity {
  margin-bottom: 2rem;
}

.activity-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  border: 1px solid #e9ecef;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.activity-header {
  padding: 1.5rem 1.5rem 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e9ecef;
}

.activity-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #2d3748;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.activity-title i {
  color: #667eea;
}

.activity-list {
  flex: 1;
  padding: 0;
}

.activity-item {
  padding: 1rem 1.5rem;
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  border-bottom: 1px solid #f1f3f4;
  transition: background-color 0.2s ease;
}

.activity-item:hover {
  background-color: #f8f9fa;
}

.activity-item:last-child {
  border-bottom: none;
}

.activity-icon {
  flex-shrink: 0;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f1f3f4;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6c757d;
  font-size: 0.875rem;
}

.activity-content {
  flex: 1;
  min-width: 0;
}

.activity-content .activity-title {
  font-size: 0.9rem;
  font-weight: 600;
  color: #2d3748;
  margin: 0 0 0.25rem 0;
  line-height: 1.3;
}

.activity-meta {
  display: flex;
  flex-direction: column;
  gap: 0.125rem;
  margin-bottom: 0.25rem;
}

.activity-meta small {
  font-size: 0.75rem;
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.activity-status {
  flex-shrink: 0;
}

.badge {
  font-size: 0.7rem;
  padding: 0.25rem 0.5rem;
  font-weight: 500;
}

.empty-state {
  padding: 2rem 1.5rem;
  text-align: center;
  color: #6c757d;
}

.empty-state i {
  margin-bottom: 0.5rem;
  opacity: 0.5;
}

.empty-state p {
  margin: 0;
  font-size: 0.875rem;
}

/* Responsive Design */
@media (max-width: 768px) {
  .activity-header {
    flex-direction: column;
    gap: 0.75rem;
    align-items: flex-start;
  }

  .activity-item {
    padding: 0.75rem 1rem;
    gap: 0.5rem;
  }

  .activity-icon {
    width: 28px;
    height: 28px;
    font-size: 0.8rem;
  }

  .activity-content .activity-title {
    font-size: 0.85rem;
  }

  .activity-meta small {
    font-size: 0.7rem;
  }
}

@media (max-width: 576px) {
  .activity-card {
    margin-bottom: 1rem;
  }

  .activity-header {
    padding: 1rem 1rem 0.75rem;
  }

  .activity-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }

  .activity-icon {
    align-self: flex-start;
  }

  .activity-status {
    align-self: flex-end;
  }

  .empty-state {
    padding: 1.5rem 1rem;
  }
}
</style>