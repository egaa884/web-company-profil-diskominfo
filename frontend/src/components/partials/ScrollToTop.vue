<template>
  <transition name="fade">
    <button
      v-show="visible"
      @click="scrollToTop"
      class="scroll-to-top"
      aria-label="Scroll to top"
    >
      <span class="arrow">↑</span>
      <svg class="circle" viewBox="0 0 100 100">
        <defs>
          <linearGradient id="gradStroke" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#2F7B52" />
            <stop offset="100%" stop-color="#0292D8" />
          </linearGradient>
        </defs>
        <circle cx="50" cy="50" r="45" />
      </svg>
    </button>
  </transition>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

const visible = ref(false);

const toggleVisibility = () => {
  visible.value = window.scrollY > 300;
};

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
};

onMounted(() => {
  window.addEventListener("scroll", toggleVisibility);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", toggleVisibility);
});
</script>

<style scoped>
.scroll-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 60px;
  height: 60px;
  background: white;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
  overflow: hidden;
}

.arrow {
  position: absolute;
  font-size: 24px;
  font-weight: bold;
  color: #000; /* panah hitam */
  z-index: 2;
}

/* Lingkaran SVG */
.circle {
  position: absolute;
  width: 100%;
  height: 100%;
  transform: rotate(-90deg); /* mulai dari atas */
}

.circle circle {
  fill: none;
  stroke: url(#gradStroke); /* pakai gradient */
  stroke-width: 6;
  stroke-dasharray: 283; /* keliling lingkaran ~ 2πr */
  stroke-dashoffset: 283;
  transition: stroke-dashoffset 0.6s ease-in-out;
}

.scroll-to-top:hover .circle circle {
  stroke-dashoffset: 0; /* gambar lingkaran penuh */
}

/* Fade animation */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
