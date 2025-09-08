<template>
  <section class="visi-misi py-16 bg-blue-500">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 underline">
          VISI & MISI
        </h2>
      </div>

      <!-- Loading state -->
      <div v-if="loading" class="flex flex-col md:flex-row justify-center items-center gap-8 max-w-4xl mx-auto">
        <div class="bg-blue-900 rounded-xl p-6 shadow-lg md:w-64 w-full h-64 animate-pulse">
          <div class="w-48 h-48 bg-blue-800 rounded mx-auto"></div>
        </div>
        <div class="bg-gray-100 rounded-xl p-6 shadow-lg md:w-64 w-full h-64 animate-pulse">
          <div class="w-48 h-48 bg-gray-200 rounded mx-auto"></div>
        </div>
      </div>

      <!-- Content -->
      <div v-else class="flex flex-col md:flex-row justify-center items-center gap-8 max-w-4xl mx-auto">
        <div class="visi-card bg-blue-900 rounded-xl p-6 shadow-lg transition-all duration-500 hover:scale-105 relative overflow-hidden
                    flex items-center justify-end md:w-64 w-full h-auto min-height-[25rem]
                    hover:w-96 md:hover:w-[32rem] lg:hover:w-[36rem]">
          
          <img
            v-if="profilData?.gambar"
            :src="getImageUrl(profilData.gambar)"
            alt="Visi"
            class="w-48 h-48 flex-shrink-0"
          />
          <img
            v-else
            src="@/assets/img/visi.png"
            alt="Visi"
            class="w-48 h-48 flex-shrink-0"
          />

          <div class="visi-hover-content absolute top-0 left-0 h-full flex items-center justify-start
                      p-6 opacity-0 transition-all duration-300 delay-200">
            <div class="text-left text-white space-y-1 pr-4">
              <div class="mb-12">
                <img src="../../assets/img/Idea.png" alt="lampu">
              </div>
              <div class="text-white space-y-1" v-if="profilData?.konten" v-html="profilData.konten"></div>
              <div v-else class="text-white space-y-1">
                <p class="text-lg font-semibold">Terwujudnya</p>
                <p class="text-lg font-semibold">Pemerintahan</p>
                <p class="text-lg font-semibold">Bersih Berwibawa</p>
                <p class="text-lg font-semibold">Menuju masyarakat</p>
                <p class="text-lg font-semibold">Sejahtera</p>
              </div>
            </div>
          </div>
        </div>

        <div class="misi-card bg-gray-100 rounded-xl p-6 shadow-lg transition-all duration-500 hover:scale-105 relative overflow-hidden
                    flex items-center justify-start md:w-64 w-full h-auto min-height-[25rem]
                    hover:w-96 md:hover:w-[32rem] lg:hover:w-[36rem]">
          
          <img
            src="@/assets/img/misi.png"
            alt="Misi"
            class="w-48 h-48 flex-shrink-0"
          />

          <div class="misi-hover-content absolute top-0 right-0 h-full flex items-center justify-start
                      p-6 pl-10 opacity-0 transition-all duration-300 delay-200">
            <div class="text-left text-blue-900 space-y-2">
              <div class="absolute top-4 right-4">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="10" fill="yellow" stroke="red" stroke-width="2"/>
                  <circle cx="12" cy="12" r="6" fill="red" stroke="white" stroke-width="1"/>
                  <circle cx="12" cy="12" r="2" fill="white"/>
                  <path d="M12 2L12 8M12 16L12 22M2 12L8 12M16 12L22 12" stroke="blue" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </div>

              <div class="text-blue-900 space-y-2">
                <div class="flex items-start">
                  <span class="font-bold mr-2 text-base">1.</span>
                  <span class="text-xs">Meningkatkan Kualitas Hidup Masyarakat Kota Madiun</span>
                </div>
                <div class="flex items-start">
                  <span class="font-bold mr-2 text-base">2.</span>
                  <span class="text-xs">Mewujudkan Pemerintahan yang Baik (Good Governance) Melalui Peningkatan Kualitas Pelayanan Kepada Masyarakat</span>
                </div>
                <div class="flex items-start">
                  <span class="font-bold mr-2 text-base">3.</span>
                  <span class="text-xs">Meningkatkan Pembangunan Berbasis Pada Partisipasi Masyarakat Kota Madiun Dalam Perencanaan, Pelaksanaan dan Pengawasan Pembangunan</span>
                </div>
                <div class="flex items-start">
                  <span class="font-bold mr-2 text-base">4.</span>
                  <span class="text-xs">Mewujudkan Kemandirian Ekonomi dan Meratakan Tingkat Kesejahteraan Masyarakat Kota Madiun</span>
                </div>
                <div class="flex items-start">
                  <span class="font-bold mr-2 text-base">5.</span>
                  <span class="text-xs">Mewujudkan Keterbukaan Informasi Publik Sebagai Kontrol Kinerja dan Akuntabilitas Terhadap Pemerintah</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { profilService } from '@/service/api.js'

export default {
  name: 'VisiMisi',
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
        const response = await fetch('http://localhost:8000/api/profile-page/visi-misi')
        const data = await response.json()
        this.profilData = data
      } catch (error) {
        console.error('Error fetching visi misi data:', error)
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
.visi-misi {
  background: #3b82f6; /* bright blue background */
}

/* Base styles for the cards */
.visi-card, .misi-card {
  height: auto; /* Mengizinkan tinggi menyesuaikan konten */
  min-height: 25rem; /* Tinggi minimum agar kartu tidak terlalu kecil di awal */
  min-width: 20rem; /* Lebar minimum */
  position: relative;
  overflow: hidden; /* Penting untuk menyembunyikan konten yang meluap */
  transition: all 0.5s ease-in-out; /* Transisi untuk lebar dan properti lainnya */
}

/* Visi Card specific styles */
.visi-card {
  justify-content: flex-end; /* Memposisikan gambar ke kanan dalam flex container */
  padding-left: 0; /* Menghilangkan padding kiri bawaan p-6 untuk kontrol lebih baik */
}

/* Konten hover di visi card */
.visi-hover-content {
  background-color: inherit; /* Menggunakan warna background card */
  width: calc(100% - 16rem); /* 100% lebar card dikurangi lebar gambar (w-48 = 12rem) */
  left: 0; /* Pastikan menempel di kiri */
  justify-content: flex-end; /* Konten di dalamnya mepet ke kanan */
}

.visi-card:hover .visi-hover-content {
  opacity: 1; /* Konten muncul saat hover */
}

/* Misi Card specific styles */
.misi-card {
  justify-content: flex-start; /* Memposisikan gambar ke kiri dalam flex container */
  padding-right: 0; /* Menghilangkan padding kanan bawaan p-6 untuk kontrol lebih baik */
}

/* Konten hover di misi card */
.misi-hover-content {
  background-color: inherit; /* Menggunakan warna background card */
  width: calc(100% - 15rem); /* 100% lebar card dikurangi lebar gambar (w-48 = 12rem) */
  right: 0; /* Pastikan menempel di kanan */
  justify-content: flex-start; /* Konten di dalamnya mepet ke kiri */
  padding-left: 2rem; /* Memberikan sedikit ruang dari kiri agar teks tidak terlalu mepet */
}

.misi-card:hover .misi-hover-content {
  opacity: 1; /* Konten muncul saat hover */
}

/* Aturan umum untuk konten hover */
.visi-hover-content, .misi-hover-content {
  transition: opacity 0.3s ease-in-out;
}

/* Sesuaikan padding gambar agar tidak terlalu mepet ke ujung saat kartu memanjang */
.visi-card img {
  padding-right: 1.5rem; /* Menambahkan padding kanan untuk gambar visi */
}
.misi-card img {
  padding-left: 1.5rem; /* Menambahkan padding kiri untuk gambar misi */
}

/* Media Queries untuk menyesuaikan lebar pada berbagai ukuran layar */
@media (min-width: 768px) { /* md breakpoint */
  .visi-card:hover, .misi-card:hover {
    width: 32rem; /* Lebar yang memanjang untuk md */
  }
}

@media (min-width: 1024px) { /* lg breakpoint */
  .visi-card:hover, .misi-card:hover {
    width: 36rem; /* Lebar yang memanjang untuk lg */
  }
}
</style>