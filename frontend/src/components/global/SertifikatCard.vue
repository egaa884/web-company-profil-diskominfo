<template>
  <div class="flip-card">
    <div class="flip-card-inner">
      <!-- Sisi depan -->
      <div class="flip-card-front">
        <img :src="image" :alt="title" />
      </div>

      <!-- Sisi belakang -->
      <div class="flip-card-back">
        <div class="text-center">
          <h2 class="text-xl font-semibold mb-4">{{ title }}</h2>
          <button
            @click="openModal"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700"
          >
            Lihat Full
          </button>
          <a
            :href="pdf"
            download
            class="ml-4 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700"
          >
            Download PDF
          </a>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <teleport to="body">
      <transition name="fade">
        <div
          v-if="showModal"
          class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
          @click.self="closeModal"
        >
          <!-- overlay -->
          <div class="absolute inset-0 bg-black/80"></div>

          <!-- tombol close -->
          <button
            @click="closeModal"
            class="absolute top-5 right-5 text-white text-3xl font-bold hover:text-red-400 z-50"
          >
            ✕
          </button>

          <!-- konten -->
          <div class="relative z-40 animate-fadeIn flex flex-col items-center gap-4">
            <img
              :src="image"
              :alt="title"
              class="max-w-[95vw] max-h-[90vh] object-contain rounded-xl shadow-2xl"
            />
            <a
              :href="pdf"
              download
              class="px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700"
            >
              Download PDF
            </a>
          </div>
        </div>
      </transition>
    </teleport>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

defineProps({
  image: { type: String, required: true },
  pdf: { type: String, required: true },
  title: { type: String, default: "Sertifikat" },
});

const showModal = ref(false);

const openModal = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

// Tutup dengan ESC
const handleEsc = (e) => {
  if (e.key === "Escape") closeModal();
};

onMounted(() => {
  window.addEventListener("keydown", handleEsc);
});
onBeforeUnmount(() => {
  window.removeEventListener("keydown", handleEsc);
});
</script>

<style scoped>
/* Fade */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Flip Card */
.flip-card {
  width: 600px;
  height: 400px;
  margin: 20px auto;
  perspective: 1000px;
}
.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  transition: transform 2s ease; /* perlambat flip */
  transform-style: preserve-3d;
}
.flip-card:hover .flip-card-inner {
  transform: rotateY(180deg);
}
.flip-card-front,
.flip-card-back {
  position: absolute;
  inset: 0;
  backface-visibility: hidden;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  display: flex;
  justify-content: center;
  align-items: center;
}
.flip-card-front {
  position: relative;
}
.flip-card-front img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Efek shine/glow */
.flip-card-front::before {
  content: "";
  position: absolute;
  top: 0;
  left: -75%;
  width: 50%;
  height: 100%;
  background: linear-gradient(
    120deg,
    rgba(255, 255, 255, 0.1) 0%,
    rgba(255, 255, 255, 0.6) 50%,
    rgba(255, 255, 255, 0.1) 100%
  );
  transform: skewX(-20deg);
}
.flip-card:hover .flip-card-front::before {
  animation: shine 2s ease forwards; /* sesuaikan dengan durasi flip */
}

@keyframes shine {
  0% {
    left: -75%;
  }
  100% {
    left: 125%;
  }
}

/* Back side */
.flip-card-back {
  background: #fff;
  transform: rotateY(180deg);
}

/* Animasi modal */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(12px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fadeIn {
  animation: fadeIn 0.35s ease both;
}
</style>
