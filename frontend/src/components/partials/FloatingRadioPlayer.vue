<template>
  <transition name="fade">
    <button
      @click="togglePlay"
      class="floating-radio-btn"
      :class="{ 'is-playing': radioStore.isPlaying }"
      aria-label="Play Radio Suara Madiun"
      title="Radio Suara Madiun"
    >
      <div class="radio-icon">
        <svg v-if="!radioStore.isPlaying" class="play-icon" viewBox="0 0 24 24">
          <path d="M8 5v14l11-7z"/>
        </svg>
        <svg v-else class="pause-icon" viewBox="0 0 24 24">
          <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
        </svg>
      </div>
      <div class="radio-waves" v-if="radioStore.isPlaying">
        <div class="wave wave1"></div>
        <div class="wave wave2"></div>
        <div class="wave wave3"></div>
      </div>
    </button>
  </transition>

  <!-- Hidden audio element -->
  <audio ref="audioElement" :src="radioStore.radioStreamUrl" preload="none"></audio>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useRadioStore } from '../../stores/radioStore';

const radioStore = useRadioStore();
const audioElement = ref(null);

// Initialize audio player when component mounts
onMounted(() => {
  if (audioElement.value) {
    radioStore.setAudioPlayer(audioElement.value);
  }
});

// Cleanup - don't pause on unmount to keep radio playing across pages
onBeforeUnmount(() => {
  // Remove cleanup to keep radio playing
});

const togglePlay = () => {
  radioStore.togglePlay();
};
</script>

<style scoped>
.floating-radio-btn {
  position: fixed;
  bottom: 170px; /* Above accessibility button (100px + 70px spacing) */
  right: 30px;
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #004899, #007bff);
  color: white;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  z-index: 9998; /* Below accessibility button (10000) but above other elements */
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  transition: all 0.3s ease;
  overflow: hidden;
}

.floating-radio-btn:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
}

.floating-radio-btn:active {
  transform: scale(0.95);
}

.radio-icon {
  position: relative;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: center;
}

.play-icon, .pause-icon {
  width: 20px;
  height: 20px;
  fill: white;
  transition: all 0.2s ease;
}

.is-playing .play-icon, .is-playing .pause-icon {
  transform: scale(0.9);
}

/* Radio waves animation */
.radio-waves {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: flex;
  align-items: center;
  justify-content: center;
}

.wave {
  position: absolute;
  border: 2px solid rgba(255, 255, 255, 0.6);
  border-radius: 50%;
  animation: wave 1.5s ease-out infinite;
}

.wave1 {
  width: 20px;
  height: 20px;
  animation-delay: 0s;
}

.wave2 {
  width: 35px;
  height: 35px;
  animation-delay: 0.3s;
}

.wave3 {
  width: 50px;
  height: 50px;
  animation-delay: 0.6s;
}

@keyframes wave {
  0% {
    transform: scale(0.8);
    opacity: 1;
  }
  100% {
    transform: scale(1.4);
    opacity: 0;
  }
}

/* Pulse effect when playing */
.is-playing {
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  }
  50% {
    box-shadow: 0 4px 20px rgba(0, 73, 153, 0.6);
  }
}

/* Fade animation */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: scale(0.8);
}

/* Responsive design */
@media (max-width: 768px) {
  .floating-radio-btn {
    bottom: 160px;
    right: 20px;
    width: 55px;
    height: 55px;
  }

  .wave3 {
    width: 45px;
    height: 45px;
  }
}

@media (max-width: 480px) {
  .floating-radio-btn {
    bottom: 150px;
    right: 15px;
    width: 50px;
    height: 50px;
  }

  .play-icon, .pause-icon {
    width: 18px;
    height: 18px;
  }

  .wave1 {
    width: 18px;
    height: 18px;
  }

  .wave2 {
    width: 30px;
    height: 30px;
  }

  .wave3 {
    width: 40px;
    height: 40px;
  }
}
</style>