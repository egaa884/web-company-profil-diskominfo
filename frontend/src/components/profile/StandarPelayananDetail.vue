<template>
  <section class="standar-pelayanan-detail py-16">
    <div class="container mx-auto px-4">
      <!-- Title -->
      <div class="text-center mb-12 mt-12">
        <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
          Standar Pelayanan Lengkap
        </h2>
        <div class="w-32 h-1 bg-blue-600 mx-auto"></div>
        <p class="text-gray-600 mt-4">Dinas Komunikasi dan Informatika Kota Madiun</p>
      </div>

      <!-- Content -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Dynamic Cards -->
        <div
          v-for="profil in standarPelayananList"
          :key="profil.id"
          class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300"
        >
          <!-- Image Section with Date Overlay -->
          <div v-if="profil.gambar" class="relative">
            <img :src="`http://localhost:8000/storage/${profil.gambar}`" :alt="profil.title" class="w-full object-contain bg-gray-50 max-h-[900px]">
            <!-- Date overlay at bottom left -->
            <div class="absolute bottom-3 left-3 bg-black/70 text-white px-3 py-2 rounded-md text-sm font-medium">
              {{ formatDate(profil.tanggal || profil.created_at) }}
            </div>
          </div>

          <!-- No Image Fallback -->
          <div v-else class="p-6">
            <h4 class="text-xl font-bold text-gray-800 mb-2">{{ profil.title || 'Judul Tidak Tersedia' }}</h4>
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

        <!-- No data message -->
        <div v-if="standarPelayananList.length === 0" class="col-span-full text-center py-12">
          <div class="text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-xl font-semibold mb-2">Belum ada data Standar Pelayanan</h3>
            <p>Silakan tambahkan data standar pelayanan melalui panel admin.</p>
          </div>
        </div>
      </div>

      <!-- Back Button -->
      <div class="text-center mt-12">
        <router-link
          to="/profil"
          class="inline-block bg-gray-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-gray-700 transition-all duration-300"
        >
          Kembali ke Profil
        </router-link>
      </div>
    </div>
  </section>
</template>

<script>
import { profilService } from '@/service/api'

export default {
  name: 'StandarPelayananDetail',
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
.standar-pelayanan-detail {
  background-color: #ffffff;
}
</style>