<template>
  <div class="relative flex justify-center items-center overflow-visible py-32">
    <div class="flex-1 banner-gradient py-12 flex justify-center">
      <div class="text-white text-center max-w-xs">
        <h2 class="text-2xl font-bold mb-2">Smart City<br/>Kota Madiun</h2>
        <a 
          href="https://smartcity.madiunkota.go.id/"
          target="_blank"
          class="inline-flex items-center text-gray-200 hover:text-white font-medium"
        >
          Jelajahi →
        </a>
      </div>
    </div>

    <div class="absolute z-20">
      <img 
        src="@/assets/img/logo-madiun.png" 
        alt="Logo Kota Madiun"
        class="logo-madiun w-80 h-auto drop-shadow-lg"
      />
    </div>

    <div class="flex-1 banner-gradient py-12 flex justify-center">
      <div class="text-white text-center max-w-xs">
        <h2 class="text-2xl font-bold mb-2">Pemerintah<br/>Kota Madiun</h2>
        <a 
          href="https://madiunkota.go.id/"
          target="_blank"
          class="inline-flex items-center text-gray-200 hover:text-white font-medium"
        >
          Jelajahi →
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
// tidak ada script yang diperlukan untuk komponen ini
</script>

<style scoped>
.banner-gradient {
  background: radial-gradient(circle, #0292D8 0%, #2F7B52 100%);
}

.logo-madiun {
  transition: transform 0.3s ease-in-out;
}

.logo-madiun:hover {
  transform: scale(1.1) rotateY(6deg);
}
</style>