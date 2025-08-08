<template>
  <section class="news-section">
    <div class="container">
      <h2 class="section-title">Berita Terkini</h2>

      <!-- Loading state -->
      <div v-if="loading" class="news-grid">
        <div v-for="i in 3" :key="i" class="news-card animate-pulse">
          <div class="news-image bg-gray-300"></div>
          <div class="news-content">
            <div class="h-4 bg-gray-300 rounded mb-2"></div>
            <div class="h-3 bg-gray-300 rounded w-1/2"></div>
          </div>
        </div>
      </div>

      <!-- News content -->
      <div v-else-if="newsItems.length > 0" class="news-grid">
        <div
          v-for="(news, index) in newsItems"
          :key="news.id || index"
          class="news-card"
          :class="{ 'is-visible': news.isVisible }"
          :style="{ 'transition-delay': news.delay }"
          @click="handleNewsClick(news)"
        >
          <img
            v-if="news.gambar"
            :src="getImageUrl(news.gambar)"
            :alt="news.judul"
            class="news-image"
          />
          <div
            v-else
            class="news-image bg-gray-300 flex items-center justify-center"
          >
            <span class="text-gray-500 text-sm">No Image</span>
          </div>
          <div class="news-content">
            <h3 class="news-title">{{ news.judul }}</h3>
            <p class="news-date">{{ formatDate(news.created_at) }}</p>
            <p v-if="news.category" class="news-category">
              {{ news.category }}
            </p>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-else class="text-center py-8">
        <p class="text-gray-500">Tidak ada berita terkini saat ini.</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { beritaService } from "@/service/api.js";

// Reactive data
const newsItems = ref([]);
const loading = ref(false);
let observers = [];

// Fetch news from API
const fetchNews = async () => {
  try {
    loading.value = true;
    const response = await beritaService.getLatestBerita();
    const newsData = response.data || [];

    // Transform data to match component structure
    newsItems.value = newsData.map((news, index) => ({
      id: news.id,
      judul: news.judul,
      gambar: news.gambar,
      created_at: news.created_at,
      category: news.category,
      slug: news.slug,
      isVisible: false,
      delay: `${index * 0.3}s`,
    }));
  } catch (error) {
    console.error("Error fetching news:", error);
    // Fallback to dummy data if API fails
  } finally {
    loading.value = false;
  }
};

// Format date
const formatDate = (dateString) => {
  if (!dateString) return "";
  const date = new Date(dateString);
  return date.toLocaleDateString("id-ID", {
    day: "numeric",
    month: "long",
    year: "numeric",
  });
};

// Get image URL
const getImageUrl = (imagePath) => {
  if (!imagePath) return null;
  // If it's already a full URL, return as is
  if (imagePath.startsWith("http")) {
    return imagePath;
  }
  // Otherwise, construct the full URL
  return `http://localhost:8000/storage/${imagePath}`;
};

// Handle news click
const handleNewsClick = (news) => {
  if (news.slug) {
    // Navigate to news detail page
    window.location.href = `/berita/${news.slug}`;
  }
};

onMounted(() => {
  // Fetch news data
  fetchNews();

  // Set up intersection observers after data is loaded
  setTimeout(() => {
    const cards = document.querySelectorAll(".news-card");

    cards.forEach((card, index) => {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              // Kartu masuk ke dalam viewport
              if (newsItems.value[index]) {
                newsItems.value[index].isVisible = true;
              }
            } else {
              // Kartu keluar dari viewport
              if (newsItems.value[index]) {
                newsItems.value[index].isVisible = false;
              }
            }
          });
        },
        {
          root: null,
          rootMargin: "0px",
          threshold: 0.1,
        }
      );
      observer.observe(card);
      observers.push(observer);
    });
  }, 100); // Small delay to ensure DOM is ready
});

onBeforeUnmount(() => {
  // Putuskan semua observer saat komponen dilepas
  observers.forEach((observer) => observer.disconnect());
});
</script>

<style scoped>
/* Gaya yang sudah ada tetap sama */
.news-section {
  background-color: #f8f8f8;
  padding: 80px 16px;
  position: relative;
  z-index: 1;
  box-sizing: border-box;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.section-title {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 48px;
  text-align: center;
}

.news-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}

@media (min-width: 640px) {
  .news-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .news-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.news-card {
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.5s ease,
    transform 0.5s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  cursor: pointer;

  /* Kondisi awal untuk animasi */
  opacity: 0;
  transform: translateY(50px);
}

.news-card.is-visible {
  opacity: 1;
  transform: translateY(0);
}

.news-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.news-image {
  height: 192px;
  background-color: #ccc;
  color: #555;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  object-fit: cover;
  width: 100%;
}

.news-content {
  padding: 24px;
}

.news-title {
  font-size: 18px;
  font-weight: 600;
  color: #222;
  margin-bottom: 8px;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.news-date {
  font-size: 14px;
  color: #777;
  margin-bottom: 4px;
}

.news-category {
  font-size: 12px;
  color: #2563eb;
  background-color: #eff6ff;
  padding: 2px 8px;
  border-radius: 12px;
  display: inline-block;
}

@media (max-width: 768px) {
  .news-section {
    padding: 60px 16px;
  }
  .section-title {
    font-size: 24px;
    margin-bottom: 30px;
  }
}

@media (max-width: 480px) {
  .news-section {
    padding: 40px 16px;
  }
  .section-title {
    font-size: 20px;
  }
}

/* Loading animation */
.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}
</style>
