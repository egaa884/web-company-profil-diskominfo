<template>
  <div class="hero-section">
    <div class="hero-main-gradient-overlay"></div>
    <div class="hero-logo-background"></div>
    <div class="welcome-text-wrapper">
        <h1 class="welcome-text">
          <span v-for="(char, index) in welcomeText" :key="'welcome-' + index" class="char">{{ char === ' ' ? '&nbsp;' : char }}</span>
        </h1>
        <h1 class="welcome-text">
          <span v-for="(char, index) in secondLineText" :key="'second-' + index" class="char">{{ char === ' ' ? '&nbsp;' : char }}</span>
        </h1>
        <h1 class="welcome-text">
          <span v-for="(char, index) in thirdLineText" :key="'third-' + index" class="char">{{ char === ' ' ? '&nbsp;' : char }}</span>
        </h1>
      </div>
    
    <div class="hero-decorative-elements">
      <div class="decorative-circle-1"></div>
      <div class="decorative-circle-2"></div>
    </div>
    
    <div class="hero-content-wrapper">
      <div class="hero-text-container">
      
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const welcomeText = ref('SELAMAT DATANG DI');
const secondLineText = ref('WEBSITE DISKOMINFO');
const thirdLineText = ref('KOTA MADIUN');
</script>
<style scoped>
/* Container utama */
.hero-section {
  position: relative;
  min-height: 500px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 5rem 1rem;
  overflow: hidden;
  height: 100vh;
}


.welcome-text-wrapper {
  background-color: transparent;
  padding: 50%;
  pointer-events: auto; /* Ini kunci agar hover event bisa diterima */
  z-index: 3; /* Pastikan kontainer teks di atas semua overlay */
  text-align: center;
}

.welcome-text {
  color: white;
  font-size: 3em;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
  margin: 0;
  
  gap: 0.2em;
  line-height: 1.2;
}

/* Latar Belakang Gradasi Utama */
.hero-main-gradient-overlay {
  position:absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom, #01458E 0%, #FFFFFF 100%);
  z-index: 0;
}

/* Gambar Logo Kominfo */
.hero-logo-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('../../assets/img/logo-kominfo.png');
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
  opacity: 0.3;
  z-index: 1;
}

/* Background Decorative Elements (lingkaran) */
.hero-decorative-elements {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  z-index: 2;
  pointer-events: none;
}

.decorative-circle-1 {
  position: absolute;
  top: -5rem;
  right: -5rem;
  width: 24rem;
  height: 24rem;
  background-color: rgba(147, 197, 253, 0.2);
  border-radius: 9999px;
  animation: dynamic-bounce-1 12s infinite ease-in-out; /* Durasi lebih panjang untuk pergerakan halus */
}

.decorative-circle-2 {
  position: absolute;
  bottom: 0rem;
  left: -5rem;
  width: 20rem;
  height: 20rem;
  background-color: rgba(96, 165, 250, 0.15);
  border-radius: 9999px;
  animation: dynamic-bounce-2 10s infinite ease-in-out; /* Durasi lebih panjang untuk pergerakan halus */
}

/* Keyframes untuk animasi lingkaran yang lebih dinamis */
@keyframes dynamic-bounce-1 {
  0% {
    transform: translate(0, 0) scale(1) rotate(0deg);
  }
  25% {
    transform: translate(-50px, 80px) scale(1.1) rotate(15deg);
  }
  50% {
    transform: translate(-100px, 0) scale(1) rotate(0deg);
  }
  75% {
    transform: translate(-50px, -80px) scale(0.9) rotate(-15deg);
  }
  100% {
    transform: translate(0, 0) scale(1) rotate(0deg);
  }
}

@keyframes dynamic-bounce-2 {
  0% {
    transform: translate(0, 0) scale(1) rotate(0deg);
  }
  25% {
    transform: translate(80px, -50px) scale(0.9) rotate(-15deg);
  }
  50% {
    transform: translate(0, -100px) scale(1.1) rotate(0deg);
  }
  75% {
    transform: translate(-80px, -50px) scale(1) rotate(15deg);
  }
  100% {
    transform: translate(0, 0) scale(1) rotate(0deg);
  }
}

/* Wrapper Konten Teks */
.hero-content-wrapper {
  position: relative;
  z-index: 10;
  width: 100%;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 1rem;
  padding-right: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Teks lama sudah dihapus */
.hero-text-container {
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>