<template>
  <section class="standar-pelayanan py-16">
    <div class="container mx-auto px-4">
      <!-- Title -->
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
          Standar Pelayanan Dinas Komunikasi dan Informatika Kota Madiun
        </h2>
        <div class="w-32 h-1 bg-blue-600 mx-auto"></div>
      </div>

      <!-- Content -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Dynamic Cards -->
        <div
          v-for="profil in standarPelayananList.slice(0, 3)"
          :key="profil.id"
          class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300"
        >
          <!-- Image Section with Date Overlay -->
          <div v-if="profil.gambar" class="relative">
            <img :src="`http://localhost:8000/storage/${profil.gambar}`" :alt="profil.title" class="w-full object-contain bg-gray-50 max-h-[900px]">
            <!-- Date overlay at bottom left -->
            <div class="absolute bottom-2 left-2 bg-black/60 text-white px-2 py-1 rounded text-xs font-medium">
              {{ formatDate(profil.tanggal || profil.created_at) }}
            </div>
          </div>

          <!-- No Image Fallback -->
          <div v-else class="p-6">
            <h4 class="text-lg font-bold text-gray-800 mb-2">{{ profil.title || 'Judul Tidak Tersedia' }}</h4>
            <div class="flex items-center justify-between text-sm">
              <span class="text-gray-500">{{ formatDate(profil.tanggal || profil.created_at) }}</span>
              <div class="flex items-center text-green-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Tersedia
              </div>
            </div>
          </div>
        </div>

        <!-- Fallback static cards if no data -->
        <div v-if="standarPelayananList.length === 0" class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
          <div class="bg-green-600 p-4">
            <div class="flex items-center justify-between">
              <h3 class="text-white font-semibold text-sm">Standar Pelayanan</h3>
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
          </div>
          <div class="p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-2">Jenis Pelayanan</h4>
            <p class="text-gray-600 text-sm mb-4">Pelayanan Informasi Publik</p>
            <div class="flex items-center text-green-600 text-sm">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Tersedia
            </div>
          </div>
        </div>
      </div>

      <!-- Button -->
      <div class="text-center">
        <router-link
          to="/standar-pelayanan-detail"
          class="inline-block bg-gradient-to-r from-green-600 to-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:from-green-700 hover:to-blue-700 transition-all duration-300 transform hover:scale-105"
        >
          Selengkapnya Tentang Standar Pelayanan
        </router-link>
      </div>
    </div>
  </section>
</template>

<script>
import { profilService } from '@/service/api'

export default {
  name: 'StandarPelayanan',
  data() {
    return {
      standarPelayananList: []
    }
  },
  async mounted() {
    await this.fetchStandarPelayanan()
  },
  methods: {
    async fetchStandarPelayanan() {
      try {
        const response = await profilService.getProfilByCategory('Standar Pelayanan')
        this.standarPelayananList = response.data || []
      } catch (error) {
        console.error('Error fetching standar pelayanan:', error)
        this.standarPelayananList = []
      }
    },
    formatDate(dateString) {
      if (!dateString) return '-'
      const date = new Date(dateString)
      return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }
  }
}
</script>

<style scoped>
.standar-pelayanan {
  background-color: #ffffff;
}
</style> 