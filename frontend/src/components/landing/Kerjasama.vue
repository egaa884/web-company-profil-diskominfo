<template>
  <div class="py-12 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <h2 class="text-center text-3xl font-bold leading-8 text-gray-900">
        Bekerja Sama Dengan
      </h2>

      <div class="scroller-container mt-11 w-full overflow-hidden">
        <div ref="leftScroller" class="overflow-hidden">
          <ul
            ref="leftInner"
            class="scroller__inner flex whitespace-nowrap items-center gap-16 py-2 animate-scroll-left"
            style="--duration: 10s;"
          >
            <li
              v-for="(card, index) in scrollListCards"
              :key="'left-' + index"
              class="min-w-fit transition duration-1000 hover:scale-105"
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
            </li>
          </ul>
        </div>

        <div ref="rightScroller" class="mt-4 overflow-hidden">
          <ul
            ref="rightInner"
            class="scroller__inner flex whitespace-nowrap items-center gap-16 py-2 animate-scroll-right"
            style="--duration: 10s;"
          >
            <li
              v-for="(card, index) in scrollListReversedCards"
              :key="'right-' + index"
              class="min-w-fit transition duration-1000 hover:scale-105"
            >
              <div
                class="flex flex-col items-start p-4 rounded-md bg-gradient-to-r from-[#2E7A52] to-[#0292D7] text-white w-[250px] h-[120px] justify-between"
              >
                <div class="flex items-center gap-2">
                  <img
                    :src="card.imgSrc"
                    alt="Logo Perusahaan"
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
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
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

const scrollListCards = [...cardData];
const scrollListReversedCards = [...cardData.slice().reverse()];

const leftInner = ref(null);
const rightInner = ref(null);

onMounted(() => {
  duplicateImages(leftInner.value, 2);
  duplicateImages(rightInner.value, 2);
});

function duplicateImages(ulElement, times) {
  const items = Array.from(ulElement.children);
  for (let i = 0; i < times; i++) {
    items.forEach((item) => {
      const clone = item.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      ulElement.appendChild(clone);
    });
  }
}
</script>

<style scoped>
@keyframes scroll-left {
  0% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(-100%);
  }
}

@keyframes scroll-right {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(0%);
  }
}

.animate-scroll-left {
  animation: scroll-left var(--duration) linear infinite;
}

.animate-scroll-right {
  animation: scroll-right var(--duration) linear infinite;
}
</style>