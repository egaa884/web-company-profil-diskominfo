<template>
  <a :href="downloadLink" target="_blank" class="download-button">
    Unduh Aplikasi Radio Suara Madiun
    <svg class="download-icon" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z" /></svg>
  </a>
</template>

<script setup>
const downloadLink = 'https://play.google.com/store/apps/details?id=com.kominfo.lppl_93fm_suara_madiun&hl=id'; 
</script>

<style scoped>
.download-button {
  background-color: #ffffff;
  color: #194a8f; 
  padding: 27px 60px; 
  border-radius: 20px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  transition: all 0.2s ease-in-out;
  display: flex;
  align-items: center;
  gap: 10px;
}
.download-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 7px 20px rgba(0, 0, 0, 0.3);
}
.download-button:active {
  transform: translateY(2px);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.download-icon {
  fill: #194a8f;
  width: 24px;
  height: 24px;
}
</style>