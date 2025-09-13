<template>
  <section class="services-section">
    <div class="container">
      <h2 class="section-title">Layanan Unggulan</h2>
      <div class="services-grid">
        <div
          v-for="(service, index) in serviceItems"
          :key="index"
          class="service-card"
          :class="{ 'is-visible': service.isVisible }"
          :style="{ 'transition-delay': service.delay }"
        >
          <div class="icon-placeholder">
            <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
              <path :fill-rule="service.iconPath.fillRule" :d="service.iconPath.d" :clip-rule="service.iconPath.clipRule" />
              <path v-if="service.iconPath2" :fill-rule="service.iconPath2.fillRule" :d="service.iconPath2.d" :clip-rule="service.iconPath2.clipRule" />
            </svg>
          </div>
          <p class="service-title">{{ service.title }}</p>
          <a :href="service.link" target="_blank" class="service-button">Akses Layanan</a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

// Data dummy untuk item layanan
const serviceItems = ref([
  {
    iconPath: {
      fillRule: 'evenodd',
      d: 'M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z',
      clipRule: 'evenodd',
    },
    title: 'PPID',
    link: 'https://ppid.madiunkota.go.id/',
    isVisible: false,
    delay: '0s',
  },
  {
    iconPath: {
      d: 'M5.5 10a.5.5 0 01.5-.5h4.5a.5.5 0 010 1H6a.5.5 0 01-.5-.5zm.5 2.5a.5.5 0 000 1h4.5a.5.5 0 000-1H6z',
    },
    iconPath2: { // Untuk icon yang punya 2 path
      fillRule: 'evenodd',
      d: 'M2 10a8 8 0 1116 0A8 8 0 012 10zm8-7a7 7 0 100 14A7 7 0 0010 3z',
      clipRule: 'evenodd',
    },
    title: 'Ajuan Masyarakat',
    link: 'https://awaksigap.madiunkota.go.id/',
    isVisible: false,
    delay: '0.30s',
  },
  {
    iconPath: {
      d: 'M10 12a2 2 0 100-4 2 2 0 000 4z',
    },
    iconPath2: { // Untuk icon yang punya 2 path
      fillRule: 'evenodd',
      d: '.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z',
      clipRule: 'evenodd',
    },
    title: 'Data Statistik',
    link: 'https://madiunkota.bps.go.id/id',
    isVisible: false,
    delay: '0.60s',
  },
  // Tambahkan item layanan lainnya jika diperlukan
]);

let observers = [];

onMounted(() => {
  const cards = document.querySelectorAll('.service-card');

  cards.forEach((card, index) => {
    // Hitung penundaan berdasarkan indeks untuk penampilan berurutan
    serviceItems.value[`${index}`].delay = `${index * 0.30}s`;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            // Kartu masuk ke dalam viewport
            serviceItems.value[`${index}`].isVisible = true;
          } else {
            // Kartu keluar dari viewport
            serviceItems.value[`${index}`].isVisible = false;
          }
        });
      },
      {
        root: null, // relatif terhadap viewport
        rootMargin: '0px',
        threshold: [0, 0.9], // Ubah threshold menjadi array
      }
    );
    observer.observe(card);
    observers.push(observer);
  });
});

onBeforeUnmount(() => {
  // Putuskan semua observer saat komponen dilepas
  observers.forEach((observer) => observer.disconnect());
});
</script>

<style scoped>
/* Gaya yang sudah ada tetap sama */
.services-section {
  background-color: #f3f4f5;
  padding: 80px 16px;
  position: relative;
  z-index: 0; /* Kembali ke z-index normal */
  box-sizing: border-box;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.section-title {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 48px;
  text-align: center;
}

.services-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
  justify-content: center;
}

@media (min-width: 640px) {
  .services-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 768px) {
  .services-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.service-card {
  background-color: #ffffff;
  padding: 24px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  text-align: center;
  transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.3s ease,
    transform 0.3s ease; /* Persingkat durasi transisi untuk efek lebih cepat */
  display: flex;
  flex-direction: column;
  align-items: center;

  /* Kondisi awal untuk animasi */
  opacity: 0;
  transform: translateY(50px); /* Mulai dari bawah */
}

.service-card.is-visible {
  opacity: 1;
  transform: translateY(0); /* Pindah ke posisi aslinya */
}

.service-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.icon-placeholder {
  background-color: #007bff;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.icon {
  width: 40px;
  height: 40px;
}

.service-title {
  font-size: 18px;
  font-weight: 600;
  color: #444;
}

.service-button {
  display: inline-block;
  margin-top: 16px;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.2s ease;
  font-weight: 500;
}

.service-button:hover {
  background-color: #0056b3;
}

@media (max-width: 768px) {
  .services-section {
    padding: 60px 16px;
  }
  .section-title {
    font-size: 24px;
    margin-bottom: 30px;
  }
}

@media (max-width: 480px) {
  .services-section {
    padding: 40px 16px;
  }
  .section-title {
    font-size: 20px;
  }
}
</style>