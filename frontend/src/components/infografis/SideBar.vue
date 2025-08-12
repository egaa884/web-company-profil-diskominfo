<template>
  <aside class="w-full lg:w-1/4">
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
      <h3 class="text-xl font-semibold border-b pb-2 mb-4 text-gray-700">| Search</h3>
      <div class="relative">
        <input type="text" placeholder="Search" class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
      </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
      <h3 class="text-xl font-semibold border-b pb-2 mb-4 text-gray-700">| Categories</h3>
      <ul>
        <li v-for="category in categories" :key="category.name" class="flex justify-between items-center py-2 border-b last:border-b-0">
          <a href="#" class="text-gray-600 hover:text-blue-500 transition duration-300">{{ category.name }}</a>
          <span class="text-gray-400">({{ category.count }})</span>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script setup>
// Menerima data 'categories' dari komponen induk
const props = defineProps({
  categories: {
    type: Array,
    required: true,
  }
});
</script>

<style scoped>
/* Anda bisa menambahkan gaya CSS tambahan di sini jika diperlukan */
</style>