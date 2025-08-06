<template>
  <section class="struktur-organisasi-section">
    <div class="so-container">
      <div class="so-title-wrapper">
        <h2 class="so-main-title">
          STRUKTUR ORGANISASI
        </h2>
        <h3 class="so-sub-title">
          DINAS KOMUNIKASI DAN INFORMATIKA KOTA MADIUN
        </h3>
        <div class="so-divider"></div>
      </div>

      <!-- Loading state -->
      <div v-if="loading" class="so-content-grid">
        <div class="so-kepala-dinas-column">
          <div class="so-kepala-dinas-card animate-pulse">
            <div class="so-profile-image-placeholder">
              <div class="w-full h-full bg-gray-300 rounded-full"></div>
            </div>
            <div class="so-name-section">
              <div class="so-city-logo-placeholder">
                <div class="w-full h-full bg-gray-300 rounded-lg"></div>
              </div>
              <div class="h-6 bg-gray-300 rounded w-32"></div>
            </div>
            <div class="so-position-box">
              <div class="h-4 bg-gray-300 rounded w-full mb-2"></div>
              <div class="h-4 bg-gray-300 rounded w-3/4"></div>
            </div>
          </div>
        </div>
        <div class="so-message-column">
          <div class="so-message-card animate-pulse">
            <div class="h-6 bg-gray-300 rounded w-48 mb-4"></div>
            <div class="space-y-3">
              <div class="h-4 bg-gray-300 rounded w-full"></div>
              <div class="h-4 bg-gray-300 rounded w-5/6"></div>
              <div class="h-4 bg-gray-300 rounded w-4/6"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content -->
      <div v-else class="so-content-grid">
        <div class="so-kepala-dinas-column">
          <div class="so-kepala-dinas-card">
            <div v-if="profilData?.gambar" class="so-profile-image-container">
              <img 
                :src="getImageUrl(profilData.gambar)" 
                :alt="'Foto Kepala Dinas'"
                class="so-profile-image"
              />
            </div>
            <div v-else class="so-profile-image-placeholder">
              <span class="so-image-text">Foto Kepala Dinas</span>
            </div>
            
            <div class="so-name-section">
              <div class="so-city-logo-placeholder">
                <span class="so-city-logo-text">KOTA MADIUN</span>
              </div>
              <h4 class="so-kepala-dinas-name">Noor Aflah, S.Kom.</h4>
            </div>
            
            <div class="so-position-box">
              <p class="so-position-text">KEPALA DINAS KOMUNIKASI</p>
              <p class="so-position-text">DAN INFORMATIKA</p>
            </div>
          </div>
        </div>

        <div class="so-message-column">
          <div class="so-message-card">
            <h4 class="so-message-title">Struktur Organisasi</h4>
            <div v-if="profilData?.konten" v-html="profilData.konten"></div>
            <div v-else>
              <p class="so-message-paragraph">
                Assalamualaikum warahmatullahi Wabarakatuh. Salam Sejahtera untuk kita semua.
              </p>
              <p class="so-message-paragraph">
                Sebagai Kepala Dinas Komunikasi dan Informatika Kota Madiun, saya mengucapkan 
                terima kasih atas kepercayaan yang diberikan untuk memimpin dinas yang memiliki 
                peran strategis dalam mendukung transformasi digital dan peningkatan pelayanan 
                publik di Kota Madiun.
              </p>
              <p class="so-message-paragraph">
                Dinas Komunikasi dan Informatika berkomitmen untuk terus mengembangkan 
                teknologi informasi dan komunikasi yang inovatif, handal, dan berkelanjutan 
                dalam mendukung visi Kota Madiun yang Maju, Mandiri, dan Berdaya Saing.
              </p>
              <p class="so-message-paragraph">
                Kami siap melayani masyarakat dengan sebaik-baiknya dan terus berinovasi 
                dalam memberikan solusi teknologi yang tepat guna untuk kemajuan Kota Madiun.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="so-button-wrapper">
        <button class="so-more-button">
          Selengkapnya Tentang Struktur Organisasi
        </button>
      </div>
    </div>
  </section>
</template>

<script>
import { profilService } from '@/service/api.js'

export default {
  name: 'StrukturOrganisasi',
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
        const response = await profilService.getProfilByCategory('struktur-organisasi')
        this.profilData = response.data
      } catch (error) {
        console.error('Error fetching struktur organisasi data:', error)
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
.struktur-organisasi-section {
  background-color: #ffffff;
  padding-top: 4rem;
  padding-bottom: 4rem;
}

.so-container {
  max-width: 1280px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 1rem;
  padding-right: 1rem;
}

/* Title */
.so-title-wrapper {
  text-align: center;
  margin-bottom: 3rem;
}

.so-main-title {
  font-size: 1.875rem;
  line-height: 2.25rem;
  font-weight: 700;
  color: #1e3a8a;
  margin-bottom: 1rem;
  text-transform: uppercase;
}

@media (min-width: 768px) {
  .so-main-title {
    font-size: 2.25rem;
    line-height: 2.5rem;
  }
}

.so-sub-title {
  font-size: 1.5rem;
  line-height: 2rem;
  font-weight: 600;
  color: #1e40af;
  margin-bottom: 1rem;
  text-transform: uppercase;
}

@media (min-width: 768px) {
  .so-sub-title {
    font-size: 1.875rem;
    line-height: 2.25rem;
  }
}

.so-divider {
  width: 8rem;
  height: 0.25rem;
  background-color: #2563eb;
  margin-left: auto;
  margin-right: auto;
}

/* Content Grid */
.so-content-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 3rem;
  align-items: flex-start;
}

@media (min-width: 1024px) {
  .so-content-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Left Column - Head of Department */
.so-kepala-dinas-column {
  text-align: center;
}

.so-kepala-dinas-card {
  background-color: #ffffff;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
  padding: 2rem;
  max-width: 28rem;
  margin-left: auto;
  margin-right: auto;
}

/* Profile Image */
.so-profile-image-container {
  width: 12rem;
  height: 12rem;
  border-radius: 9999px;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 1.5rem;
  overflow: hidden;
}

.so-profile-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.so-profile-image-placeholder {
  width: 12rem;
  height: 12rem;
  background-color: #d1d5db;
  border-radius: 9999px;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.so-image-text {
  color: #4b5563;
  font-size: 1.125rem;
  line-height: 1.75rem;
  font-weight: 500;
}

/* Logo and Name Section */
.so-name-section {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.5rem;
}

.so-city-logo-placeholder {
  width: 3rem;
  height: 3rem;
  background-color: #22c55e;
  border-radius: 0.5rem;
  margin-right: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.so-city-logo-text {
  color: #ffffff;
  font-size: 0.75rem;
  line-height: 1rem;
  font-weight: 700;
  text-align: center;
}

.so-kepala-dinas-name {
  font-size: 1.25rem;
  line-height: 1.75rem;
  font-weight: 700;
  color: #1e3a8a;
}

/* Position Box */
.so-position-box {
  background-color: #16a34a;
  color: #ffffff;
  padding-top: 0.75rem;
  padding-bottom: 0.75rem;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  border-radius: 0.5rem;
}

.so-position-text {
  font-weight: 600;
  text-transform: uppercase;
}

/* Right Column - Message */
.so-message-column {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.so-message-card {
  background-color: #ffffff;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
  padding: 2rem;
}

.so-message-title {
  font-size: 1.25rem;
  line-height: 1.75rem;
  font-weight: 700;
  color: #1e3a8a;
  margin-bottom: 1rem;
}

.so-message-paragraph {
  color: #374151;
  line-height: 1.625;
  margin-bottom: 1rem;
}

.so-message-paragraph:last-child {
  margin-bottom: 0;
}

/* Button */
.so-button-wrapper {
  text-align: center;
  margin-top: 3rem;
}

.so-more-button {
  background-image: linear-gradient(to right, #16a34a, #2563eb);
  color: #ffffff;
  padding-left: 2rem;
  padding-right: 2rem;
  padding-top: 1rem;
  padding-bottom: 1rem;
  border-radius: 0.5rem;
  font-weight: 600;
  border: none;
  cursor: pointer;
  display: inline-block;
  transition: all 0.3s ease;
}

.so-more-button:hover {
  background-image: linear-gradient(to right, #15803d, #1d4ed8);
  transform: scale(1.05);
}
</style>