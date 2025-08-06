<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const dashboard = ref(null)

onMounted(async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/admin/dashboard', {
      headers: {
        Authorization: `Bearer YOUR_TOKEN_HERE`
      }
    })
    dashboard.value = res.data
  } catch (err) {
    console.error(err)
  }
})
</script>

<template>
  <div>
    <h1>Dashboard Admin</h1>
    <div v-if="dashboard">
      <p>Total Berita: {{ dashboard.total_berita }}</p>
      <p>Total Agenda: {{ dashboard.total_agenda }}</p>
      <p>Total Profil: {{ dashboard.total_profil }}</p>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>
  </div>
</template>

<style scoped>
h1 {
  font-size: 24px;
  margin-bottom: 1rem;
}
</style>
