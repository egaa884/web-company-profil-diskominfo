<template>
  <div class="radio-player-container">
    <div class="player-controls">
      <a href="https://onlineradiobox.com/id/suaramadiun/" target="_blank" class="radio-logo-link">
        <img src="../../assets/img/logo-suara-madiun.png" alt="Logo Radio" class="radio-logo" />
      </a>
      <button @click="togglePlay" class="play-button" :class="{ 'is-playing': radioStore.isPlaying }">
        <svg v-if="!radioStore.isPlaying" class="icon" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
        <svg v-else class="icon" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" /></svg>
      </button>
      <div class="volume-control">
        <svg class="icon volume-icon" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9z" /></svg>
        <input type="range" min="0" max="100" v-model="radioStore.volume" @input="handleVolumeChange" class="volume-slider" />
      </div>
    </div>
    <!-- Audio element is managed by FloatingRadioPlayer -->
  </div>
</template>

<script setup>
import { watch } from 'vue';
import { useRadioStore } from '../../stores/radioStore';

const radioStore = useRadioStore();

const togglePlay = () => {
  radioStore.togglePlay();
};

const handleVolumeChange = (event) => {
  radioStore.setVolume(parseInt(event.target.value));
};


watch(() => radioStore.volume, (newVolume) => {
  if (radioStore.audioPlayer) {
    radioStore.audioPlayer.volume = newVolume / 100;
  }
});
</script>

<style scoped>
.radio-player-container {
  background-color: white;
  padding: 15px 40px; 
  border-radius: 20px; 
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  display: flex;
  align-items: center;
  gap: 20px;
}
.player-controls {
  display: flex;
  align-items: center;
  gap: 15px;
}
.radio-logo-link { 
  display: block; 
  line-height: 0; 
}
.radio-logo {
  width: 50px;
  height: 50px;
}
.play-button {
  background: none;
  border: none;
  color: #004899;
  cursor: pointer;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
  transition: all 0.2s ease-in-out;
}
.play-button:active {
  transform: translateY(2px);
  box-shadow: none;
}
.icon {
  fill: #004899;
  width: 24px;
  height: 24px;
}
.volume-control {
  display: flex;
  align-items: center;
  gap: 10px;
}
.volume-slider {
  -webkit-appearance: none;
  appearance: none;
  width: 200px;
  height: 8px;
  background: #e0e0e0;
  border-radius: 10px;
  outline: none;
  &::-webkit-slider-runnable-track {
    width: 100%;
    height: 8px;
    background: #e0e0e0;
    border-radius: 10px;
  }
  &::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #004899;
    cursor: pointer;
    margin-top: -6px;
  }
  &::-moz-range-track {
    width: 100%;
    height: 8px;
    background: #e0e0e0;
    border-radius: 10px;
  }
  &::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #004899;
    cursor: pointer;
  }
}
</style>