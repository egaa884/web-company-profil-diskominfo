<template>
  <div class="comments-section bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Komentar</h3>

    <!-- Comment Form -->
    <div class="comment-form mb-8 p-4 bg-gray-50 rounded-lg">
      <h4 class="text-lg font-semibold text-gray-700 mb-4">Tinggalkan Komentar</h4>
      <form @submit.prevent="submitComment" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
            <input
              v-model="commentForm.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Masukkan nama Anda"
            >
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              v-model="commentForm.email"
              type="email"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Masukkan email Anda (opsional)"
            >
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Komentar *</label>
          <textarea
            v-model="commentForm.comment"
            required
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Tulis komentar Anda..."
          ></textarea>
        </div>
        <button
          type="submit"
          :disabled="submitting"
          class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
        >
          <span v-if="submitting">Mengirim...</span>
          <span v-else>Kirim Komentar</span>
        </button>
      </form>
    </div>

    <!-- Success/Error Messages -->
    <div v-if="message" :class="messageType" class="mb-6 p-4 rounded-md">
      {{ message }}
    </div>

    <!-- Comments List -->
    <div class="comments-list">
      <div v-if="loading" class="text-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
        <p class="text-gray-600 mt-2">Memuat komentar...</p>
      </div>

      <div v-else-if="comments.length === 0" class="text-center py-8 text-gray-500">
        <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>
      </div>

      <div v-else class="space-y-6">
        <div
          v-for="comment in comments"
          :key="comment.id"
          class="comment-item p-4 bg-gray-50 rounded-lg"
        >
          <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                {{ comment.name.charAt(0).toUpperCase() }}
              </div>
            </div>
            <div class="flex-1">
              <div class="flex items-center space-x-2 mb-2">
                <h5 class="font-semibold text-gray-800">{{ comment.name }}</h5>
                <span class="text-sm text-gray-500">{{ formatDate(comment.created_at) }}</span>
              </div>
              <p class="text-gray-700 whitespace-pre-line">{{ comment.comment }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination && pagination.last_page > 1" class="mt-8 flex justify-center">
        <nav class="flex space-x-2">
          <button
            v-for="page in pagination.last_page"
            :key="page"
            @click="changePage(page)"
            :class="[
              'px-3 py-2 rounded-md text-sm font-medium',
              page === pagination.current_page
                ? 'bg-blue-600 text-white'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
            ]"
          >
            {{ page }}
          </button>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import { commentService } from '@/service/api.js'

export default {
  name: 'CommentsSection',
  props: {
    beritaId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      comments: [],
      loading: false,
      submitting: false,
      message: null,
      messageType: null,
      pagination: null,
      currentPage: 1,
      commentForm: {
        name: '',
        email: '',
        comment: ''
      }
    }
  },
  mounted() {
    this.fetchComments()
  },
  methods: {
    async fetchComments() {
      try {
        this.loading = true
        const response = await commentService.getComments(this.beritaId, {
          page: this.currentPage
        })

        this.comments = response.data.data || []
        this.pagination = response.data.meta || null
      } catch (error) {
        console.error('Error fetching comments:', error)
        this.message = 'Gagal memuat komentar.'
        this.messageType = 'bg-red-100 border border-red-400 text-red-700'
      } finally {
        this.loading = false
      }
    },

    async submitComment() {
      try {
        this.submitting = true
        this.message = null

        await commentService.createComment(this.beritaId, this.commentForm)

        this.message = 'Komentar berhasil dikirim dan menunggu moderasi.'
        this.messageType = 'bg-green-100 border border-green-400 text-green-700'

        // Reset form
        this.commentForm = {
          name: '',
          email: '',
          comment: ''
        }

        // Refresh comments
        this.fetchComments()

      } catch (error) {
        console.error('Error submitting comment:', error)
        if (error.response && error.response.data && error.response.data.errors) {
          const errors = Object.values(error.response.data.errors).flat()
          this.message = errors.join(', ')
        } else {
          this.message = 'Gagal mengirim komentar. Silakan coba lagi.'
        }
        this.messageType = 'bg-red-100 border border-red-400 text-red-700'
      } finally {
        this.submitting = false
      }
    },

    changePage(page) {
      this.currentPage = page
      this.fetchComments()
    },

    formatDate(dateString) {
      if (!dateString) return ''
      const date = new Date(dateString)
      return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    }
  }
}
</script>

<style scoped>
.comments-section {
  font-family: 'Inter', sans-serif;
}

.comment-form {
  border: 1px solid #e5e7eb;
}

.comments-list {
  max-height: 600px;
  overflow-y: auto;
}

.comment-item {
  border: 1px solid #e5e7eb;
}

.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>