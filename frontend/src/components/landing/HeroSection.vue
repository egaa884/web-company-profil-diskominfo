<template>
  <div class="hero-container"> <video
      ref="videoPlayer"
      class="hero-video" autoplay
      muted
      loop
      playsinline
      poster="@/assets/img/ppid.jpg" >
      <source src="@/assets/video/video-drone-madiun.mp4" type="video/mp4"> Browser Anda tidak mendukung tag video.
    </video>

    <div class="overlay-content">
      <div class="welcome-text-wrapper">
        <h1 class="welcome-text">Selamat Datang</h1>
        <h1 class="welcome-text"><span></span></h1>
      </div>
      <div class="logo-wrapper">
        <img src="@/assets/img/logo-madiun-pesilat.png" alt="Logo Kota Madiun" class="city-logo" /> </div>
    </div>

    <div class="wave-shape">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f3f4f5" fill-opacity="1" d="M0,288L80,282.7C160,277,320,267,480,272C640,277,800,299,960,304C1120,309,1280,299,1360,293.3L1440,288L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path></svg>
</div>
  </div>
</template>


<script setup>
import { ref } from 'vue'; // Hapus onMounted/onUnmounted jika tidak perlu

// Hapus ref heroContainer dan logika JS di onMounted/onUnmounted
</script>

<style scoped>
.hero-container { /* Ganti class dari hero-video-fixed-container */
  position: relative; /* TIDAK FIXED LAGI */
  width: 100%;
  height: 700px; /* Kembali ke tinggi statis, sesuaikan sesuai kebutuhan */
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: black;
  z-index: 0; /* Kembali ke z-index normal, ini akan menggulir */
}

.hero-video { /* Ganti class dari main-video-fixed */
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  position: absolute; /* Video tetap absolut di dalam kontainer relatif */
  top: 0;
  left: 0;
  z-index: 0;
}

.overlay-content {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 5%;
  pointer-events: none;
  z-index: 1;
}

.welcome-text-wrapper {
  background-color: transparent;
  padding: 15px 30px;
  pointer-events: auto;
}

.welcome-text {
  color: white;
  font-size: 3em;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
  margin: 0;
}

.logo-wrapper {
  background-color: transparent;
  pointer-events: auto;
}

.city-logo {
  height: 300px;
  width: auto;
  object-fit: contain;
}

.wave-shape {
  position: absolute;
  bottom: -1px;
  left: 0;
  width: 100%;
  line-height: 0;
  z-index: 2;
}

.wave-shape svg {
    display: block;
    width: 100%;
    height: auto;
}

@media (max-width: 768px) {
  .hero-container { /* Ganti class */
    height: 400px; /* Tinggi di mobile */
  }
  .welcome-text {
    font-size: 2em;
  }
  .city-logo {
    height: 100px;
  }
  .overlay-content {
    flex-direction: column;
    justify-content: space-around;
    padding: 10px;
  }
}

@media (max-width: 480px) {
  .welcome-text {
    font-size: 1.5em;
  }
  .city-logo {
    height: 80px;
  }
}
</style>