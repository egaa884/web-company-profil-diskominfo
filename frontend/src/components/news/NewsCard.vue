<template>
  <div 
    class="news-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer"
    @click="handleClick"
  >
    <div class="w-full h-32 bg-gray-400 overflow-hidden">
      <img 
        v-if="image" 
        :src="getImageUrl(image)" 
        :alt="title"
        class="w-full h-full object-cover"
      />
      <div v-else class="w-full h-full flex items-center justify-center bg-gray-300">
        <span class="text-gray-500 text-sm">No Image</span>
      </div>
    </div>
    <div class="p-4">
      <div v-if="category" class="mb-2">
        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
          {{ category }}
        </span>
      </div>
      <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ title }}</h4>
      <p class="text-sm text-gray-500 mb-2">{{ date }}</p>
      <p class="text-sm text-gray-600 line-clamp-3">{{ truncatedDescription }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NewsCard',
  props: {
    title: {
      type: String,
      default: 'Judul Berita'
    },
    date: {
      type: String,
      default: 'Tanggal'
    },
    description: {
      type: String,
      default: 'Deskripsi Berita'
    },
    image: {
      type: String,
      default: null
    },
    category: {
      type: String,
      default: null
    },
    slug: {
      type: String,
      default: null
    }
  },
  computed: {
    truncatedDescription() {
      if (!this.description) return ''
      return this.description.length > 150 
        ? this.description.substring(0, 150) + '...' 
        : this.description
    }
  },
  methods: {
    getImageUrl(imagePath) {
      if (!imagePath) return null
      // If it's already a full URL, return as is
      if (imagePath.startsWith('http')) {
        return imagePath
      }
      // Remove any leading slashes to avoid double slashes
      const cleanPath = imagePath.replace(/^\/+/, '')
      // Otherwise, construct the full URL
      return `http://localhost:8000/storage/${cleanPath}`
    },
    handleClick() {
      if (this.slug) {
        // Navigate to news detail page
        this.$router.push(`/berita/${this.slug}`)
      }
    }
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> 