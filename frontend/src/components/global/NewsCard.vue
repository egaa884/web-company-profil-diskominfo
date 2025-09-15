<template>
  <div 
    class="news-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer"
    @click="handleClick"
  >
    <div class="w-full h-32 bg-gray-400 overflow-hidden relative">
      <img
        v-if="image"
        :src="getImageUrl(image)"
        :alt="title"
        class="w-full h-full object-cover"
      />
      <div v-else class="w-full h-full flex items-center justify-center bg-gray-300">
        <span class="text-gray-500 text-sm">No Image</span>
      </div>

      <!-- PDF Badge Overlay -->
      <div v-if="hasPdf" class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-lg">
        <div class="flex items-center space-x-1">
          <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
          </svg>
          <span>PDF</span>
        </div>
      </div>
    </div>
    <div class="p-4">
      <div v-if="category" class="mb-2">
        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
          {{ category }}
        </span>
      </div>
      <h4 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ title || 'Judul tidak tersedia' }}</h4>
      <div class="flex items-center justify-between mb-2">
        <p class="text-sm text-gray-500">{{ formatDate(date) }}</p>
        <div class="flex items-center text-sm text-gray-500">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          </svg>
          {{ views }}
        </div>
      </div>
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
      default: ''
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
    },
    views: {
      type: Number,
      default: 0
    },
    hasPdf: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    truncatedDescription() {
      if (!this.description) return '';
      return this.description.length > 150 
        ? this.description.substring(0, 150) + '...' 
        : this.description;
    }
  },
  methods: {
    getImageUrl(imagePath) {
      if (!imagePath) return null;
      if (imagePath.startsWith('http')) {
        return imagePath;
      }
      const cleanPath = imagePath.replace(/^\/+/, '');
      return `http://localhost:8000/storage/${cleanPath}`;
    },
    formatDate(dateString) {
      if (!dateString) return 'Tanggal tidak tersedia';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID', options);
    },
    handleClick() {
      if (this.slug) {
        this.$router.push(`/berita/${this.slug}`);
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