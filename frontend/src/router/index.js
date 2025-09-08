// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/Home.vue";
import AdminDashboard from "@/views/AdminDashboard.vue";
import Beritakominfo from "@/views/Beritakominfo.vue";
import Profil from "@/views/Profil.vue";
import KabarWarga from "@/views/KabarWarga.vue";
import SiaranPers from "@/views/SiaranPers.vue";
import LaporanPengaduan from "@/views/LaporanPengaduan.vue";
import LaporanPenerima from "@/views/LaporanPenerima.vue";
import LaporanDetail from "@/views/LaporanDetail.vue";
import SurveiKepuasan from "@/views/SurveiKepuasan.vue";
import SurveiEvaluasi from "@/views/SurveiEvaluasi.vue";
import RadioSuaraMadiun from "@/views/RadioSuaraMadiun.vue";
import LayananPengaduanAI from "@/views/LayananPengaduanAI.vue";

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
    path: "/berita/:slug",
    name: "berita.detail",
    component: () => import('../views/BeritaDetail.vue'),
  },
  {
    path: "/siaranpers",
    name: "siaranpers",
    component: SiaranPers,
  },
  {
    path: "/profil",
    name: "profil",
    component: Profil,
  },
  {
    path: "/profile/tentang",
    name: "profile.tentang",
    component: () => import('../views/Tentang.vue'),
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
    path: '/layanan-pengaduan',
    name: 'layanan.pengaduan.ai',
    component: LayananPengaduanAI,
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
  {
    path: '/struktur-organisasi-detail',
    name: 'struktur.organisasi.detail',
    component: () => import('../components/profile/StrukturOrganisasiDetail.vue'),
  },
  {
    path: '/standar-pelayanan-detail',
    name: 'standar.pelayanan.detail',
    component: () => import('../components/profile/StandarPelayananDetail.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
