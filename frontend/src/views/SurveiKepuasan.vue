<template>
    <HeroSection 
      firstLine="SURVEI"
      secondLine="KEPUASAN MASYARAKAT"
      thirdLine="DISKOMINFO KOTA MADIUN"
      :backgroundImage="LogoKominfo"
    />
  <div class="min-h-screen bg-gray-100 flex flex-col items-center py-20">
    <h1 class="text-3xl font-bold mb-10">Survei Kepuasan Masyarakat</h1>

    <!-- Sertifikat Card 1 -->
    <SertifikatCard 
      :image="SertifImage"
      pdf="/sertifikat.pdf"
      title="Survei Kepuasan Masyarakat 2025"
    />
  </div>
</template>

<script setup>
import SertifikatCard from "@/components/global/SertifikatCard.vue";
import LogoKominfo from "@/assets/img/logo-kominfo.png";
import HeroSection from "@/components/global/HeroSection.vue";
import SertifImage from "@/assets/img/sertif1.0.png"
</script>
