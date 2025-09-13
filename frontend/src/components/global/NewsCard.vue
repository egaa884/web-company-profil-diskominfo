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
      type: String, // Tambahkan prop 'slug'
      default: null
    },
    views: {
      type: Number,
      default: 0
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