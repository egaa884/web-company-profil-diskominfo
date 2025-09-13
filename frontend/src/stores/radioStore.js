import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useRadioStore = defineStore('radio', () => {
  // State
  const isPlaying = ref(false)
  const volume = ref(75)
  const radioStreamUrl = 'https://play-93fm.madiunkota.go.id/live'
  const audioPlayer = ref(null)

  // Getters
  const isRadioPlaying = computed(() => isPlaying.value)

  // Actions
  const togglePlay = () => {
    if (!audioPlayer.value) return

    if (isPlaying.value) {
      audioPlayer.value.pause()
    } else {
      audioPlayer.value.play().catch(error => {
        console.error('Error playing radio:', error)
      })
    }
    isPlaying.value = !isPlaying.value
  }

  const setVolume = (newVolume) => {
    volume.value = newVolume
    if (audioPlayer.value) {
      audioPlayer.value.volume = newVolume / 100
    }
  }

  const setAudioPlayer = (player) => {
    audioPlayer.value = player
    if (player) {
      player.volume = volume.value / 100
    }
  }

  const pauseRadio = () => {
    if (audioPlayer.value) {
      audioPlayer.value.pause()
    }
    isPlaying.value = false
  }

  return {
    // State
    isPlaying,
    volume,
    radioStreamUrl,
    audioPlayer,

    // Getters
    isRadioPlaying,

    // Actions
    togglePlay,
    setVolume,
    setAudioPlayer,
    pauseRadio
  }
})