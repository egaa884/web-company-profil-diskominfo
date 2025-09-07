<template>
  <div class="category-wrapper">
    <h3 class="text-xl font-bold text-gray-800 mb-4 cursor-pointer">Kategori</h3>
    
    <div class="category-list-hidden">
      <div v-if="loading" class="space-y-2">
        <div v-for="i in 5" :key="i" class="h-8 bg-gray-300 rounded animate-pulse"></div>
      </div>
      
      <ul v-else class="space-y-2">
        <li
          v-for="(category, index) in categories"
          :key="index"
          @click="selectCategory(category)"
          :class="[
            'text-blue-600 p-2 rounded hover:text-blue-800 hover:bg-gray-100 cursor-pointer',
            { 'font-bold bg-blue-100 text-blue-800': selectedCategory === (category === 'Semua' ? 'all' : category) }
          ]"
        >
          {{ category }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { beritaService } from '@/service/api.js'

export default {
  name: 'CategoryList',
  props: {
    selectedCategory: {
      type: String,
      default: 'all'
    }
  },
  emits: ['category-selected'],
  data() {
    return {
      categories: [],
      loading: false
    }
  },
  async mounted() {
    await this.fetchCategories()
  },
  methods: {
    async fetchCategories() {
      try {
        this.loading = true
        const response = await beritaService.getCategories()
        this.categories = ['Semua', ...response.data]
      } catch (error) {
        console.error('Error fetching categories:', error)
        this.categories = [
          'Semua',
          'Berita Kominfo Madiun',
          'Kabar Warga',
          'Siaran Pers Madiun',
          'Infografis Madiun',
        ]
      } finally {
        this.loading = false
      }
    },
    selectCategory(category) {
      const selected = category === 'Semua' ? 'all' : category;
      this.$emit('category-selected', selected);
    }
  }
}
</script>

<style scoped>
.category-wrapper {
  position: relative;
}

.category-list-hidden {
  position: absolute;
  top: 100%; /* Menempatkan daftar di bawah judul */
  left: 0;
  right: 0;
  background-color: white;
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  z-index: 50;
  padding: 0.5rem;
  
  /* Properti untuk menyembunyikan dan menampilkan dengan transisi */
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
}

.category-wrapper:hover .category-list-hidden {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}
</style>