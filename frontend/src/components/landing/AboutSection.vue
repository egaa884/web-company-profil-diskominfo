<template>
  <section class="about-section" ref="aboutSection">
    <div class="container">
      <h2
        class="section-title"
        :class="[
          isInView ? 'title-in' : scrollingDown ? 'title-out-left' : 'title-out-right'
        ]"
      >
        Sekilas Tentang Kami
      </h2>
      <br> 
      <div class="content">
        <div
          class="text-column"
          :class="[
            isInView ? 'text-in' : scrollingDown ? 'text-out-left' : 'text-out-left'
          ]"
        >
          <!-- Loading state -->
          <div v-if="loading" class="animate-pulse">
            <div class="h-4 bg-gray-300 rounded mb-3"></div>
            <div class="h-4 bg-gray-300 rounded mb-3 w-5/6"></div>
            <div class="h-4 bg-gray-300 rounded mb-3 w-4/6"></div>
            <div class="h-4 bg-gray-300 rounded w-3/6"></div>
          </div>
          
          <!-- Content from API -->
          <div v-else-if="aboutData?.konten" v-html="aboutData.konten"></div>
          
          <!-- Fallback content -->
          <p v-else class="text-paragraph">
            Penjabaran tugas pokok dan fungsi Dinas Komunikasi dan Informatika Kota Madiun berpedoman pada Peraturan Wali Kota Madiun Nomor 69 Tahun 2020 tentang Kedudukan, Susunan Organisasi, Tugas, Fungsi dan Tata Kerja Dinas Komunikasi dan Informatika. Dinas Kominfo merupakan dinas tipe B dengan unsur pelaksana yang terdiri dari tiga bidang. Yakni, Bidang Pengelolaan Informasi dan Komunikasi Publik, Bidang Pengelolaan Teknologi Informasi dan Komunikasi, serta Bidang Pengelolaan Statistik dan Persandian.
          </p>
        </div>
        <div
          class="media-column"
          :class="[
            isInView ? 'media-in' : scrollingDown ? 'media-out-right' : 'media-out-right'
          ]"
        >
          <div class="image-wrapper">
            <img 
              v-if="aboutData?.gambar" 
              :src="getImageUrl(aboutData.gambar)" 
              alt="Gambar Sekilas Tentang Kami" 
              class="image-pahlawan"
            />
            <img 
              v-else 
              :src="pahlawanStreetCenterImage" 
              alt="Pahlawan Street Center Madiun" 
              class="image-pahlawan"
            />
            <img :src="diskominfoLogoImage" alt="Logo Diskominfo" class="image-diskominfo">
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { profilService } from '@/service/api.js'

// Mengimpor gambar dari lokasi assets Anda.
import pahlawanStreetCenterImage from '@/assets/img/pendekar.jpg'
import diskominfoLogoImage from '@/assets/img/logo-madiun-pesilat.png'

const isInView = ref(false)
const scrollingDown = ref(true)
const aboutSection = ref(null)
const aboutData = ref(null)
const loading = ref(false)
let lastScrollY = window.scrollY

// Fetch about data from API
const fetchAboutData = async () => {
  try {
    loading.value = true
    const response = await profilService.getProfilByCategory('sekilas-dinas')
    aboutData.value = response.data
  } catch (error) {
    console.error('Error fetching about data:', error)
    aboutData.value = null
  } finally {
    loading.value = false
  }
}

// Get image URL
const getImageUrl = (imagePath) => {
  if (!imagePath) return null
  // If it's already a full URL, return as is
  if (imagePath.startsWith('http')) {
    return imagePath
  }
  // Otherwise, construct the full URL
  return `http://localhost:8000/storage/${imagePath}`
}

// Fungsi untuk menangani event scroll
const handleScroll = () => {
  const currentScrollY = window.scrollY
  scrollingDown.value = currentScrollY > lastScrollY
  lastScrollY = currentScrollY
}

// Membuat IntersectionObserver untuk mendeteksi apakah elemen masuk ke dalam viewport
const observer = new IntersectionObserver(
  ([entry]) => {
    isInView.value = entry.isIntersecting
  },
  { threshold: 0.3 }
)

// Lifecycle hook: Saat komponen dipasang ke DOM
onMounted(() => {
  fetchAboutData()
  window.addEventListener('scroll', handleScroll)
  if (aboutSection.value) {
    observer.observe(aboutSection.value)
  }
})

// Lifecycle hook: Saat komponen dilepas dari DOM
onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
  if (aboutSection.value) {
    observer.unobserve(aboutSection.value)
  }
})
</script>

<style scoped>
/* Bagian "Sekilas Tentang Kami" */
.about-section {
  background-color: #f3f4f5;
  padding-top: 80px;
  padding-left: 16px;
  padding-right: 16px;
  padding-bottom: 80px;
  overflow: hidden;
  position: relative;
  z-index: 0;
  box-sizing: border-box;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

/* Judul Bagian */
.section-title {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 32px;
  text-align: center;
  transform: translateX(100%);
  opacity: 0;
  transition: transform 1s ease, opacity 1s ease;
}

/* Animasi Judul: Saat masuk viewport */
.title-in {
  transform: translateX(0);
  opacity: 1;
}

/* Animasi Judul: Saat keluar viewport dan scroll ke bawah */
.title-out-left{
  transform: translateX(100%);
  opacity: 0;
}

/* Animasi Judul: Saat keluar viewport dan scroll ke atas */
.title-out-right {
  transform: translateX(100%);
  opacity: 0;
}

/* Konten utama (kolom teks dan kolom media) */
.content {
  display: flex;
  flex-direction: column;
  gap: 48px;
}

/* Media Query: Untuk layar lebih besar dari 768px */
@media (min-width: 768px) {
  .content {
    flex-direction: row;
  }
}

/* Gaya dasar untuk kolom teks dan kolom media */
.text-column,
.media-column {
  flex: 1;
  transition: transform 1s ease, opacity 1s ease, scale 1s ease;
  opacity: 0;
  scale: 0.9;
}

/* Paragraf teks */
.text-paragraph {
  color: #666;
  line-height: 1.8;
}

/* ANIMASI TEKS */
/* Animasi Teks: Saat masuk viewport */
.text-in {
  transform: translateX(0);
  opacity: 1;
  scale: 1;
}
/* Animasi Teks: Saat keluar viewport dan scroll ke bawah */
.text-out-left {
  transform: translateX(-100%);
  opacity: 0;
  scale: 0.9;
}
/* Animasi Teks: Saat keluar viewport dan scroll ke atas */
.text-out-right {
  transform: translateX(100%);
  opacity: 0;
  scale: 0.9;
}

/* KOLOM MEDIA (GAMBAR/VIDEO) */
.media-column {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 300px;
  box-sizing: border-box;
}

.image-wrapper {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.image-pahlawan {
  max-width: 80%;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  transform: rotate(-5deg);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
}

.image-diskominfo {
  max-width: 40%;
  height: auto;
  position: absolute;
  bottom: 10%;
  right: 10%;
  z-index: 2;
  background-color: #fff;
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* ANIMASI MEDIA */
/* Animasi Media: Saat masuk viewport */
.media-in {
  transform: translateX(0);
  opacity: 1;
  scale: 1;
}
/* Animasi Media: Saat keluar viewport dan scroll ke bawah */
.media-out-left {
  transform: translateX(-100%);
  opacity: 0;
  scale: 0.9;
}
/* Animasi Media: Saat keluar viewport dan scroll ke atas */
.media-out-right {
  transform: translateX(100%);
  opacity: 0;
  scale: 0.9;
}

/* Loading animation */
.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: .5;
  }
}

/* Media Query untuk Responsivitas */
@media (max-width: 768px) {
  .about-section {
    padding-top: 40px;
    padding-left: 16px;
    padding-right: 16px;
    padding-bottom: 40px;
  }

  .section-title {
    font-size: 24px;
    margin-bottom: 24px;
  }

  .content {
    gap: 32px;
  }

  .text-paragraph {
    font-size: 0.9em;
  }

  .image-pahlawan {
    max-width: 90%;
    top: 5%;
    left: 5%;
    transform: rotate(-3deg);
  }

  .image-diskominfo {
    max-width: 30%;
    bottom: 5%;
    right: 5%;
  }

  .media-column {
    min-height: 250px;
  }
}

@media (max-width: 480px) {
  .about-section {
    padding-top: 20px;
  }
  .section-title {
    font-size: 20px;
  }
  .media-column {
    min-height: 200px;
  }
  .image-pahlawan {
    max-width: 100%;
    transform: rotate(0deg);
    position: relative;
    top: auto;
    left: auto;
  }
  .image-diskominfo {
    max-width: 35%;
    position: relative;
    bottom: auto;
    right: auto;
    margin-top: 15px;
  }
  .image-wrapper {
    flex-direction: column;
    gap: 15px;
  }
}
</style>