<template>
  <div class="large-image-card">
    <transition name="slide-left" mode="out-in">
      <div :key="image.id">
        <img :src="image.url" :alt="image.alt" class="large-image" />
        <div class="image-overlay">
          <h3 class="image-title">{{ image.title }}</h3>
          <p class="image-description">{{ image.description }}</p>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  name: 'LargeImage',
  props: {
    image: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
};
</script>

<style scoped>
.large-image-card {
  grid-column: span 2;
  grid-row: span 2;
  position: relative;
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* --- Transisi Animasi --- */
.slide-left-enter-active,
.slide-left-leave-active {
  transition: all 0.6s cubic-bezier(0.86, 0, 0.07, 1);
  position: absolute;
  width: 100%;
  height: 100%;
}
.slide-left-enter-from {
  opacity: 0;
  transform: translateX(-100%);
}
.slide-left-leave-to {
  opacity: 0;
  transform: translateX(100%);
}

.large-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.large-image-card:hover .large-image {
  transform: scale(1.05);
}

.image-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
  color: #fff;
  padding: 1.5rem;
  transition: opacity 0.3s ease;
}

.image-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.image-description {
  font-size: 1rem;
  margin-top: 0.5rem;
}
</style>