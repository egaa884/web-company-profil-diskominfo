<template>
  <section class="kantor-dinas py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <!-- Title -->
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
          Kantor Dinas Komunikasi dan Informatika Kota Madiun
        </h2>
        <div class="w-32 h-1 bg-blue-600 mx-auto"></div>
      </div>

      <!-- Content -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        <!-- Left Column - Address and Hours -->
        <div class="space-y-8">
          <!-- Address -->
          <div class="bg-white p-8 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
              <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Alamat
            </h3>
            <p class="text-gray-700 leading-relaxed" v-if="officeData">
              {{ officeData.address }}
            </p>
            <p class="text-gray-700 leading-relaxed" v-else>
              Jalan Perintis Kemerdekaan Nomor 32<br>
              Kelurahan Kartoharjo, Kecamatan Kartoharjo<br>
              Kota Madiun, Jawa Timur
            </p>
          </div>

          <!-- Service Hours -->
          <div class="bg-white p-8 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
              <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Jam Pelayanan
            </h3>
            <div class="space-y-3" v-if="officeData">
              <div class="flex items-center" v-for="(hours, day) in officeData.hours" :key="day">
                <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                <span class="text-gray-700">{{ day }} ({{ hours }})</span>
              </div>
            </div>
            <div class="space-y-3" v-else>
              <div class="flex items-center">
                <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                <span class="text-gray-700">Senin - Kamis (07.00 - 15.30 WIB)</span>
              </div>
              <div class="flex items-center">
                <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                <span class="text-gray-700">Jumat (06.30 - 14.30 WIB)</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column - Image -->
        <div class="flex justify-center">
          <div class="w-full max-w-md h-96 bg-gray-300 rounded-lg flex items-center justify-center">
            <span class="text-gray-600 text-lg font-medium">Lampiran</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'KantorDinas',
  data() {
    return {
      officeData: null,
      loading: false
    }
  },
  async mounted() {
    await this.fetchOfficeData()
  },
  methods: {
    async fetchOfficeData() {
      try {
        this.loading = true
        const response = await fetch('http://localhost:8000/api/profile-page/kantor-dinas')
        const data = await response.json()
        this.officeData = data
      } catch (error) {
        console.error('Error fetching office data:', error)
        this.officeData = null
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.kantor-dinas {
  background-color: #f9fafb;
}
</style> 