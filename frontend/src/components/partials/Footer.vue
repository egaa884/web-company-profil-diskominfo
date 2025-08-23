<template>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-grid">
        <div class="footer-column">
          <h3 class="footer-heading">Informasi</h3>
          <ul class="footer-links">
            <li><a href="#">Beranda</a></li>
            <li><a href="#">Profil</a></li>
            <li><a href="#">Layanan Pengaduan</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Kontak Kami</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Layanan Publik</h3>
          <ul class="footer-links">
            <li><a href="#">Informasi Publik</a></li>
            <li><a href="#">Permohonan Informasi</a></li>
            <li><a href="#">PPID Madiun</a></li>
            <li><a href="#">Statistik</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Tautan Cepat</h3>
          <ul class="footer-links">
            <li><a href="#">Berita Terbaru</a></li>
            <li><a href="#">Publikasi</a></li>
            <li><a href="#">Agenda</a></li>
            <li><a href="#">Sitemap</a></li>
            <li><a href="#">Forms</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Ikuti Kami</h3>
          <div class="footer-social">
            <a href="https://www.facebook.com/share/1716Qjuhxn/"><i class="ri-facebook-fill"></i></a>
            <a href="https://www.instagram.com/diskominfomadiunkota?igsh=bnFkZjF2cnBhbjdn"><i class="ri-instagram-fill"></i></a>
            <a href="https://www.youtube.com/@PemkotMadiun"><i class="ri-youtube-fill"></i></a>
          </div>
        </div>
      </div>

      <hr class="footer-separator" />

      <div class="footer-bottom">
        <p class="footer-description">
          <i class="fas fa-map-marker-alt"></i> Jl. Perintis Kemerdekaan No. 32, Madiun, 63116, Jawa Timur<br />
          <i class="fas fa-envelope"></i> Email: diskominfo@madiunkota.go.id
        </p>
      </div>
    </div>

    <!-- Logo background -->
    <div class="footer-logo"></div>
  </footer>
</template>

<script setup>
// Tidak ada logic JS
</script>

<style scoped>
.footer {
  background-color: #0059A6; /* warna utama footer */
  color: #fff;
  padding: 64px 16px;
  font-family: Arial, sans-serif;
  font-size: 14px;
  position: relative; /* untuk positioning logo */
  overflow: hidden;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
  position: relative;
  z-index: 2; /* agar konten tetap di atas logo */
}

.footer-logo {
  position: absolute;
  bottom: 10px;
  right: 10px;
  background: url('../../assets/img/logo-madiun.png') no-repeat center;
  background-size: 120px auto;
  width: 120px;
  height: 120px;
  opacity: 0.3; /* transparansi logo */
  pointer-events: none; /* tidak ganggu klik */
  z-index: 1;
}

.footer-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 32px;
  margin-bottom: 48px;
}

@media (min-width: 768px) {
  .footer-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (min-width: 1024px) {
  .footer-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.footer-heading {
  font-weight: bold;
  text-transform: uppercase;
  margin-bottom: 16px;
  color: #fff;
}

.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 8px;
}

.footer-links a {
  color: #f0f0f0;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-links a:hover {
  color: #FFD700;
}

/* Sosial Media dengan Animasi */
.footer-social {
  display: flex;
  gap: 16px;
  margin-top: 8px;
  perspective: 1000px;
}

.footer-social a {
  width: 40px;
  height: 40px;
  background-color: #fff;
  text-align: center;
  font-size: 20px;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  position: relative;
  overflow: hidden;
  border: 2px solid #fff;
  z-index: 1;
  transform-style: preserve-3d;
}

.footer-social a i {
  position: relative;
  color: #0059A6;
  transition: transform .5s, color .3s;
  z-index: 3;
}

.footer-social a:hover i {
  color: #fff;
  transform: rotateY(360deg);
}

.footer-social a::before {
  content: "";
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  height: 100%;
  transition: .5s;
  z-index: 2;
}

.footer-social a:hover::before {
  top: 0;
}

/* Warna spesifik ikon */
.footer-social a:nth-child(1)::before { background: #3b5999; }
.footer-social a:nth-child(2)::before { background: #c13584; }
.footer-social a:nth-child(3)::before { background: #ff0000; }

.footer-separator {
  border: none;
  border-top: 1px solid rgba(255,255,255,0.3);
  margin: 32px 0;
}

.footer-bottom {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

@media (min-width: 768px) {
  .footer-bottom {
    flex-direction: row;
    justify-content: space-between;
    align-items: flex-start;
  }
}

.footer-description {
  color: #f0f0f0;
  font-size: 13px;
  line-height: 1.5;
}

.footer-description i {
  margin-right: 10px;
  color: #FFD700;
}
</style>
