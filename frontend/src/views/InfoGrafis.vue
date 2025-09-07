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
import { ref, onMounted } from 'vue';
import InfographicSidebar from '../components/infografis/SideBar.vue';
import InfographicCard from '../components/infografis/Card.vue';
import { beritaService } from '../service/api.js';

// Reactive data
const categories = ref([]);
const infographics = ref([]);
const loading = ref(true);
const error = ref(null);

// Fetch infografis data from backend
const fetchInfografis = async () => {
  try {
    loading.value = true;
    error.value = null;

    const response = await beritaService.getBeritaByCategory('Infografis Madiun');
    const data = response.data.data || response.data;

    // Transform data to match component structure
    infographics.value = data.map(item => ({
      id: item.id,
      imageSrc: item.gambar_url || '/img/default-infografis.jpg',
      category: item.category,
      day: new Date(item.created_at).getDate().toString(),
      month: new Date(item.created_at).toLocaleDateString('id-ID', { month: 'short' }),
      year: new Date(item.created_at).getFullYear().toString(),
      title: item.judul,
      admin: 'Admin',
      publishedDate: new Date(item.created_at).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
      }),
      pdfUrl: item.pdf_url || null
    }));

  } catch (err) {
    console.error('Error fetching infografis:', err);
    error.value = 'Gagal memuat data infografis';
    infographics.value = [];
  } finally {
    loading.value = false;
  }
};

// Fetch categories
const fetchCategories = async () => {
  try {
    const response = await beritaService.getCategories();
    categories.value = response.data || [];
  } catch (err) {
    console.error('Error fetching categories:', err);
    categories.value = [];
  }
};

// Initialize data on component mount
onMounted(() => {
  fetchInfografis();
  fetchCategories();
});
</script>

<style scoped>

/* Anda bisa menambahkan gaya CSS tambahan di sini jika diperlukan */
</style>