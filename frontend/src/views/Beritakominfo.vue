<template>
  <div class="news-page min-h-screen bg-gray-50">
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Left Column - Main Content -->
        <div class="lg:col-span-3">
          <HotNews />
          <NewsGrid :selectedCategory="selectedCategory" />
        </div>

        <!-- Right Column - Sidebar -->
        <div class="lg:col-span-1">
          <LatestNews />
          <CategoryList @category-selected="handleCategorySelected" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import HotNews from '@/components/news/HotNews.vue'
import NewsGrid from '@/components/news/NewsGrid.vue'
import LatestNews from '@/components/news/LatestNews.vue'
import CategoryList from '@/components/news/CategoryList.vue'

export default {
  name: 'Beritakominfo',
  components: {
    HotNews,
    NewsGrid,
    LatestNews,
    CategoryList
  },
  data() {
    return {
      selectedCategory: 'all'
    }
  },
  methods: {
    handleCategorySelected(category) {
      this.selectedCategory = category
    }
  }
}
</script>

<style scoped>
.news-page {
  font-family: 'Inter', sans-serif;
  top: 10px;
}
</style> 