<template>
  <div class="py-12 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <h2 class="text-center text-3xl font-bold leading-8 text-gray-900">
        Bekerja Sama Dengan
      </h2>
    </div>

    <!-- Buat scroller full width -->
    <div class="mt-11 w-full overflow-hidden relative">
      <!-- Scroller kiri -->
      <div class="scroller">
        <div class="scroller__inner animate-scroll-left" style="--duration: 25s;">
          <div
            v-for="(card, index) in [...cardData, ...cardData]"
            :key="'left-' + index"
            class="card"
          >
            <div
              class="flex flex-col items-start p-4 rounded-md bg-gradient-to-r from-[#2E7A52] to-[#0292D7] text-white w-[250px] h-[120px] justify-between"
            >
              <div class="flex items-center gap-2">
                <img
                  :src="card.imgSrc"
                  alt="logo perusahaan"
                  class="w-[50px] h-[50px] object-contain rounded-md"
                />
                <p class="text-lg font-semibold">{{ card.text }}</p>
              </div>
              <div class="w-full h-px bg-white/50 my-2"></div>
              <a
                :href="card.url"
                target="_blank"
                rel="noopener noreferrer"
                class="text-sm cursor-pointer flex items-center text-white no-underline hover:underline"
              >
                Selengkapnya <span class="ml-1">&gt;</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Scroller kanan -->
      <div class="scroller mt-6">
        <div class="scroller__inner animate-scroll-right" style="--duration: 25s;">
          <div
            v-for="(card, index) in [...cardData.slice().reverse(), ...cardData.slice().reverse()]"
            :key="'right-' + index"
            class="card"
          >
            <div
              class="flex flex-col items-start p-4 rounded-md bg-gradient-to-r from-[#2E7A52] to-[#0292D7] text-white w-[250px] h-[120px] justify-between"
            >
              <div class="flex items-center gap-2">
                <img
                  :src="card.imgSrc"
                  alt="logo perusahaan"
                  class="w-[50px] h-[50px] object-contain rounded-md"
                />
                <p class="text-lg font-semibold">{{ card.text }}</p>
              </div>
              <div class="w-full h-px bg-white/50 my-2"></div>
              <a
                :href="card.url"
                target="_blank"
                rel="noopener noreferrer"
                class="text-sm cursor-pointer flex items-center text-white no-underline hover:underline"
              >
                Selengkapnya <span class="ml-1">&gt;</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import logoMadiun from '../../assets/img/logo-madiun.png';
import logoMadiunToday from '../../assets/img/logo-madiun-today.png';
import logoPecel from '../../assets/img/logo-pecel.png';
import logoPpid from '../../assets/img/logo-madiun.png';
import logoAwakSigap from '../../assets/img/logo-awak-sigap.png';
import logoSuaraMadiun from '../../assets/img/logo-suara-madiun.png';

const cardData = [
  { imgSrc: logoMadiun, text: 'Edu', url: 'https://edu.madiunkota.go.id/' }, 
  { imgSrc: logoMadiun, text: 'Madiun Siaga', url: 'https://api.whatsapp.com/send?phone=628113577800' },
  { imgSrc: logoMadiunToday, text: 'Madiun Today', url: 'https://madiuntoday.id/' },
  { imgSrc: logoMadiun, text: 'Analisa Berita', url: 'https://analisaberita.madiunkota.go.id/' },
  { imgSrc: logoMadiun, text: 'Open Data', url: 'https://opendata.madiunkota.go.id/' },
  { imgSrc: logoPecel, text: 'Pecel Tumpang', url: 'https://peceltumpang.madiunkota.go.id/' },
  { imgSrc: logoPpid, text: 'PPID Kota Madiun', url: 'https://ppid.madiunkota.go.id/' },
  { imgSrc: logoAwakSigap, text: 'Awak Sigap', url: 'https://awaksigap.madiunkota.go.id/' },
  { imgSrc: logoMadiun, text: 'Sipdok', url: 'https://sipdok.madiunkota.go.id/' },
  { imgSrc: logoMadiun, text: 'Smart City Madiun', url: 'https://smartcity.madiunkota.go.id/' },
  { imgSrc: logoMadiun, text: 'SPBE Kota Madiun', url: 'https://spbe.madiunkota.go.id/' },
  { imgSrc: logoSuaraMadiun, text: 'Suara Radio Madiun', url: 'https://93fm.madiunkota.go.id/' },
];
</script>

<style scoped>
.scroller {
  width: 100vw; /* full lebar layar */
  overflow: hidden;
  position: relative;
  margin-left: calc(-50vw + 50%); /* hilangkan padding container */
}

.scroller__inner {
  display: flex;
  gap: 4rem;
  width: max-content;
}

.card {
  min-width: fit-content;
  transition: transform 1s;
}
.card:hover {
  transform: scale(1.05);
}

/* Animasi infinite tanpa pause */
@keyframes scroll-left {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
@keyframes scroll-right {
  0%   { transform: translateX(-50%); }
  100% { transform: translateX(0); }
}

.animate-scroll-left {
  animation: scroll-left var(--duration) linear infinite;
}
.animate-scroll-right {
  animation: scroll-right var(--duration) linear infinite;
}
</style>
