<template>
  <section class="container mx-auto mt-12 px-4 py-8 max-w-4xl">
    <h1 class="text-2xl font-semibold mb-2">Layanan Pengaduan - Chat Asisten AI</h1>
    <p class="text-sm text-gray-600 mb-4">
      Asisten ini hanya menjawab topik: PPID, Aduan/Konsultasi Hukum, Kontribusi Berita, Laporan Kekerasan pada Perempuan & Anak,
      Lapor Bapak, Insiden Keamanan Informasi, SP4N LAPOR, Pengaduan, Aduan Konten Negatif, Aduan Nomor Telepon, Aduan Nomor Rekening, Aduan Hoaks.
      Untuk rincian lebih lengkap, kunjungi situs resmi Awak Sigap.
    </p>

    <div class="border rounded-lg p-4 bg-white shadow-sm">
      <div class="h-80 overflow-y-auto space-y-4 mb-4 pr-2" ref="messagesRef">
        <div v-for="(m, idx) in messages" :key="idx" class="flex" :class="m.role === 'user' ? 'justify-end' : 'justify-start'">
          <div :class="[
              'px-3 py-2 rounded-lg max-w-[85%] whitespace-pre-wrap text-sm',
              m.role === 'user' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800'
            ]">
            {{ m.content }}
            <template v-if="m.role === 'assistant' && m.link">
              <div class="mt-2 text-xs">
                Ingin detail lebih lanjut? Lihat di
                <a class="text-blue-600 underline" href="https://awaksigap.madiunkota.go.id/" target="_blank" rel="noopener noreferrer">Awak Sigap</a>.
              </div>
            </template>
          </div>
        </div>
        <div v-if="isTyping" class="text-xs text-gray-500">Asisten sedang menulis…</div>
      </div>

      <form @submit.prevent="onSend" class="flex gap-2">
        <input
          v-model="input"
          type="text"
          placeholder="Tulis pertanyaan Anda..."
          class="flex-1 border rounded-md px-3 py-2"
          :disabled="isTyping"
        />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md" :disabled="isTyping || !input.trim()">
          Kirim
        </button>
      </form>
      <p class="mt-2 text-xs text-gray-500">
        Catatan: Untuk jawaban rinci dan prosedur lengkap, kunjungi
        <a class="text-blue-600 underline" href="https://awaksigap.madiunkota.go.id/" target="_blank" rel="noopener noreferrer">Awak Sigap</a>.
      </p>
    </div>
  </section>
  
</template>

<script setup>
import { ref, nextTick } from 'vue'
import { chatService } from '@/service/api'

const messages = ref([
  { role: 'assistant', content: 'Halo! Saya asisten AI untuk Layanan Pengaduan. Silakan ajukan pertanyaan terkait kategori yang didukung.', link: true }
])
const input = ref('')
const isTyping = ref(false)
const messagesRef = ref(null)

function scrollToBottom() {
  nextTick(() => {
    if (messagesRef.value) {
      messagesRef.value.scrollTop = messagesRef.value.scrollHeight
    }
  })
}

async function onSend() {
  const text = input.value.trim()
  if (!text) return

  messages.value.push({ role: 'user', content: text })
  input.value = ''
  isTyping.value = true
  scrollToBottom()

  try {
    const { data } = await chatService.sendMessage({ message: text })
    messages.value.push({ role: 'assistant', content: data.reply, link: true })
  } catch (e) {
    const serverMsg = e?.response?.data?.reply || e?.message || 'Maaf, terjadi kendala memproses pesan. Coba lagi nanti.'
    messages.value.push({ role: 'assistant', content: serverMsg, link: true })
  } finally {
    isTyping.value = false
    scrollToBottom()
  }
}
</script>

<style scoped>
.container {
  
  max-width: 900px; }
</style>


