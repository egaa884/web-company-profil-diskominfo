<template>
    <HeroSection 
      firstLine="SURVEI"
      secondLine="KEPUASAN MASYARAKAT"
      thirdLine="DISKOMINFO KOTA MADIUN"
      :backgroundImage="LogoKominfo"
    />
  <div class="min-h-screen bg-gray-100 flex flex-col items-center py-20">
    <h1 class="text-3xl font-bold mb-10">Survei Kepuasan Masyarakat</h1>

    <!-- Sertifikat Card 1 -->
    <SertifikatCard 
      :image="SertifImage"
      pdf="/sertifikat.pdf"
      title="Survei Kepuasan Masyarakat 2025"
    />
  </div>
</template>

<script setup>
import SertifikatCard from "@/components/global/SertifikatCard.vue";
import LogoKominfo from "@/assets/img/logo-kominfo.png";
import HeroSection from "@/components/global/HeroSection.vue";
import SertifImage from "@/assets/img/sertif1.0.png"
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
  margin-top: 6%;
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

/* Survei Card Styles */
.survei-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
}

.survei-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.image-container {
  width: 100%;
  height: 250px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  overflow: hidden;
  position: relative;
}

.survei-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.survei-card:hover .survei-image {
  transform: scale(1.05);
}

.content-section {
  padding: 1.5rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.survei-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: #2d3748;
  margin-bottom: 0.75rem;
  line-height: 1.4;
}

.survei-description {
  color: #4a5568;
  line-height: 1.6;
  margin-bottom: 1rem;
  flex: 1;
}

.metadata {
  margin-bottom: 1.5rem;
}

.metadata-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 0;
  border-bottom: 1px solid #e2e8f0;
}

.metadata-item:last-child {
  border-bottom: none;
}

.label {
  font-weight: 600;
  color: #4a5568;
}

.value {
  color: #2d3748;
  font-weight: 500;
}

.satisfaction-score {
  color: #38a169;
  font-weight: 700;
  font-size: 1.1rem;
}

.action-buttons {
  display: flex;
  gap: 0.75rem;
  margin-top: auto;
}

.btn-primary, .btn-secondary {
  padding: 0.75rem 1rem;
  border-radius: 8px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
  flex: 1;
  justify-content: center;
}

.btn-primary {
  background-color: #4299e1;
  color: white;
}

.btn-primary:hover {
  background-color: #3182ce;
  transform: translateY(-2px);
}

.btn-secondary {
  background-color: #e2e8f0;
  color: #4a5568;
}

.btn-secondary:hover {
  background-color: #cbd5e0;
  transform: translateY(-2px);
}

/* Fallback Card */
.fallback-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  max-width: 500px;
  width: 100%;
}

/* Responsive Design */
@media (max-width: 768px) {
  .grid {
    grid-template-columns: 1fr;
  }
  
  .survei-card {
    margin: 0 1rem;
  }
  
  .action-buttons {
    flex-direction: column;
  }
}
</style>
