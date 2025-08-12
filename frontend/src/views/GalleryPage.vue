<template>
  <div class="gallery-page">
    <h1 class="gallery-title">Galeri</h1>
    
    <div class="bento-grid">
      <LargeImage
        v-if="mainImage"
        :key="mainImage.id"
        :image="mainImage"
      />

      <SmallImageGrid :images="smallImages" @select-small-image="setMainImage" />

      <div class="navigation-buttons">
        <button @click="previousImage" :disabled="currentIndex === 0">
          Previous
        </button>
        <button @click="nextImage" :disabled="currentIndex === galleryData.length - smallImageCount">
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import LargeImage from '../components/Galeri/LargeImage.vue';
import SmallImageGrid from '../components/Galeri/SmallImageGrid.vue';

// Impor gambar dari folder assets
import image1 from '@/assets/img/1.jpeg';
import image2 from '@/assets/img/2.jpeg';
import image3 from '@/assets/img/3.jpg';
import image4 from '@/assets/img/4.jpg';
import image5 from '@/assets/img/5.jpg';
import image6 from '@/assets/img/6.jpg'; // Contoh gambar tambahan


export default {
  name: 'GalleryPage',
  components: {
    LargeImage,
    SmallImageGrid,
  },
  data() {
    return {
      galleryData: [
        { id: 1, url: image1, alt: 'Gambar 1', title: 'Judul Gambar 1', description: 'Deskripsi singkat Gambar 1' },
        { id: 2, url: image2, alt: 'Gambar 2', title: 'Judul Gambar 2' },
        { id: 3, url: image3, alt: 'Gambar 3', title: 'Judul Gambar 3' },
        { id: 4, url: image4, alt: 'Gambar 4', title: 'Judul Gambar 4' },
        { id: 5, url: image5, alt: 'Gambar 5', title: 'Judul Gambar 5' },
        { id: 6, url: image6, alt: 'Gambar 6', title: 'Judul Gambar 6' },
        { id: 7, url: image7, alt: 'Gambar 7', title: 'Judul Gambar 7' },
        { id: 8, url: image8, alt: 'Gambar 8', title: 'Judul Gambar 8' },
        { id: 9, url: image9, alt: 'Gambar 9', title: 'Judul Gambar 9' },
      ],
      currentIndex: 0,
      smallImageCount: 4,
    };
  },
  computed: {
    mainImage() {
      // Mengambil gambar utama berdasarkan currentIndex
      return this.galleryData[this.currentIndex];
    },
    smallImages() {
      // Mengambil 4 gambar selanjutnya untuk grid gambar kecil
      const start = this.currentIndex + 1;
      const end = start + this.smallImageCount;
      return this.galleryData.slice(start, end);
    },
  },
  methods: {
    setMainImage(imageId) {
      // Menemukan indeks gambar yang diklik dan menjadikannya gambar utama
      const selectedIndex = this.galleryData.findIndex(img => img.id === imageId);
      if (selectedIndex !== -1) {
        this.currentIndex = selectedIndex;
      }
    },
    nextImage() {
      // Memindahkan ke set gambar berikutnya
      if (this.currentIndex + this.smallImageCount < this.galleryData.length) {
        this.currentIndex++;
      }
    },
    previousImage() {
      // Memindahkan ke set gambar sebelumnya
      if (this.currentIndex > 0) {
        this.currentIndex--;
      }
    },
  },
};
</script>

<style scoped>
.gallery-page {
  font-family: sans-serif;
  padding: 2rem;
  background-color: #f0f4f8;
  min-height: 100vh;
}

.gallery-title {
  text-align: center;
  font-size: 2.5rem;
  font-weight: 900;
  color: #1e3a8a;
  margin-bottom: 2rem;
}

.bento-grid {
  display: grid;
  gap: 1rem;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(2, 250px);
}

.navigation-buttons {
  grid-column: 1 / -1;
  text-align: center;
  margin-top: 1rem;
}
.navigation-buttons button {
  padding: 0.5rem 1rem;
  margin: 0 0.5rem;
  border: 1px solid #ccc;
  cursor: pointer;
}
.navigation-buttons button:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

/* Transisi untuk gambar utama */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: opacity 0.5s, transform 0.5s;
}

.slide-fade-enter-from {
  opacity: 0;
  transform: translateX(20px);
}

.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}
</style>