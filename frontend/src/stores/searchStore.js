import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { searchService } from '../service/api'

export const useSearchStore = defineStore('search', () => {
  // State
  const query = ref('')
  const results = ref({
    berita: [],
    profil: [],
    faq: [],
    publikasi: []
  })
  const isLoading = ref(false)
  const totalResults = ref(0)
  const searchHistory = ref([])

  // Getters
  const hasResults = computed(() => totalResults.value > 0)
  const allResults = computed(() => {
    return [
      ...results.value.berita.map(item => ({ ...item, type: 'berita' })),
      ...results.value.profil.map(item => ({ ...item, type: 'profil' })),
      ...results.value.faq.map(item => ({ ...item, type: 'faq' })),
      ...results.value.publikasi.map(item => ({ ...item, type: 'publikasi' }))
    ].sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
  })

  // Actions
  const search = async (searchQuery, limit = 5) => {
    if (!searchQuery || searchQuery.trim() === '') {
      clearResults()
      return
    }

    query.value = searchQuery.trim()
    isLoading.value = true

    try {
      const response = await searchService.globalSearch({
        q: query.value,
        limit: limit
      })

      results.value = response.data.results
      totalResults.value = response.data.total

      // Add to search history
      addToHistory(query.value)

    } catch (error) {
      console.error('Search error:', error)
      clearResults()
    } finally {
      isLoading.value = false
    }
  }

  // Auto-suggest search for berita titles only
  const autoSuggest = async (searchQuery, limit = 5) => {
    if (!searchQuery || searchQuery.trim() === '') {
      clearResults()
      return
    }

    query.value = searchQuery.trim()
    isLoading.value = true

    try {
      const response = await searchService.globalSearch({
        q: query.value,
        limit: limit,
        type: 'berita'
      })

      results.value = response.data.results
      totalResults.value = response.data.total

    } catch (error) {
      console.error('Auto-suggest error:', error)
      clearResults()
    } finally {
      isLoading.value = false
    }
  }

  const clearResults = () => {
    results.value = {
      berita: [],
      profil: [],
      faq: [],
      publikasi: []
    }
    totalResults.value = 0
    query.value = ''
  }

  const clearResultsOnly = () => {
    results.value = {
      berita: [],
      profil: [],
      faq: [],
      publikasi: []
    }
    totalResults.value = 0
  }

  const addToHistory = (searchTerm) => {
    // Remove if already exists
    searchHistory.value = searchHistory.value.filter(item => item !== searchTerm)

    // Add to beginning
    searchHistory.value.unshift(searchTerm)

    // Keep only last 10 searches
    if (searchHistory.value.length > 10) {
      searchHistory.value = searchHistory.value.slice(0, 10)
    }

    // Save to localStorage
    localStorage.setItem('searchHistory', JSON.stringify(searchHistory.value))
  }

  const loadHistory = () => {
    const history = localStorage.getItem('searchHistory')
    if (history) {
      searchHistory.value = JSON.parse(history)
    }
  }

  const clearHistory = () => {
    searchHistory.value = []
    localStorage.removeItem('searchHistory')
  }

  // Initialize history on store creation
  loadHistory()

  return {
    // State
    query,
    results,
    isLoading,
    totalResults,
    searchHistory,

    // Getters
    hasResults,
    allResults,

    // Actions
    search,
    autoSuggest,
    clearResults,
    clearResultsOnly,
    addToHistory,
    loadHistory,
    clearHistory
  }
})