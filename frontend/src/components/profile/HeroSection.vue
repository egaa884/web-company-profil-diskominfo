<template>
  <div class="hero-section">
    <div class="hero-main-gradient-overlay"></div>

    <div class="hero-logo-background"></div>

    <div class="hero-decorative-elements">
      <div class="decorative-circle-1"></div>
      <div class="decorative-circle-2"></div>
    </div>

    <div class="hero-content-wrapper">
      <div class="hero-text-container">
        <h1 class="hero-title-profil">
          Profil
        </h1>
        <div class="hero-divider"></div>
        <h2 class="hero-title-diskominfo">
          DINAS KOMUNIKASI
        </h2>
        <h3 class="hero-title-diskominfo">
          DAN INFORMATIKA 
        </h3>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HeroSection'
}
</script>

<style scoped>
/* Container utama */
.hero-section {
  position: relative;
  min-height: 500px; /* Tinggi minimum hero section */
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 5rem 1rem; /* Padding vertikal dan horizontal */
  overflow: hidden; /* Penting untuk mengelola elemen absolut di dalamnya */
  height: 100vh;
}

/* Latar Belakang Gradasi Utama (Biru tua ke Putih) */
.hero-main-gradient-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom, #01458E 0%, #FFFFFF 100%); /* Gradasi dari atas ke bawah */
  z-index: 0; /* Lapisan paling bawah */
}

/* Gambar Logo Kominfo di atas Gradasi Utama */
.hero-logo-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('../../assets/img/logo-kominfo.png'); /* Gambar logo Anda */
  background-size: contain; /* Mengandung gambar di dalam, tidak memotong */
  background-repeat: no-repeat; /* Tidak mengulang */
  background-position: center; /* Posisikan di tengah */
  opacity: 0.3; /* Transparansi 30% */
  z-index: 1; /* Di atas gradasi utama, di bawah konten dan elemen dekoratif lain */
}

/* Background Decorative Elements (lingkaran) - Opsional, sesuaikan z-index jika perlu */
/* Saya mempertahankan ini dan menempatkannya di z-index 2 (di atas logo background) */
.hero-decorative-elements {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  z-index: 2; /* Di atas logo background, di bawah konten teks */
  pointer-events: none; /* Agar tidak menghalangi interaksi mouse jika ada */
}

.decorative-circle-1 {
  position: absolute;
  top: -5rem;
  right: -5rem;
  width: 24rem;
  height: 24rem;
  background-color: rgba(147, 197, 253, 0.2); /* bg-blue-300 opacity-20 */
  border-radius: 9999px;
  transform: rotate(12deg);
}

.decorative-circle-2 {
  position: absolute;
  bottom: 0rem;
  left: -5rem;
  width: 20rem;
  height: 20rem;
  background-color: rgba(96, 165, 250, 0.15); /* bg-blue-400 opacity-15 */
  border-radius: 9999px;
  transform: rotate(-12deg);
}

/* Wrapper Konten Teks */
.hero-content-wrapper {
  position: relative;
  z-index: 10; /* Lapisan paling atas untuk teks */
  width: 100%; /* Agar container MX-auto berfungsi */
  max-width: 1200px; /* Lebar maksimal konten */
  margin-left: auto;
  margin-right: auto;
  padding-left: 1rem;
  padding-right: 1rem;
}

.hero-text-container {
  text-align: center;
  display: flex; /* Menggunakan flexbox untuk penataan item vertikal */
  flex-direction: column;
  align-items: center; /* Pusatkan item secara horizontal */
}

/* Teks "Profil" */
.hero-title-profil {
  font-size: 2.25rem; /* text-4xl */
  font-weight: 700; /* font-bold */
  color: #FFFFFF; /* Warna Putih */
  margin-bottom: 1rem; /* mb-4 */
}

@media (min-width: 768px) {
  .hero-title-profil {
    font-size: 3.75rem; /* md:text-6xl */
  }
}

/* Garis di bawah teks "Profil" */
.hero-divider {
  width: 20rem; /* w-24, sesuaikan panjangnya */
  height: 0.25rem; /* h-1 */
  background-color: #000000; /* Garis Hitam */
  margin-left: auto; /* mx-auto */
  margin-right: auto; /* mx-auto */
  margin-bottom: 1.5rem; /* mb-6 */
}

/* Teks "DINAS KOMUNIKASI DAN INFORMATIKA" */
.hero-title-diskominfo {
  font-size: 1.875rem; /* text-3xl */
  font-weight: 700; /* font-bold */
  margin-bottom: 0.5rem; /* mb-2 */
  text-transform: uppercase; /* Kapital semua */

  /* Efek Gradasi Radial pada Teks */
  background-image: radial-gradient(
    circle at center,
    #0093DD 0%, /* Warna di tengah teks */
    #29166F 100% /* Warna di pinggir teks */
  );
  -webkit-background-clip: text; /* Penting untuk mengaplikasikan gradasi ke teks */
  background-clip: text;
  -webkit-text-fill-color: transparent; /* Membuat teks transparan agar gradasi terlihat */
  color: transparent; /* Fallback untuk browser lama */
}

/* Penyesuaian responsif untuk teks DINAS KOMUNIKASI DAN INFORMATIKA */
@media (min-width: 768px) {
  .hero-title-diskominfo {
    font-size: 3rem; /* md:text-5xl */
  }
}
</style>