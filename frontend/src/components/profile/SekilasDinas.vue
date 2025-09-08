<template>
  <section class="sekilas-dinas">
    <div class="sekilas-container">
      <div class="sekilas-title-wrapper">
        <h2 class="sekilas-title">
          Sekilas Dinas Komunikasi dan Informatika Kota Madiun
        </h2>
        <div class="sekilas-divider"></div>
      </div>

      <!-- Loading state -->
      <div v-if="loading" class="sekilas-content-grid">
        <div class="sekilas-image-column">
          <div class="sekilas-image-placeholder animate-pulse">
            <div class="w-full h-full bg-gray-300 rounded-lg"></div>
          </div>
        </div>
        <div class="sekilas-text-column">
          <div class="animate-pulse space-y-4">
            <div class="h-4 bg-gray-300 rounded w-full"></div>
            <div class="h-4 bg-gray-300 rounded w-5/6"></div>
            <div class="h-4 bg-gray-300 rounded w-4/6"></div>
          </div>
        </div>
      </div>

      <!-- Content -->
      <div v-else class="sekilas-content-grid">
        <div class="sekilas-image-column">
          <div v-if="profilData?.gambar" class="sekilas-image-container">
            <img 
              :src="getImageUrl(profilData.gambar)" 
              :alt="'Foto Madiun'"
              class="sekilas-image"
            />
          </div>
          <div v-else class="sekilas-image-placeholder">
            <span class="sekilas-image-text">Foto Madiun</span>
          </div>
        </div>

        <div class="sekilas-text-column">
          <div v-if="profilData?.konten" v-html="profilData.konten"></div>
          <div v-else>
            <p class="sekilas-paragraph">
              Dinas Komunikasi dan Informatika Kota Madiun adalah instansi pemerintah yang bertanggung jawab
              dalam bidang komunikasi, informatika, persandian, dan statistik. Dinas ini dibentuk berdasarkan
              Peraturan Daerah Kota Madiun Nomor 04 tahun 2008 tentang Organisasi dan Tata Kerja Dinas Daerah
              Kota Madiun.
            </p>

            <p class="sekilas-paragraph">
              Sejak awal berdirinya, Dinas Komunikasi dan Informatika telah mengalami beberapa kali perubahan
              lokasi kantor, dimulai dari Jalan Basuki Rahmad, kemudian pindah ke Jalan Hayam Wuruk,
              selanjutnya ke Jalan Pahlawan, dan saat ini berlokasi di Jalan Perintis Kemerdekaan Nomor 32,
              Kelurahan Kartoharjo, Kecamatan Kartoharjo, Kota Madiun.
            </p>

            <p class="sekilas-paragraph">
              Saat ini, Dinas Komunikasi dan Informatika Kota Madiun memiliki struktur organisasi Type B
              dengan tiga divisi utama: Divisi Pengelolaan Informasi Publik dan Komunikasi, Divisi Pengelolaan
              Teknologi Informasi dan Komunikasi, serta Divisi Pengelolaan Statistik dan Persandian.
            </p>

            <p class="sekilas-paragraph">
              Dinas ini berperan penting dalam mendukung transformasi digital dan peningkatan pelayanan publik
              di Kota Madiun melalui pengembangan teknologi informasi dan komunikasi yang inovatif dan
              berkelanjutan.
            </p>
          </div>

          <!-- Selengkapnya Button -->
          <div class="sekilas-button-container">
            <router-link to="/profile/tentang" class="sekilas-button">
              Selengkapnya
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { profilService } from '@/service/api.js'

export default {
  name: 'SekilasDinas',
  data() {
    return {
      profilData: null,
      loading: false
    }
  },
  async mounted() {
    await this.fetchProfilData()
  },
  methods: {
    async fetchProfilData() {
      try {
        this.loading = true
        const response = await fetch('http://localhost:8000/api/profile-page/sekilas-dinas')
        const data = await response.json()
        this.profilData = data
      } catch (error) {
        console.error('Error fetching sekilas dinas data:', error)
        this.profilData = null
      } finally {
        this.loading = false
      }
    },
    getImageUrl(imagePath) {
      if (!imagePath) return null
      // If it's already a full URL, return as is
      if (imagePath.startsWith('http')) {
        return imagePath
      }
      // Otherwise, construct the full URL
      return `http://localhost:8000/storage/${imagePath}`
    }
  }
}
</script>

<style scoped>
.sekilas-dinas {
  background-color: #ffffff;
  padding-top: 4rem;
  padding-bottom: 4rem;
}

.sekilas-container {
  max-width: 1280px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 1rem;
  padding-right: 1rem;
}

/* Title */
.sekilas-title-wrapper {
  text-align: center;
  margin-bottom: 3rem;
}

.sekilas-title {
  font-size: 1.875rem;
  line-height: 2.25rem;
  font-weight: 700;
  color: #1e3a8a;
  margin-bottom: 1rem;
}

@media (min-width: 768px) {
  .sekilas-title {
    font-size: 2.25rem;
    line-height: 2.5rem;
  }
}

.sekilas-divider {
  width: 8rem;
  height: 0.25rem;
  background-color: #2563eb;
  margin-left: auto;
  margin-right: auto;
}

/* Content Grid */
.sekilas-content-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 3rem;
  align-items: flex-start;
}

@media (min-width: 1024px) {
  .sekilas-content-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Left Column - Image */
.sekilas-image-column {
  display: flex;
  justify-content: center;
}

.sekilas-image-container {
  width: 100%;
  max-width: 28rem;
  height: 20rem;
  border-radius: 0.5rem;
  overflow: hidden;
}

.sekilas-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.sekilas-image-placeholder {
  width: 100%;
  max-width: 28rem;
  height: 20rem;
  background-color: #d1d5db;
  border-radius: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.sekilas-image-text {
  color: #4b5563;
  font-size: 1.125rem;
  line-height: 1.75rem;
  font-weight: 500;
}

/* Right Column - Text Content */
.sekilas-text-column {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.sekilas-paragraph {
  color: #374151;
  line-height: 1.625;
}

/* Selengkapnya Button */
.sekilas-button-container {
  margin-top: 1rem;
  display: flex;
  justify-content: flex-start;
}

.sekilas-button {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  background-color: #2563eb;
  color: #ffffff;
  text-decoration: none;
  border-radius: 0.375rem;
  font-weight: 500;
  font-size: 0.875rem;
  line-height: 1.25rem;
  transition: background-color 0.2s ease-in-out;
}

.sekilas-button:hover {
  background-color: #1d4ed8;
}
</style>