<template>
  <div class="container">
    <h1>Siaran Pers</h1>
    <!-- Loading state -->
    <div v-if="loading" class="loading-container">
      <p>Loading siaran pers...</p>
    </div>
    <!-- Error state -->
    <div v-else-if="error" class="error-container">
      <p>{{ error }}</p>
      <button @click="fetchSiaranPers" class="retry-btn">Coba Lagi</button>
    </div>
    <!-- Content -->
    <div v-else class="card-page">
      <div v-if="cards.length === 0" class="no-data">
        <p>Tidak ada siaran pers yang tersedia saat ini.</p>
      </div>
      <div v-else class="card-container">
        <CardItem
          v-for="card in cards"
          :key="card.id"
          :cardData="card"
        />
      </div>
    </div>
  </div>
</template>

<script>
import CardItem from '../components/siaranpers/CardItem.vue';
import { beritaService } from '../service/api.js';

export default {
  name: 'SiaranPers',
  components: {
    CardItem,
  },
  data() {
    return {
      cards: [],
      loading: true,
      error: null,
    };
  },
  mounted() {
    this.fetchSiaranPers();
  },
  methods: {
    async fetchSiaranPers() {
      try {
        this.loading = true;
        this.error = null;

        // Fetch berita with category "Siaran Pers Madiun"
        const response = await beritaService.getBeritaByCategory('Siaran Pers Madiun');

        // Transform API data to match CardItem component format
        this.cards = response.data.data.map(berita => ({
          id: berita.id,
          title: berita.judul,
          description: this.truncateText(berita.konten, 150), // Truncate content for card display
          imageUrl: berita.gambar_url || '/img/default-news.jpg', // Fallback image if no image
          pdfUrl: berita.pdf_url || null, // PDF URL if available
          images: berita.images || [], // Multiple images array
        }));

      } catch (error) {
        console.error('Error fetching siaran pers:', error);
        this.error = 'Gagal memuat data siaran pers. Silakan coba lagi.';
      } finally {
        this.loading = false;
      }
    },
    truncateText(text, maxLength) {
      if (!text) return '';
      if (text.length <= maxLength) return text;
      return text.substring(0, maxLength) + '...';
    }
  },
};
</script>

<style scoped>
.card-page {
    margin-top: 5%;
  font-family: 'RobotoDraft', 'Roboto', sans-serif;
  background-color: #f2f2f2;
  padding: 2rem;
}

.card-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  justify-items: center;
}
</style>