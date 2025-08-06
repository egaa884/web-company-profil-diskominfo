<template>
  <div class="category-list">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Kategori</h3>
    <div class="bg-blue-50 rounded-lg p-4">
      <ul class="space-y-2">
        <li 
          v-for="(category, index) in categories" 
          :key="index"
          @click="selectCategory(category)"
          :class="[
            'text-blue-600 hover:text-blue-800 cursor-pointer underline',
            { 'font-bold text-blue-800': selectedCategory === category }
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
  data() {
    return {
      categories: [],
      selectedCategory: 'all',
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
        // Fallback to default categories if API fails
        this.categories = [
          'Semua',
          'Dokumen',
          'Standar Operasional Prosedur (SOP)',
          'Laporan Kinerja',
          'Laporan Penerimaan Layanan Publik',
          'Laporan Pengaduan Pelayanan Publik',
          'Berita',
          'Informasi'
        ]
      } finally {
        this.loading = false
      }
    },
    selectCategory(category) {
      this.selectedCategory = category === 'Semua' ? 'all' : category
      this.$emit('category-selected', this.selectedCategory)
    }
  }
}
</script>

<style scoped>
.category-list {
  margin-top: 2rem;
}
</style> 