<template>
  <div>
    <Navbar />
    <router-view />
    <Footer />
    <ScrollToTop />

    <!-- Tombol Aksesibilitas -->
    <button 
      class="aksesibilitas-btn" 
      @click="toggleMenu"
      aria-label="Buka menu aksesibilitas"
    >
      ♿
    </button>

    <!-- Panel Menu Aksesibilitas -->
    <transition name="slide">
      <MenuAksebilitas v-if="showMenu" @close="toggleMenu" />
    </transition>
  </div>
</template>

<script>
import Navbar from './components/partials/Navbar.vue'
import Footer from './components/partials/Footer.vue'
import ScrollToTop from './components/partials/ScrollToTop.vue' 
import MenuAksebilitas from './components/partials/MenuAksebilitas.vue'

export default {
  components: {
    Navbar,
    Footer,
    ScrollToTop, 
    MenuAksebilitas
  },
  data() {
    return {
      showMenu: false
    }
  },
  methods: {
    toggleMenu() {
      this.showMenu = !this.showMenu
    }
  }
}
</script>

<style scoped>
.aksesibilitas-btn {
  position: fixed;
  bottom: 100px;
  right: 30px;
  width: 55px;
  height: 55px;
  background: #0059A6;
  color: white;
  font-size: 24px;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
  z-index: 10000;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.2s ease, background 0.3s ease;
}

.aksesibilitas-btn:hover {
  background: #FFD700;
  color: #000;
  transform: scale(1.1);
}

/* Animasi panel */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease, opacity 0.3s ease;
}
.slide-enter-from {
  transform: translateX(100%);
  opacity: 0;
}
.slide-leave-to {
  transform: translateX(100%);
  opacity: 0;
}
.before-enter {
  opacity: 0;
  transform: translateY(40px); /* mulai agak turun */
}

.enter {
  opacity: 1;
  transform: translateY(0);
  transition: all 0.8s ease-out;
}

</style>
