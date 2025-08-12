<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-xl">
    <div class="relative">
      <img :src="infographic.imageSrc" :alt="infographic.title" class="w-full h-48 object-cover">
      <div class="absolute bottom-0 left-0 bg-blue-500 text-white p-3 font-bold text-center">
        <span class="block text-2xl leading-none">{{ infographic.day }}</span>
        <span class="block text-sm uppercase">{{ infographic.month }} {{ infographic.year }}</span>
      </div>
    </div>
    <div class="p-6">
      <span class="text-xs font-medium text-gray-500 mb-2 block">{{ infographic.category }}</span>
      <h2 class="text-xl font-semibold text-gray-800 leading-tight mb-3">{{ infographic.title }}</h2>
      <div class="text-gray-500 text-sm flex items-center mb-4">
        <span class="flex items-center mr-4">
          <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zM9.002 11a6 6 0 011.002 0zM12 11a6 6 0 00-4 10.669A8.995 8.995 0 0112 20a8.995 8.995 0 014-1.331A6 6 0 0012 11z"/></svg>
          Admin
        </span>
        <span class="flex items-center">
          <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
          {{ infographic.publishedDate }}
        </span>
      </div>
      <div class="flex justify-between items-center mt-auto">
        <a href="#" class="bg-blue-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-600 transition duration-300">
          Baca Lebih
        </a>
        <div class="flex gap-2 text-gray-500">
          <a href="#"><svg class="w-5 h-5 hover:text-blue-600 transition duration-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
          <a href="#"><svg class="w-5 h-5 hover:text-blue-400 transition duration-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.46 6c-.83.37-1.8.63-2.82.74a4.39 4.39 0 001.91-2.73 8.78 8.78 0 01-3.05 1.16 4.39 4.39 0 00-7.49 3.99A12.44 12.44 0 013 4.71a4.39 4.39 0 001.36 5.86 4.39 4.39 0 01-1.99-.55v.06a4.39 4.39 0 003.53 4.3L7 15.65a4.39 4.39 0 001.97-.24 4.39 4.39 0 004.14 3.05 8.78 8.78 0 01-5.46 1.88c-.35 0-.69-.02-1.03-.06a12.42 12.42 0 006.74 1.97c8.08 0 12.49-6.69 12.49-12.49 0-.19-.01-.39-.01-.58a8.97 8.97 0 002.21-2.3z"/></svg></a>
          <a href="#"><svg class="w-5 h-5 hover:text-blue-800 transition duration-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20.47 2H3.53A1.53 1.53 0 002 3.53v16.94A1.53 1.53 0 003.53 22h16.94A1.53 1.53 0 0022 20.47V3.53A1.53 1.53 0 0020.47 2zM8 19H5V9h3v10zM6.5 7A1.5 1.5 0 115 5.5 1.5 1.5 0 016.5 7zm12.5 12h-3v-5a3 3 0 00-3-3 3 3 0 00-3 3v5h-3V9h3v1.89a4.84 4.84 0 014.28-2.31c2.51 0 4.72 1.76 4.72 5.54z"/></svg></a>
          <button class="bg-gray-200 p-1 rounded-full"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M15 8a.5.5 0 01.5.5v5.793l1.146-1.147a.5.5 0 01.708.708l-2 2a.5.5 0 01-.708 0l-2-2a.5.5 0 01.708-.708L15.5 14.293V8.5a.5.5 0 01.5-.5zM5 8a.5.5 0 01.5.5v5.793l1.146-1.147a.5.5 0 01.708.708l-2 2a.5.5 0 01-.708 0l-2-2a.5.5 0 01.708-.708L4.5 14.293V8.5A.5.5 0 015 8zM10 1a9 9 0 100 18 9 9 0 000-18zm0 17a8 8 0 110-16 8 8 0 010 16z"/></svg></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Menerima objek 'infographic' dari komponen induk
const props = defineProps({
  infographic: {
    type: Object,
    required: true,
  }
});
</script>

<style scoped>
/* Anda bisa menambahkan gaya CSS tambahan di sini jika diperlukan */
</style>