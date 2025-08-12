<template>
  <transition-group name="small-fade" tag="div" class="small-images-grid-container">
    <div v-for="image in images" :key="image.id" class="small-image-card" @click="$emit('select-small-image', image.id)">
      <img :src="image.url" :alt="image.alt" class="small-image" />
      <div class="image-overlay">
        <h4 class="image-title">{{ image.title }}</h4>
      </div>
    </div>
  </transition-group>
</template>

<script>
export default {
  name: 'SmallImageGrid',
  props: {
    images: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
};
</script>

<style scoped>
.small-images-grid-container {
  display: contents; /* Penting untuk mempertahankan layout grid dari parent */
}

/* --- Transisi Animasi --- */
.small-fade-enter-active,
.small-fade-leave-active {
  transition: all 0.5s ease;
}
.small-fade-enter-from {
  opacity: 0;
  transform: scale(0.8);
}
.small-fade-leave-to {
  opacity: 0;
  transform: scale(0.8);
}
.small-fade-move {
  transition: transform 0.5s ease;
}

.small-image-card {
  position: relative;
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.small-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.small-image-card:hover .small-image {
  transform: scale(1.05);
}

.image-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
  color: #fff;
  padding: 1rem;
}

.image-title {
  font-size: 1rem;
  font-weight: bold;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>