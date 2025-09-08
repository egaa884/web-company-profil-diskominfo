<template>
  <div class="struktur-detail-page">
    <div class="struktur-detail-container">
      <div class="struktur-detail-header">
        <h1 class="struktur-detail-title">Struktur Organisasi Lengkap</h1>
        <h2 class="struktur-detail-subtitle">Dinas Komunikasi dan Informatika Kota Madiun</h2>
        <div class="struktur-detail-divider"></div>
      </div>

      <div class="struktur-detail-content">
        <div class="struktur-image-wrapper">
          <img
            src="@/assets/img/strukturorg.png"
            alt="Struktur Organisasi Dinas Komunikasi dan Informatika Kota Madiun"
            class="struktur-image"
          />
        </div>
      </div>

      <div class="struktur-detail-actions">
        <button @click="goBack" class="struktur-back-button">
          ← Kembali
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const goBack = () => {
  router.go(-1) // Go back to previous page
}
</script>

<style scoped>
.struktur-detail-page {
  margin-top: 6%;
  min-height: 100vh;
  background-color: #f8fafc;
  padding: 2rem 1rem;
}

.struktur-detail-container {
  max-width: 1200px;
  margin: 0 auto;
  background-color: #ffffff;
  border-radius: 0.75rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  overflow: hidden;
}

.struktur-detail-header {
  text-align: center;
  padding: 3rem 2rem 2rem;
  background: linear-gradient(135deg, #2F7B52 0%, #0292D8 100%);
  color: white;
}

.struktur-detail-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

@media (max-width: 768px) {
  .struktur-detail-title {
    font-size: 2rem;
  }
}

.struktur-detail-subtitle {
  font-size: 1.25rem;
  font-weight: 500;
  opacity: 0.9;
  margin-bottom: 1.5rem;
}

.struktur-detail-divider {
  width: 6rem;
  height: 0.25rem;
  background-color: rgba(255, 255, 255, 0.8);
  margin: 0 auto;
  border-radius: 0.125rem;
}

.struktur-detail-content {
  padding: 3rem 2rem;
}

.struktur-image-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
}

.struktur-image {
  max-width: 100%;
  height: auto;
  border-radius: 0.5rem;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  display: block;
}

.struktur-detail-actions {
  padding: 2rem;
  text-align: center;
  background-color: #f8fafc;
  border-top: 1px solid #e2e8f0;
}

.struktur-back-button {
  padding: 0.75rem 2rem;
  background: linear-gradient(135deg, #2F7B52 0%, #0292D8 100%);
  color: white;
  border: none;
  border-radius: 0.5rem;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.struktur-back-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.struktur-back-button:active {
  transform: translateY(0);
}

@media (max-width: 768px) {
  .struktur-detail-page {
    padding: 1rem 0.5rem;
  }

  .struktur-detail-header {
    padding: 2rem 1rem 1.5rem;
  }

  .struktur-detail-content {
    padding: 2rem 1rem;
  }

  .struktur-detail-actions {
    padding: 1.5rem 1rem;
  }
}
</style>