<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import HeroSection from '../components/landing/HeroSection.vue';
import AboutSection from '../components/landing/AboutSection.vue';
import Kerjasama from "../components/landing/Kerjasama.vue";
import NewsSection from "@/components/landing/NewsSection.vue";
import ServiceSection from "@/components/landing/ServiceSection.vue";
import BannerLinkMadiun from "@/components/landing/BannerLinkMadiun.vue";

// state untuk simpan data
const profils = ref([]);
const agendas = ref([]);

// ambil data ketika komponen muncul
onMounted(() => {
  fetchProfils();
  fetchAgendas();
});

const fetchProfils = () => {
  axios
    .get("http://127.0.0.1:8000/api/profil")
    .then((response) => {
      profils.value = response.data;
    })
    .catch((error) => console.error(error));
};

const fetchAgendas = () => {
  axios
    .get("http://127.0.0.1:8000/api/agenda")
    .then((response) => {
      agendas.value = response.data;
    })
    .catch((error) => console.error(error));
};
</script>

<template>
  <HeroSection />
  <AboutSection />
  <NewsSection />
  <ServiceSection />
  <Kerjasama />
  <BannerLinkMadiun />
</template>

<style scoped>
</style>
