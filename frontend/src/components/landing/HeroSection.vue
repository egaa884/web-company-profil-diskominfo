<template>
  <div class="hero-container">
    <video
      ref="videoPlayer"
      class="hero-video"
      autoplay
      muted
      loop
      playsinline
      poster="@/assets/img/ppid.jpg"
    >
      <source src="@/assets/video/video-drone-madiun.mp4" type="video/mp4" />
      Browser Anda tidak mendukung tag video.
    </video>

    <div class="video-overlay"></div>

    <div class="overlay-content">
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
      <div class="logo-wrapper">
        <img
          src="@/assets/img/logo-madiun-pesilat.png"
          alt="Logo Kota Madiun"
          class="city-logo"
        />
      </div>
    </div>

    <div class="wave-shape">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 1440 320"
      >
        <path
          fill="#f3f4f5"
          fill-opacity="1"
          d="M0,288L80,282.7C160,277,320,267,480,272C640,277,800,299,960,304C1120,309,1280,299,1360,293.3L1440,288L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"
        ></path>
      </svg>
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
.hero-container {
  position: relative;
  width: 100%;
  height: 700px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: black;
  z-index: 0;
}

.hero-video {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 0;
}

.video-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
  z-index: 1;
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
  z-index: 2; /* z-index ini penting */
}

.welcome-text-wrapper {
  background-color: transparent;
  padding: 15px 30px;
  pointer-events: auto; /* Ini kunci agar hover event bisa diterima */
  z-index: 3; /* Pastikan kontainer teks di atas semua overlay */
}

.welcome-text {
  color: white;
  font-size: 3em;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
  margin: 0;
  display: flex;
  gap: 0.2em;
  line-height: 1.2;
}

.char {
  display: inline-block;
  cursor: pointer;
  transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  position: relative;
  -webkit-text-stroke: 2px rgb(255, 255, 255); 
  text-shadow: none;
  color: transparent;
  letter-spacing: -0.05em;
}

.char:hover {
  transform: scale(1.5);
  color: white;
  -webkit-text-stroke: 1px transparent;
  text-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.logo-wrapper {
  background-color: transparent;
  pointer-events: auto;
  z-index: 3; /* Tambahkan z-index juga untuk logo */
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
  z-index: 4;
}

.wave-shape svg {
  display: block;
  width: 100%;
  height: auto;
}

@media (max-width: 768px) {
  .hero-container {
    height: 400px;
  }
  .welcome-text {
    font-size: 2em;
    flex-direction: column;
    gap: 0;
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