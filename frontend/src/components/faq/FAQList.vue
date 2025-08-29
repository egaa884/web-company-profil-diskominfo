<template>
  <div class="faq-list">
    <FAQItem v-for="(faq, idx) in faqs" :key="idx" :title="faq.title" :question="faq.question" :answer="faq.answer" />
  </div>
</template>

<script setup>
import FAQItem from './FAQItem.vue'

defineProps({
  faqs: {
    type: Array,
    required: true
  }
})
</script>

<style scoped>
.faq-list {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}
</style>