<template>
  <nav :class="['floating-navbar', { 
            'at-top': isAtTop,
            'scrolled-oval': isScrolledOval,
            'is-visible-onload': isVisible // Tetap pertahankan untuk animasi awal
          }]" ref="navbarRef">
    <div class="nav-content">
      <img src="/img/logo-navbar.png" alt="Logo" class="logo" />

      <ul class="nav-links desktop-menu">
        <li v-for="item in navItems" :key="item.name"
            @mouseenter="item.type === 'dropdown' && showDropdown(item.name)"
            @mouseleave="item.type === 'dropdown' && hideDropdown()">
          <a :href="item.link || '#'" :class="{ 'has-dropdown-active': activeDropdown === item.name }">
            {{ item.name }}
            <span v-if="item.type === 'dropdown'" class="dropdown-arrow"></span>
          </a>

          <div v-if="item.type === 'dropdown' && activeDropdown === item.name" 
               class="dropdown-menu"
               @mouseenter="showDropdown(item.name)" 
               @mouseleave="hideDropdown()">
            <div class="dropdown-grid">
              <div v-for="subItem in item.items" :key="subItem.name" class="dropdown-item">
                <router-link v-if="isInternalLink(subItem.link)" :to="subItem.link" @click="hideDropdown()">
                  {{ subItem.name }}
                </router-link>
                <a v-else :href="subItem.link" target="_blank" rel="noopener noreferrer">
                  {{ subItem.name }}
                </a>
              </div>
            </div>
          </div>
        </li>
      </ul>

      <div class="search-wrapper desktop-search">
        <input type="text" placeholder="Cari..." class="search-input" />
      </div>

      <button class="menu-toggle" @click="isMenuOpen = !isMenuOpen">
        <span class="hamburger-icon" :class="{ open: isMenuOpen }"></span>
      </button>
    </div>

    <div v-if="isMenuOpen" class="sidebar-overlay" @click="isMenuOpen = false"></div>

    <ul class="nav-links mobile-menu" :class="{ 'mobile-open': isMenuOpen }">
      <li v-for="item in navItems" :key="item.name">
        <a v-if="item.type === 'link'" :href="item.link" @click="isMenuOpen = false">{{ item.name }}</a>
        <div v-else class="mobile-dropdown-parent">
          <a href="#" @click.prevent="activeDropdown = activeDropdown === item.name ? null : item.name"
              :class="{ 'mobile-dropdown-active': activeDropdown === item.name }">
            {{ item.name }}
            <span class="dropdown-arrow" :class="{ 'open': activeDropdown === item.name }"></span>
          </a>
          <ul v-if="activeDropdown === item.name" class="mobile-submenu">
            <li v-for="subItem in item.items" :key="subItem.name">
              <router-link v-if="isInternalLink(subItem.link)" :to="subItem.link" @click="isMenuOpen = false">
                {{ subItem.name }}
              </router-link>
              <a v-else :href="subItem.link" target="_blank" rel="noopener noreferrer" @click="isMenuOpen = false">
                {{ subItem.name }}
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="search-wrapper mobile-search">
        <input type="text" placeholder="Cari..." class="search-input" />
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isVisible = ref(false)
const isAtTop = ref(true)
const isScrolledOval = ref(false) 
const isMenuOpen = ref(false)
const navbarRef = ref(null)

const activeDropdown = ref(null)

let lastScrollY = 0
let dropdownHoverTimer = null

const isInternalLink = (link) => {
  return link && (link.startsWith('/') || link.startsWith('#'))
}

const navItems = ref([
  { name: 'Beranda', link: '/home', type: 'link' },
  {
    name: 'Berita',
    type: 'dropdown',
    items: [
      { name: 'Berita Kominfo Madiun', link: '/berita' },
      { name: 'Madiun Today', link: 'https://madiuntoday.id/' },
      { name: 'Kabar Warga', link: '/kabarwarga' },
      { name: 'Arsip Berita', link: 'https://kominfo.madiunkota.go.id/arsipberita' },
      { name: 'Radio Suara Madiun', link: 'https://kominfo.madiunkota.go.id/radiosuara' },
      { name: 'Siaran Pers Madiun', link: '/siaranpers' },
      { name: 'Infografis Madiun', link: '/infografis' }
    ]
  },
  { name: 'Profil', link: '/profil', type: 'link' },
  { name: 'Layanan Pengaduan', link: 'https://awaksigap.madiunkota.go.id/', type: 'link' },
  { name: 'FaQ', link: '/faq', type: 'link' },
  {
    name: 'Informasi Publik',
    type: 'dropdown',
    items: [
      { name: 'PPID Kota Madiun', link: 'https://ppid.madiunkota.go.id/' },
      { name: 'Radio Suara Madiun', link: '#info-sertamerta' },
      { name: 'CSIRT Kota Madiun', link: '#info-setiapsaat' },
    ]
  },
  {
    name: 'Publikasi',
    type: 'dropdown',
    items: [
      { name: 'Laporan Pengaduan Pelayanan Publik', link: '#majalah' },
      { name: 'Laporan Penerima Layanan Publik', link: '#buletin' },
      { name: 'Survei Kepuasan Masyarakat', link: '#infografis' },
      { name: 'Survei Evaluasi Pelayanan Publik', link: '#data-terkini' }
    ]
  }
])

const handleScroll = () => {
  const currentScrollY = window.scrollY
  const SCROLL_THRESHOLD_ACTIVATION = 10; 

  if (currentScrollY <= SCROLL_THRESHOLD_ACTIVATION) {
    isAtTop.value = true;
    isScrolledOval.value = false;
  } else { 
    isAtTop.value = false;
    isScrolledOval.value = true;
  }
  
  lastScrollY = currentScrollY;
}

const showDropdown = (menuName) => {
  clearTimeout(dropdownHoverTimer)
  activeDropdown.value = menuName
}

const hideDropdown = () => {
  dropdownHoverTimer = setTimeout(() => {
    activeDropdown.value = null
  }, 300);
}

watch(isMenuOpen, (newValue) => {
  document.body.style.overflow = newValue ? 'hidden' : ''
  if (!newValue) {
    activeDropdown.value = null;
  }
})

onMounted(() => {
  setTimeout(() => {
    isVisible.value = true;
  }, 100);

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll(); 
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
  document.body.style.overflow = '';
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Poppins:wght@600;800&display=swap');

.floating-navbar {
  position: fixed;
  z-index: 1000;
  display: flex;
  justify-content: center;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
  pointer-events: auto;
  
  /* Transisi global untuk semua perubahan state (termasuk top, left, width, border-radius, transform, background, box-shadow, backdrop-filter) */
  transition: 
    top 0.4s cubic-bezier(0.4, 0, 0.2, 1),
    left 0.4s cubic-bezier(0.4, 0, 0.2, 1),
    width 0.4s cubic-bezier(0.4, 0, 0.2, 1),
    border-radius 0.4s cubic-bezier(0.4, 0, 0.2, 1),
    transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
    background 0.4s cubic-bezier(0.4, 0, 0.2, 1),
    box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1),
    backdrop-filter 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  
  /* State Awal (seperti at-top tapi lebih umum) */
  opacity: 0; /* Mulai tersembunyi */
  transform: translateY(-100%); /* Geser ke atas saat load */
  background: transparent; 
  box-shadow: none; 
  top: 0;
  left: 0;
  width: 100%;
  border-radius: 0;
  padding: 20px 5%;
  backdrop-filter: blur(0px); 
}

.floating-navbar.is-visible-onload {
  opacity: 1;
  transform: translateY(0); 
}

/* State 1: Kotak, Full-width (saat di paling atas) */
.floating-navbar.at-top {
  top: 0;
  left: 0;
  width: 100%;
  border-radius: 0;
  padding: 20px 5%;
  background: rgba(255, 255, 255, 0.1); 
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
  opacity: 1;
  transform: translateY(0); 
  backdrop-filter: blur(2px);
}

/* State 2: Oval, Kecil (saat di-scroll) */
.floating-navbar.scrolled-oval {
  top: 1.5rem;
  left: 50%;
  transform: translateX(-50%);
  width: 90%;
  max-width: 1600px;
  border-radius: 50px;
  padding: 8px 24px;
  background: rgba(255, 255, 255, 0.95);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  opacity: 1;
  backdrop-filter: blur(2px);
}

.nav-content {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 1600px;
  justify-content: space-between;
}

.logo {
  height: 40px;
  width: auto;
  transition: height 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
}

.floating-navbar.scrolled-oval .logo {
  height: 30px;
}

.nav-links.desktop-menu {
  display: flex;
  gap: 30px;
  list-style: none;
  margin: 0;
  padding: 0;
  align-items: center;
  flex-wrap: wrap;
  margin-left: auto;
  margin-right: 20px;
}

/* Gaya untuk setiap item LI di menu desktop */
.nav-links.desktop-menu > li {
  position: relative; 
  padding: 10px 0; 
}

.nav-links a {
  text-decoration: none;
  color: #333;
  font-weight: 500;
  transition: color 0.3s ease;
  display: flex;
  align-items: center;
  gap: 5px;
}

.nav-links a:hover,
.nav-links a.has-dropdown-active {
  color: #007bff;
}

/* Panah dropdown */
.dropdown-arrow {
  display: inline-block;
  width: 0;
  height: 0;
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid #333;
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-links a:hover .dropdown-arrow,
.nav-links a.has-dropdown-active .dropdown-arrow {
  border-top-color: #007bff;
  transform: rotate(180deg);
}

/* Dropdown Menu untuk Desktop */
.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%) translateY(20px);
  opacity: 0;
  visibility: hidden;
  min-width: 250px;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 8px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  padding: 20px;
  transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
  pointer-events: none;
  z-index: 10;
  white-space: nowrap;
  backdrop-filter: blur(5px);
}

/* Saat LI di-hover, tampilkan dropdown */
.nav-links.desktop-menu > li:hover .dropdown-menu {
  opacity: 1;
  visibility: visible;
  transform: translateX(-50%) translateY(0);
  pointer-events: auto;
}

.dropdown-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 10px;
}

/* Gaya untuk item dalam dropdown */
.dropdown-item a,
.dropdown-item a.router-link-active {
  padding: 8px 10px;
  display: block;
  color: #555;
  font-weight: normal;
  transition: background-color 0.2s, color 0.2s;
  border-radius: 4px;
  text-decoration: none;
}

.dropdown-item a:hover,
.dropdown-item a.router-link-active:hover {
  background-color: #f0f0f0;
  color: #007bff;
}

.search-wrapper.desktop-search {
  display: flex;
  align-items: center;
}

.search-input {
  padding: 6px 14px;
  border-radius: 20px;
  border: 1px solid #ccc;
  outline: none;
  font-size: 14px;
  transition: all 0.2s ease;
  background: rgba(255, 255, 255, 0.2);
  color: #333;
}

.search-input::placeholder {
  color: #666;
}

.search-input:focus {
  border-color: #007bff;
  background: rgba(255, 255, 255, 0.4);
}

.nav-links.mobile-menu,
.search-wrapper.mobile-search {
  display: none;
}

.menu-toggle {
  display: none;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  width: 30px;
  height: 24px;
  position: relative;
  z-index: 1001;
  margin-left: auto;
}

.hamburger-icon {
  display: block;
  width: 100%;
  height: 3px;
  background-color: #333;
  position: absolute;
  left: 0;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.hamburger-icon::before,
.hamburger-icon::after {
  content: '';
  display: block;
  width: 100%;
  height: 3px;
  background-color: #333;
  position: absolute;
  left: 0;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.hamburger-icon::before {
  top: -8px;
}

.hamburger-icon::after {
  top: 8px;
}

.hamburger-icon.open {
  background-color: transparent;
  transform: rotate(45deg);
}

.hamburger-icon.open::before {
  transform: translateY(8px) rotate(90deg);
}

.hamburger-icon.open::after {
  transform: translateY(-8px) rotate(90deg);
}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
  transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@media (max-width: 992px) {
  /* Untuk mobile, Navbar selalu kotak dan full-width */
  /* Di mobile, kita akan mempertahankan perilaku yang lebih sederhana atau tetap transparan penuh */
  .floating-navbar,
  .floating-navbar.at-top,
  .floating-navbar.scrolled-oval {
    padding: 15px 25px;
    border-radius: 0;
    width: 100%;
    left: 0;
    top: 0;
    transform: translateY(0);
    background: rgba(255, 255, 255, 0.9); 
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    backdrop-filter: blur(8px);
    transition: all 0.3s ease; 
  }

  .nav-content {
    justify-content: space-between;
  }

  .nav-links.desktop-menu,
  .search-wrapper.desktop-search {
    display: none;
  }

  /* Tampilkan menu mobile */
  .nav-links.mobile-menu,
  .search-wrapper.mobile-search {
    display: flex; 
  }

  .nav-links.mobile-menu {
    position: fixed;
    top: 0;
    right: -280px; 
    width: 280px;
    height: 100vh;
    background: rgba(255, 255, 255, 0.05); 
    backdrop-filter: blur(15px);
    flex-direction: column;
    padding: 80px 20px 20px 20px;
    box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
    transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 999;
    align-items: flex-start;
    gap: 20px;
    overflow-y: auto;
  }

  .nav-links.mobile-open {
    right: 0;
  }

  .nav-links.mobile-menu li {
    width: 100%;
    list-style: none;
  }

  .nav-links.mobile-menu a {
    display: block;
    padding: 10px 0;
    font-size: 1.1rem;
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
  }
  .nav-links.mobile-menu a:hover {
    color: #007bff;
  }

  /* Gaya untuk dropdown di Mobile */
  .mobile-dropdown-parent {
    width: 100%;
  }
  .mobile-dropdown-parent > a {
    font-weight: bold;
    color: #333;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .mobile-dropdown-parent > a .dropdown-arrow {
    border-top-color: #333;
    transform: rotate(0deg);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .mobile-dropdown-parent > a.mobile-dropdown-active .dropdown-arrow {
    transform: rotate(180deg);
  }

  .mobile-submenu {
    list-style: none;
    padding: 10px 0 0 20px;
    margin: 0;
  }
  .mobile-submenu li a,
  .mobile-submenu li a.router-link-active {
    font-size: 1rem;
    color: #666;
    padding: 8px 0;
    text-decoration: none;
  }
  .mobile-submenu li a:hover,
  .mobile-submenu li a.router-link-active:hover {
    color: #007bff;
  }

  .search-wrapper.mobile-search {
    margin: 20px 0;
    width: 100%;
  }

  .search-input {
    width: 100%;
    background: rgba(255, 255, 255, 0.1);
    color: #333;
    border: 1px solid rgba(0, 0, 0, 0.2);
  }

  .search-input::placeholder {
    color: #666;
  }

  .search-input:focus {
    background: rgba(255, 255, 255, 0.3);
    border-color: #007bff;
  }

  .menu-toggle {
    display: block;
  }
}

/* Dark Mode - Sesuaikan warna untuk dropdown */
@media (prefers-color-scheme: dark) {
  .floating-navbar,
  .floating-navbar.at-top, 
  .floating-navbar.scrolled-oval { 
    background: rgba(30, 30, 30, 0.8); 
  }

  .nav-links.mobile-menu {
    background: rgba(0, 0, 0, 0.2);
  }

  .nav-links a {
    color: #f0f0f0;
  }
  .nav-links a:hover,
  .nav-links a.has-dropdown-active {
    color: #90caf9;
  }

  .dropdown-arrow {
    border-top-color: #f0f0f0;
  }
  .nav-links a:hover .dropdown-arrow,
  .nav-links a.has-dropdown-active .dropdown-arrow {
    border-top-color: #90caf9;
  }

  .dropdown-menu {
    background: #282828;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
  }
  .dropdown-item a {
    color: #ccc;
  }
  .dropdown-item a:hover {
    background-color: #3a3a3a;
    color: #90caf9;
  }


  .search-input {
    background: rgba(50, 50, 50, 0.4);
    color: #f0f0f0;
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  .search-input::placeholder {
    color: #ccc;
  }

  .search-input:focus {
    background: rgba(70, 70, 70, 0.6);
    border-color: #90caf9;
  }

  .hamburger-icon,
  .hamburger-icon::before,
  .hamburger-icon::after {
    background-color: #f0f0f0;
  }

  /* Dark mode untuk mobile menu dropdown */
  .nav-links.mobile-menu a {
    color: #f0f0f0;
  }
  .mobile-dropdown-parent > a {
    color: #f0f0f0;
  }
  .mobile-dropdown-parent > a .dropdown-arrow {
    border-top-color: #f0f0f0;
  }
  .mobile-submenu li a {
    color: #bbb;
  }
  .mobile-submenu li a:hover {
    color: #90caf9;
  }
  .search-input {
    background: rgba(50, 50, 50, 0.4);
    color: #f0f0f0;
    border: 1px solid rgba(255, 255, 255, 0.3);
  }
  .search-input::placeholder {
    color: #ccc;
  }
  .search-input:focus {
    background: rgba(70, 70, 70, 0.6);
    border-color: #90caf9;
  }
}
</style>