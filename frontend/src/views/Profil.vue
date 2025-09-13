<template>
  <div class="profile-page min-h-screen bg-gray-50">
    <!-- Hero Section -->
     <HeroSection 
      firstLine="PROFIL"
      secondLine="DISKOMINFO KOTA MADIUN"
      :backgroundImage="LogoKominfo"
    />

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <!-- Sekilas Dinas Section -->
      <SekilasDinas />

      <!-- Kantor Dinas Section -->
      <KantorDinas />

      <!-- Visi Misi Section -->
      <VisiMisi />

      <!-- Struktur Organisasi Section -->
      <StrukturOrganisasi />

      <!-- Tugas Pokok dan Fungsi Section -->
      <TugasPokokFungsi />

      <!-- Standar Pelayanan Section -->
      <StandarPelayanan />
    </div>
  </div>
</template>

<script>
import SekilasDinas from '@/components/profile/SekilasDinas.vue'
import HeroSection from '@/components/global/HeroSection.vue'
import KantorDinas from '@/components/profile/KantorDinas.vue'
import VisiMisi from '@/components/profile/VisiMisi.vue'
import StrukturOrganisasi from '@/components/profile/StrukturOrganisasi.vue'
import TugasPokokFungsi from '@/components/profile/TugasPokokFungsi.vue'
import StandarPelayanan from '@/components/profile/StandarPelayanan.vue'

export default {
  name: 'Profil',
  components: {
    HeroSection,
    SekilasDinas,
    KantorDinas,
    VisiMisi,
    StrukturOrganisasi,
    TugasPokokFungsi,
    StandarPelayanan
  }
}
</script>

<style scoped>
.profile-page {
  font-family: 'Inter', sans-serif;
}
</style>