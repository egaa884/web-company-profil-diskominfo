<template>
  <section class="tugas-pokok-fungsi py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <!-- Title -->
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
          Tugas Pokok dan Fungsi Dinas Komunikasi dan Informatika Kota Madiun
        </h2>
        <div class="w-32 h-1 bg-blue-600 mx-auto"></div>
      </div>

      <!-- Content -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        <!-- Left Column - Text Content -->
        <div class="bg-white rounded-lg shadow-lg p-8">
          <h3 class="text-xl font-bold text-blue-900 mb-6">Dasar Hukum</h3>
          <p class="text-gray-700 leading-relaxed mb-6">
            Tugas pokok dan fungsi Dinas Komunikasi dan Informatika Kota Madiun ditetapkan berdasarkan 
            Peraturan Wali Kota Madiun Nomor 72 Tahun 2021 tentang Kedudukan, Susunan Organisasi, 
            Tugas, Fungsi dan Tata Kerja Dinas Komunikasi dan Informatika.
          </p>
          
          <h4 class="text-lg font-semibold text-blue-800 mb-4">Tugas Pokok:</h4>
          <ul class="text-gray-700 space-y-3 mb-6">
            <li class="flex items-start">
              <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></div>
              <span>Melaksanakan urusan pemerintahan di bidang komunikasi dan informatika</span>
            </li>
            <li class="flex items-start">
              <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></div>
              <span>Melaksanakan urusan pemerintahan di bidang persandian</span>
            </li>
            <li class="flex items-start">
              <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></div>
              <span>Melaksanakan urusan pemerintahan di bidang statistik</span>
            </li>
          </ul>

          <h4 class="text-lg font-semibold text-blue-800 mb-4">Fungsi:</h4>
          <ul class="text-gray-700 space-y-3">
            <li class="flex items-start">
              <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></div>
              <span>Perumusan kebijakan teknis di bidang komunikasi dan informatika</span>
            </li>
            <li class="flex items-start">
              <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></div>
              <span>Pelaksanaan kebijakan di bidang komunikasi dan informatika</span>
            </li>
            <li class="flex items-start">
              <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></div>
              <span>Pelaksanaan evaluasi dan pelaporan di bidang komunikasi dan informatika</span>
            </li>
            <li class="flex items-start">
              <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3 flex-shrink-0"></div>
              <span>Pelaksanaan administrasi dinas</span>
            </li>
          </ul>
        </div>

        <!-- Right Column - Document -->
        <div class="flex justify-center">
          <div class="w-full max-w-md h-96 bg-gray-300 rounded-lg flex items-center justify-center">
            <div class="text-center">
              <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <span class="text-gray-600 text-lg font-medium">Lampiran</span>
              <p class="text-gray-500 text-sm mt-2">Dokumen Tugas Pokok dan Fungsi</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'TugasPokokFungsi',
  data() {
    return {
      tugasData: null,
      loading: false
    }
  },
  async mounted() {
    await this.fetchTugasData()
  },
  methods: {
    async fetchTugasData() {
      try {
        this.loading = true
        const response = await fetch('http://localhost:8000/api/profile-page/tugas-pokok-fungsi')
        const data = await response.json()
        this.tugasData = data
      } catch (error) {
        console.error('Error fetching tugas pokok fungsi data:', error)
        this.tugasData = null
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.tugas-pokok-fungsi {
  background-color: #f9fafb;
}
</style> 