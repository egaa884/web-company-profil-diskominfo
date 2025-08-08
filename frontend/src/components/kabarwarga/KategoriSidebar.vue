<template>
  <div class="sidebar">
    <h2>Kategori</h2>
    <ul>
      <li v-for="category in categories" :key="category">{{ category }}</li>
    </ul>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
const props = defineProps({ categories: Array });
</script>

<style scoped>
.sidebar { width: 280px; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.sidebar ul { list-style: none; padding: 0; }
.sidebar li { padding: 10px 0; border-bottom: 1px solid #ccc; font-size: 1rem; }
.sidebar li:last-child { border-bottom: none; }
</style>