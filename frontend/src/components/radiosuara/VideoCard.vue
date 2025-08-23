<template>
  <div>
    <div class="video-card">
      <video
        :src="videoSource"
        class="video-preview"
        autoplay
        loop
        muted
        playsinline
      ></video>
    </div>

    <div class="card-details">
      <p class="card-title">{{ title }}</p>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  videoSource: String,
  title: String,
});
</script>

<style scoped>
.video-card {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  aspect-ratio: 3 / 4;
  /* Tambahkan transisi untuk animasi yang halus */
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.video-card:hover {
  /* Efek mengangkat kartu ke atas saat hover */
  transform: translateY(-5px);
  /* Efek bayangan yang lebih kuat saat hover */
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
  cursor: pointer; /* Mengubah kursor menjadi pointer untuk indikasi interaktif */
}

.video-preview {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.card-details {
  padding: 15px;
  text-align: center;
}

.card-title {
  font-size: 0.9rem;
  font-weight: 300;
  color: #c0e3ff;
}
</style>