// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/Home.vue";
import AdminDashboard from "@/views/AdminDashboard.vue";
import Beritakominfo from "@/views/Beritakominfo.vue";
import Profil from "@/views/Profil.vue";
import KabarWarga from "@/views/KabarWarga.vue";
import SiaranPers from "@/views/SiaranPers.vue";
import InfoGrafis from "@/views/InfoGrafis.vue";
import LaporanPengaduan from "@/views/LaporanPengaduan.vue";
import LaporanPenerima from "@/views/LaporanPenerima.vue";
import LaporanDetail from "@/views/LaporanDetail.vue";
import SurveiKepuasan from "@/views/SurveiKepuasan.vue";
import SurveiEvaluasi from "@/views/SurveiEvaluasi.vue";
import RadioSuaraMadiun from "@/views/RadioSuaraMadiun.vue";

const routes = [
  
  {
    path: "/",
    redirect: "/home",
  },
  {
    path: "/home",
    name: "home",
    component: Home,
  },
  {
    path: "/admin/dashboard",
    name: "admin.dashboard",
    component: AdminDashboard,
  },
  {
    path: "/berita",
    name: "berita",
    component: Beritakominfo,
  },
  {
    path: "/siaranpers",
    name: "siaranpers",
    component: SiaranPers,
  },
  {
    path: "/infografis",
    name: "infografis",
    component: InfoGrafis,
  },
  {
    path: "/profil",
    name: "profil",
    component: Profil,
  },
  {
    path: "/kabarwarga",
    name: "kabarwarga",
    component: KabarWarga,
  },
  {
    path: '/pengaduan',
    name: 'pengaduan',
    component: LaporanPengaduan,
  },
  {
    path: '/pengaduan/:id',
    name: 'pengaduan.detail',
    component: LaporanDetail,
  },
  {
    path: '/penerima',
    name: 'penerima',
    component: LaporanPenerima,
  },
  {
    path: '/surveikepuasan',
    name: 'kepuasan',
    component: SurveiKepuasan,
  },
  {
    path: '/surveievaluasi',
    name: 'evaluasi',
    component: SurveiEvaluasi,
  },
  {
    path: '/radio',
    name: 'radio',
    component: RadioSuaraMadiun,
  },
  {
    path: '/faq',
    name: 'Faq',
    component: () => import('../views/Faq.vue'),
  },
  {
    path: '/galeri',
    name: 'galeri',
    component: () => import('../views/GalleryPage.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
