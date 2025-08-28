<!-- components/AccessibilityWidget.vue -->
<template>
  <!-- Floating button -->
  <button
    class="a11y-fab"
    aria-label="Buka menu aksesibilitas"
    @click="open = true"
  >
    <!-- Universal access icon -->
    <svg viewBox="0 0 24 24" aria-hidden="true" class="fab-ico">
      <path d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4Zm-7.5 6a1 1 0 0 1 .3-.04h14.4a1 1 0 0 1 0 2h-5v3.5l2.9 7.5a1 1 0 1 1-1.88.72L12 14.8l-3.22 7.88a1 1 0 1 1-1.88-.76l2.9-7.49V10H4.8a1 1 0 0 1-.3-1.96Z"/>
    </svg>
  </button>

  <!-- Overlay + panel -->
  <transition name="panel">
    <div
      v-if="open"
      class="a11y-overlay"
      role="dialog"
      aria-modal="true"
      aria-labelledby="a11y-title"
      @keydown.esc="open=false"
    >
      <div class="a11y-panel" ref="panelEl" tabindex="-1">
        <header class="a11y-header">
          <h3 id="a11y-title">Menu Aksesibilitas <span class="kbd">(CTRL+U)</span></h3>
          <button class="close-btn" aria-label="Tutup" @click="open=false">×</button>
        </header>

        <!-- Profil Aksesibilitas -->
        <section class="profile-section">
          <button class="profile-toggle" @click="profilesOpen = !profilesOpen" aria-expanded="profilesOpen.toString()">
            <span class="profile-ico">👤</span>
            <span>Profil Aksesibilitas</span>
            <span class="chev" :class="{open: profilesOpen}">▾</span>
          </button>

          <transition name="fade">
            <div v-if="profilesOpen" class="profile-grid">
              <button
                v-for="p in profileDefs"
                :key="p.key"
                class="profile-chip"
                :class="{ active: activeProfile === p.key }"
                @click="applyProfile(p.key)"
              >
                <span class="chip-ico">{{ p.icon }}</span>
                <span class="chip-label">{{ p.label }}</span>
              </button>
            </div>
          </transition>
        </section>

        <!-- Grid aksi cepat (kartu-kartu) -->
        <section class="cards">
          <button class="card" @click="changeFont(1)">
            <div class="ico">T T</div>
            <div class="lbl">Perbesar Teks</div>
          </button>

          <button class="card" @click="changeFont(-1)">
            <div class="ico">t t</div>
            <div class="lbl">Perkecil Teks</div>
          </button>

          <button class="card" :class="{on: settings.darkMode}" @click="toggle('darkMode')">
            <div class="ico">🌙</div>
            <div class="lbl">Mode Gelap</div>
          </button>

          <button class="card" :class="{on: settings.highContrast}" @click="toggle('highContrast')">
            <div class="ico">◑</div>
            <div class="lbl">Kontras+</div>
          </button>

          <button class="card" :class="{on: settings.linkHighlight}" @click="toggle('linkHighlight')">
            <div class="ico">🔗</div>
            <div class="lbl">Tautan: Garis Bawah</div>
          </button>

          <button class="card" :class="{on: settings.hideImages}" @click="toggle('hideImages')">
            <div class="ico">🖼️🚫</div>
            <div class="lbl">Sembunyikan Gambar</div>
          </button>

          <button class="card" :class="{on: settings.lowSaturation}" @click="toggle('lowSaturation')">
            <div class="ico">🟦⬜</div>
            <div class="lbl">Kejenuhan</div>
          </button>

          <button class="card" :class="{on: settings.dyslexia}" @click="toggle('dyslexia')">
            <div class="ico">Df</div>
            <div class="lbl">Ramah Disleksia</div>
          </button>

          <button class="card" :class="{on: settings.lineHeightLg}" @click="toggle('lineHeightLg')">
            <div class="ico">↕</div>
            <div class="lbl">Tinggi Garis</div>
          </button>

          <button class="card" :class="{on: settings.textSpacing}" @click="toggle('textSpacing')">
            <div class="ico">A&nbsp; A</div>
            <div class="lbl">Spasi Teks</div>
          </button>

          <button class="card" :class="{on: settings.reduceMotion}" @click="toggle('reduceMotion')">
            <div class="ico">⏸️</div>
            <div class="lbl">Animasi Dijeda</div>
          </button>

          <button class="card" :class="{on: settings.justify}" @click="toggle('justify')">
            <div class="ico">≡</div>
            <div class="lbl">Rata Tulisan</div>
          </button>
        </section>

        <div class="panel-footer">
          <button class="reset-btn" @click="resetAll">Reset Pengaturan</button>
          <div class="hint">Pengaturan disimpan otomatis di perangkat ini.</div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, reactive, watch, onMounted, nextTick } from 'vue'

const open = ref(false)
const profilesOpen = ref(false)
const panelEl = ref(null)
const activeProfile = ref('')

const settings = reactive({
  fontScale: 0,          // -1,0,+1 (small/medium/large)
  darkMode: false,
  highContrast: false,
  linkHighlight: false,
  hideImages: false,
  lowSaturation: false,
  dyslexia: false,
  lineHeightLg: false,
  textSpacing: false,
  reduceMotion: false,
  justify: false,
})

const LS_KEY = 'a11y-settings-v1'

// ----- helpers -----
const clamp = (v, min, max) => Math.max(min, Math.min(max, v))

function applyClasses() {
  const b = document.body
  // font scale
  b.classList.remove('font-small', 'font-medium', 'font-large')
  b.classList.add(['font-small','font-medium','font-large'][settings.fontScale + 1] || 'font-medium')

  b.classList.toggle('dark-mode', settings.darkMode)
  b.classList.toggle('high-contrast', settings.highContrast)
  b.classList.toggle('link-highlight', settings.linkHighlight)
  b.classList.toggle('hide-images', settings.hideImages)
  b.classList.toggle('low-saturation', settings.lowSaturation)
  b.classList.toggle('dyslexia', settings.dyslexia)
  b.classList.toggle('lineheight-lg', settings.lineHeightLg)
  b.classList.toggle('text-spacing', settings.textSpacing)
  b.classList.toggle('reduce-motion', settings.reduceMotion)
  b.classList.toggle('justify-text', settings.justify)
}

function save() {
  localStorage.setItem(LS_KEY, JSON.stringify({ ...settings }))
}

function load() {
  const raw = localStorage.getItem(LS_KEY)
  if (!raw) return
  try {
    const obj = JSON.parse(raw)
    Object.assign(settings, obj)
  } catch {}
}

// actions
function changeFont(step) {
  settings.fontScale = clamp(settings.fontScale + step, -1, 1)
}

function toggle(key) {
  settings[key] = !settings[key]
}

function resetAll() {
  Object.assign(settings, {
    fontScale: 0,
    darkMode: false,
    highContrast: false,
    linkHighlight: false,
    hideImages: false,
    lowSaturation: false,
    dyslexia: false,
    lineHeightLg: false,
    textSpacing: false,
    reduceMotion: false,
    justify: false,
  })
  activeProfile.value = ''
}

// keyboard shortcut (Ctrl+U)
function onKeydown(e) {
  if ((e.ctrlKey || e.metaKey) && (e.key === 'u' || e.key === 'U')) {
    e.preventDefault()
    open.value = !open.value
    nextTick(() => panelEl.value?.focus())
  }
}

onMounted(() => {
  load()
  applyClasses()
  window.addEventListener('keydown', onKeydown)
})

watch(settings, () => { applyClasses(); save() }, { deep: true })
watch(open, v => v && nextTick(() => panelEl.value?.focus()))

// ----- Profiles (preset kombinasi) -----
const profileDefs = [
  { key: 'motor',     label: 'Gangguan Motorik', icon: '♿', set: { fontScale: 1, reduceMotion: true, linkHighlight: true } },
  { key: 'blind',     label: 'Netra Total',      icon: '◐', set: { fontScale: 1, highContrast: true, linkHighlight: true, hideImages: true } },
  { key: 'color',     label: 'Buta Warna',       icon: '●○', set: { highContrast: true, linkHighlight: true, lowSaturation: true } },
  { key: 'dyslexia',  label: 'Disleksia',        icon: 'Df', set: { fontScale: 1, dyslexia: true, textSpacing: true, lineHeightLg: true } },
  { key: 'vision',    label: 'Pengelihatan',     icon: '👁️', set: { fontScale: 1, highContrast: true } },
  { key: 'cognitive', label: 'Kognitif & Belajar', icon: '✚', set: { textSpacing: true, lineHeightLg: true, justify: false, reduceMotion: true } },
  { key: 'seizure',   label: 'Kejang/Epilepsi',  icon: '⚡', set: { reduceMotion: true, lowSaturation: true } },
  { key: 'adhd',      label: 'ADHD',             icon: '◎', set: { textSpacing: true, reduceMotion: true } },
]

function applyProfile(key) {
  const p = profileDefs.find(x => x.key === key)
  if (!p) return
  resetAll()
  Object.assign(settings, p.set)
  activeProfile.value = key
}
</script>

<style scoped>
/* Floating Action Button */
.a11y-fab{
  position: fixed; right: 22px; bottom: 22px;
  width: 56px; height: 56px; border-radius: 50%;
  background:#0059A6; color:#fff; border:none; cursor:pointer;
  box-shadow:0 8px 20px rgba(0,0,0,.25);
  display:grid; place-items:center; z-index: 10000;
  transition: transform .2s ease, box-shadow .2s ease;
}
.a11y-fab:hover{ transform: translateY(-2px); box-shadow:0 10px 24px rgba(0,0,0,.3); }
.fab-ico{ width:26px; height:26px; fill:#fff; }

/* Overlay & panel */
.a11y-overlay{
  position: fixed; inset: 0; background: rgba(0,0,0,.18);
  display:flex; justify-content:flex-end; align-items:flex-end;
  z-index:9999;
}
.a11y-panel{
  width: min(680px, 96vw);
  background:#fff; border-radius:16px 16px 0 0;
  box-shadow:0 -10px 30px rgba(0,0,0,.25);
  outline:none;
  max-height: 90vh; overflow:auto;
}
.a11y-header{
  background:#0059A6; color:#fff; padding:16px 56px 16px 20px;
  border-radius:16px 16px 0 0; position:relative;
}
.a11y-header h3{ margin:0; font-size:18px; font-weight:800; }
.kbd{ opacity:.9; font-weight:600; }
.close-btn{
  position:absolute; right:8px; top:8px;
  width:36px; height:36px; border-radius:50%;
  border:none; font-size:24px; line-height:1; cursor:pointer;
  background:rgba(255,255,255,.2); color:#fff;
}
.close-btn:hover{ background:rgba(255,255,255,.3); }

/* Profil */
.profile-section{ padding:10px 14px; border-bottom:1px solid #e6e6e6; }
.profile-toggle{
  width:100%; display:flex; align-items:center; gap:10px;
  background:#f5f7fb; border:1px solid #e5e8f0; padding:12px 14px;
  border-radius:10px; cursor:pointer; font-weight:700;
}
.profile-ico{ font-size:18px; }
.chev{ margin-left:auto; transition: transform .2s; }
.chev.open{ transform: rotate(180deg); }

.profile-grid{
  display:grid; grid-template-columns: repeat(2,1fr);
  gap:10px; padding:12px 2px 4px;
}
.profile-chip{
  display:flex; align-items:center; gap:10px;
  padding:10px 12px; border:1px solid #e5e8f0; border-radius:10px;
  background:#fff; cursor:pointer; text-align:left; font-weight:600;
}
.profile-chip.active{ background:#e8f0ff; border-color:#b7d0ff; }
.chip-ico{ width:24px; text-align:center; }

/* Cards */
.cards{
  display:grid; grid-template-columns: repeat(3,1fr);
  gap:14px; padding:14px;
}
.card{
  background:#fff; border:1px solid #e8e8ee; border-radius:16px;
  padding:18px 12px; display:grid; place-items:center; gap:12px;
  cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,.06);
  transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
}
.card .ico{ font-size:24px; font-weight:800; }
.card .lbl{ font-weight:700; text-align:center; }
.card:hover{ transform: translateY(-2px); box-shadow:0 6px 14px rgba(0,0,0,.12); }
.card.on{ border-color:#0059A6; box-shadow:0 0 0 3px rgba(0,89,166,.15) inset; }

.panel-footer{
  display:flex; align-items:center; justify-content:space-between;
  padding:10px 14px 16px;
}
.reset-btn{
  background:#d9534f; border:none; color:#fff; padding:10px 14px; border-radius:10px; font-weight:700; cursor:pointer;
}
.reset-btn:hover{ background:#c23d3a; }
.hint{ font-size:12px; color:#666; }

/* transitions */
.panel-enter-from{ opacity:0; }
.panel-enter-active{ transition: opacity .15s ease; }
.panel-leave-to{ opacity:0; }
.panel-leave-active{ transition: opacity .15s ease; }

.fade-enter-active, .fade-leave-active{ transition: opacity .15s; }
.fade-enter-from, .fade-leave-to{ opacity:0; }
</style>

<!-- GLOBAL STYLES: taruh di App.vue / main.css (sekali saja) -->
<style>
/* Font scale */
.font-small{ font-size:14px; }
.font-medium{ font-size:16px; }
.font-large{ font-size:20px; }

/* Dark mode */
.dark-mode{ background:#121212; color:#f5f5f5; }
.dark-mode a{ color:#7ec8ff; }

/* High contrast */
.high-contrast{ background:#000 !important; color:#fff !important; }
.high-contrast a{ color:yellow !important; text-decoration: underline !important; }

/* Link highlight */
.link-highlight a{
  text-decoration: underline !important;
  background:#007bff !important; color:#fff !important;
  padding:2px 4px; border-radius:3px;
}

/* Hide images */
.hide-images img{ display:none !important; }

/* Low saturation / grayscale-ish for content */
.low-saturation img, .low-saturation video, .low-saturation picture{
  filter: grayscale(1) contrast(1.05) !important;
}

/* Dyslexia-friendly (gunakan font lokal jika tersedia) */
@font-face{ font-family: 'OpenDyslexic'; src: local('OpenDyslexic'); font-display: swap; }
.dyslexia{ font-family: 'OpenDyslexic','Atkinson Hyperlegible',system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif !important; }

/* Line-height & spacing */
.lineheight-lg{ line-height: 1.9 !important; }
.text-spacing{ letter-spacing: .06em !important; word-spacing: .12em !important; }

/* Reduce motion */
.reduce-motion *{
  animation: none !important;
  transition: none !important;
  scroll-behavior: auto !important;
}

/* Justify paragraph text */
.justify-text p, .justify-text li, .justify-text article, .justify-text .prose{
  text-align: justify;
}
</style>
