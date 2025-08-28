<template>
  <div class="card-list-container">
    <div class="card-grid">
      <div v-for="card in cards" :key="card.id" class="card">
        <div class="card-header">
          <div class="card-badges">
            <span class="badge status-badge published">
              {{ card.status }}
            </span>
            <span class="badge period-badge">
              {{ card.period }}
            </span>
          </div>
        </div>
        <div class="card-content">
          <h3 class="card-title">{{ card.judul }}</h3>
          <p class="card-date">{{ card.tanggal }}</p>
          <p class="card-description">{{ card.penjelasan }}</p>
          
          <!-- Statistics -->
          <div class="card-stats">
            <div class="stat-item">
              <span class="stat-label">Total:</span>
              <span class="stat-value">{{ card.total_pengaduan }}</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">Selesai:</span>
              <span class="stat-value success">{{ card.pengaduan_selesai }}</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">Diproses:</span>
              <span class="stat-value processing">{{ card.pengaduan_diproses }}</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">Ditolak:</span>
              <span class="stat-value rejected">{{ card.pengaduan_ditolak }}</span>
            </div>
          </div>
          
          <!-- Card Actions -->
          <div class="card-actions">
            <router-link :to="`/pengaduan/${card.id}`" class="detail-button">
              <i class="fas fa-eye"></i>
              Lihat Detail
            </router-link>
            <a v-if="card.file_lampiran" 
               :href="card.file_lampiran" 
               target="_blank" 
               class="download-button"
               download>
              <i class="fas fa-download"></i>
              Download
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardList',
  props: {
    cards: {
      type: Array,
      required: true
    }
  }
};
</script>

<style scoped>
.card-list-container {
  padding: 20px;
}

.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border: 1px solid #e5e7eb;
}

.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-header {
  padding: 16px 20px 0;
}

.card-badges {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.badge {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.status-badge.published {
  background-color: #10b981;
  color: white;
}

.period-badge {
  background-color: #3b82f6;
  color: white;
}

.card-content {
  padding: 16px 20px 20px;
}

.card-title {
  font-size: 18px;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 8px;
  line-height: 1.4;
}

.card-date {
  font-size: 14px;
  color: #6b7280;
  margin-bottom: 12px;
}

.card-description {
  font-size: 14px;
  color: #4b5563;
  line-height: 1.6;
  margin-bottom: 16px;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.card-stats {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 8px;
  margin-bottom: 16px;
  padding: 12px;
  background-color: #f9fafb;
  border-radius: 8px;
}

.stat-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 13px;
}

.stat-label {
  color: #6b7280;
  font-weight: 500;
}

.stat-value {
  font-weight: 700;
  color: #1f2937;
}

.stat-value.success {
  color: #10b981;
}

.stat-value.processing {
  color: #3b82f6;
}

.stat-value.rejected {
  color: #ef4444;
}

.card-actions {
  display: flex;
  gap: 8px;
  justify-content: center;
}

.detail-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  background-color: #10b981;
  color: white;
  text-decoration: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 14px;
  transition: background-color 0.2s ease;
}

.detail-button:hover {
  background-color: #059669;
  color: white;
}

.detail-button i {
  font-size: 16px;
}

.download-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  background-color: #3b82f6;
  color: white;
  text-decoration: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 14px;
  transition: background-color 0.2s ease;
}

.download-button:hover {
  background-color: #2563eb;
  color: white;
}

.download-button i {
  font-size: 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
  .card-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  
  .card-stats {
    grid-template-columns: 1fr;
  }
  
  .card-title {
    font-size: 16px;
  }
}

@media (max-width: 480px) {
  .card-list-container {
    padding: 16px;
  }
  
  .card-content {
    padding: 12px 16px 16px;
  }
}
</style>
