// src/router/index.js
import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/Home.vue";
import AdminDashboard from "@/views/AdminDashboard.vue";
import Beritakominfo from "@/views/Beritakominfo.vue";
import Profil from "@/views/Profil.vue";
import KabarWarga from "@/views/KabarWarga.vue";
import SiaranPers from "@/views/SiaranPers.vue";
import InfoGrafis from "@/views/InfoGrafis.vue";

const routes = [
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
