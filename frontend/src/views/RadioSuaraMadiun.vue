<template>
  <div class="app-container">
    <HeroSection 
      firstLine="BERITA"
      secondLine="RADIO SUARA MADIUN"
      thirdLine="DISKOMINFO KOTA MADIUN"
      backgroundImage="@/assets/img/logo-kominfo.png"
    />
    <div class="main-content">
      <div class="top-row">
        <RadioPlayer/>
        <Download />
      </div>
      <h2 class="section-title">Dengarkan Sekarang</h2>
      <div class="promo-section">
        <h3 class="promo-title">Teman Setia Warga Kota Madiun</h3>
        <p class="promo-text">
          Media informasi dan hiburan dari Pemerintah Kota Madiun, hadir 24 jam untuk masyarakat.
        </p>
      </div>
      <div class="video-grid">
        <VideoCard :videoSource="video1" title="SKM Tahun 2024, Standar Pelayanan..." />
        <VideoCard :videoSource="video2" title="BINCANG BINTANG | MEGA DAN NILAM" />
        <VideoCard :videoSource="video3" title="Lorem ipsum dolor sit amet, consectetur..." />
      </div>
    </div>
  </div>
</template>

<script setup>
import VideoCard from '@/components/radiosuara/VideoCard.vue';
import Download from '@/components/radiosuara/Download.vue';
import RadioPlayer from '@/components/radiosuara/RadioPlayer.vue';
import HeroSection from '../components/global/HeroSection.vue';

// --- BAGIAN PENTING: IMPORT FILE VIDEO DENGAN BENAR ---
// Vite akan memproses file ini dan memberikan URL yang valid
import video1 from '@/assets/video/radio1.mp4';
import video2 from '@/assets/video/radio2.mp4';
import video3 from '@/assets/video/radio3.mp4';
// ---------------------------------------------------
</script>

<style scoped>
.hero-section {
  width: 100vw;
  margin-left: calc(-50vw + 50%); /* trik biar full kanan-kiri meskipun ada container */
}
/* Tambahkan gaya CSS di sini */
.app-container {
  background-color: #03419f;
  color: white;
  min-height: 100vh;
  padding: 20px;
}
.main-content {
  max-width: 1200px;
  margin: 0 auto;
}
.top-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  margin-top: 20px;
}
.section-title {
  text-align: center;
  margin-top: 50px;
  font-family: 'Arial Rounded MT Bold', sans-serif; /* Ganti dengan font yang sesuai */
  font-size: 2.5rem;
  color: #c0e3ff;
}
.promo-section {
  text-align: center;
  margin-top: 20px;
}
.promo-title {
  font-size: 1.8rem;
  font-weight: bold;
}
.promo-text {
  font-size: 1rem;
  max-width: 600px;
  margin: 10px auto;
}
.video-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 40px;
}
</style>