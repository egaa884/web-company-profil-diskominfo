<template>
  <div class="faq-container">
    <FAQHeader />
    <FAQList :faqs="faqs" />
  </div>
</template>

<script setup>
import FAQHeader from '../components/faq/FAQHeader.vue'
import FAQList from '../components/faq/FAQList.vue'
import { onMounted, ref } from 'vue'
import { faqService } from '../service/api'

const faqs = ref([])

onMounted(async () => {
  try {
    const { data } = await faqService.getFaqs()
    // Backend returns [{ id, title, question, answer, category? }]
    faqs.value = Array.isArray(data) ? data : []
  } catch (e) {
    console.error('Gagal memuat FAQ:', e)
  }
})
</script>

<style scoped>
.faq-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem 1rem;

}
</style>