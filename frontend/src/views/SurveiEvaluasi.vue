<template>
  <div class="sertifikat-page min-h-screen bg-gray-100">
    <!-- Hero Section -->
    <HeroSection 
      firstLine="SURVEI"
      secondLine="PELAYANAN PUBLIK"
      thirdLine="DISKOMINFO KOTA MADIUN"
      backgroundImage="@/assets/img/logo-kominfo.png"
    />

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-20 flex flex-col items-center">
      <!-- Sertifikat Card 1 -->
      <SertifikatCard 
        :image="SertifImage"
        pdf="/sertifikat.pdf"
        title="Survei Kepuasan Masyarakat 2025"
      />
    </div>
  </div>
</template>

<script setup>
import HeroSection from "@/components/global/HeroSection.vue";
import SertifikatCard from "@/components/global/SertifikatCard.vue";
import SertifImage from "@/assets/img/sertif2.jpg";
</script>

<style scoped>
.sertifikat-page {
  font-family: 'Inter', sans-serif;
}
</style>
