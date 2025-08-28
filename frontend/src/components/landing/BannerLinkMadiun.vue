<template>
  <div class="relative flex justify-center items-center overflow-hidden py-32 bg-global-blue">
    <!-- Animasi teks berjalan di tengah -->
    <div class="absolute inset-0 flex items-center overflow-hidden">
      <div class="marquee">
        <span>
          DINAS KOMUNIKASI DAN INFORMATIKA KOTA MADIUN • DINAS KOMUNIKASI DAN INFORMATIKA KOTA MADIUN • 
        </span>
        <span>
          DINAS KOMUNIKASI DAN INFORMATIKA KOTA MADIUN • DINAS KOMUNIKASI DAN INFORMATIKA KOTA MADIUN • 
        </span>
      </div>
    </div>

    <!-- Kolom kiri -->
    <div class="flex-1 py-12 flex justify-center">
      <div class="text-white text-center max-w-xs relative z-10">
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

    <!-- Logo tengah -->
    <div class="absolute z-20">
      <img 
        src="@/assets/img/logo-madiun.png" 
        alt="Logo Kota Madiun"
        class="logo-madiun w-80 h-auto drop-shadow-lg"
      />
    </div>

    <!-- Kolom kanan -->
    <div class="flex-1 py-12 flex justify-center">
      <div class="text-white text-center max-w-xs relative z-10">
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
// tidak ada script yang diperlukan
</script>

<style scoped>
/* Warna background biru */
.bg-global-blue {
  background-color: #5ec7f1;
}

/* Logo hover effect */
.logo-madiun {
  transition: transform 0.3s ease-in-out;
}
.logo-madiun:hover {
  transform: scale(1.1) rotateY(6deg);
}

/* Marquee tanpa pause */
.marquee {
  display: flex;
  width: max-content;
  animation: marquee 20s linear infinite;
}

.marquee span {
  font-size: 140px;
  font-weight: 800;
  color: white;
  opacity: 0.2;
  white-space: nowrap;
  padding-right: 4rem; /* jarak antar teks */
}

@keyframes marquee {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>
