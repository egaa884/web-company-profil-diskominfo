<template>
  <div class="bg-gray-100 py-12 px-6 lg:px-12 min-h-screen">
    <div class="mx-auto max-w-7xl flex flex-col lg:flex-row gap-8">
      <InfographicSidebar :categories="categories" />

      <main class="w-full lg:w-3/4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <InfographicCard
            v-for="infographic in infographics"
            :key="infographic.id"
            :infographic="infographic"
          />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import InfographicSidebar from '../components/infografis/SideBar.vue';
import InfographicCard from '../components/infografis/Card.vue';

// Data untuk kategori
const categories = ref([
  { name: 'Culture', count: 5 },
  { name: 'Government', count: 4 },
  { name: 'Music', count: 6 },
  { name: 'Organizations', count: 7 },
  { name: 'Sport', count: 8 },
  { name: 'Festival', count: 9 },
]);

// Data untuk daftar infografis
const infographics = ref([
  {
    id: 1,
    imageSrc: 'http://googleusercontent.com/file_content/1',
    category: 'Infografis',
    day: '25',
    month: 'Jun',
    year: '2025',
    title: 'Waspada Modus Penipuan Aktivasi IKD',
    admin: 'Admin',
    publishedDate: '09 Jun 2025',
  },
  {
    id: 2,
    imageSrc: 'https://i.ibb.co/3sX86kP/infografis-sekolah.jpg',
    category: 'Infografis',
    day: '18',
    month: 'May',
    year: '2025',
    title: 'Sebentar Lagi Anak Daftar Sekolah, Kenali Jalur Penerimaannya!',
    admin: 'Admin',
    publishedDate: '08 May 2025',
  },
  {
    id: 3,
    imageSrc: 'https://i.ibb.co/w0m1tG1/infografis-indeks.jpg',
    category: 'Infografis',
    day: '06',
    month: 'May',
    year: '2025',
    title: 'Tren Peningkatan Indeks Reformasi Birokrasi Pemerintah Kota Madiun',
    admin: 'Admin',
    publishedDate: '05 May 2025',
  },
]);
</script>

<style scoped>

/* Anda bisa menambahkan gaya CSS tambahan di sini jika diperlukan */
</style>