<template>
  <div class="faq-item">
    <div class="faq-question" @click="toggle">
      <span>{{ question }}</span>
      <span class="arrow" :class="{ 'rotated': open }">▼</span>
    </div>
    <transition name="slide">
      <div v-if="open" class="faq-answer">
        <pre>{{ answer }}</pre>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref } from 'vue'
const props = defineProps({
  question: String,
  answer: String
})
const open = ref(false)
function toggle() {
  open.value = !open.value
}
</script>

<style scoped>
.faq-item {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  background: #fafbfc;
  box-shadow: 0 1px 2px rgba(0,0,0,0.03);
  overflow: hidden;
}
.faq-question {
  cursor: pointer;
  padding: 1rem;
  font-weight: 500;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: linear-gradient(to right, #29166F, #01458E, #0093DD);
  color: white;
  transition: all 0.3s ease;
}
.faq-question:hover {
  background: linear-gradient(to right, #1a0f4a, #013a7a, #0078b8);
}
.faq-answer {
  padding: 1rem;
  border-top: 1px solid #e0e0e0;
  background: #fff;
}
.arrow {
  font-size: 1.2em;
  transition: transform 0.3s ease;
}
.arrow.rotated {
  transform: rotate(180deg);
}
pre {
  white-space: pre-wrap;
  font-family: inherit;
  margin: 0;
}
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}
.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
.slide-enter-to,
.slide-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style>