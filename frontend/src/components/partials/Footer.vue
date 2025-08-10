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
  </footer>
</template>

<script setup>
// Tidak ada logic JS
</script>

<style scoped>
.footer {
  background-color: #f5f5f5;
  color: #333;
  padding: 64px 16px;
  font-family: Arial, sans-serif;
  font-size: 14px;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
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
  color: #333;
  text-decoration: none;
}

.footer-links a:hover {
  color: #007BFF;
}

/* Sosial Media dengan Animasi */
.footer-social {
  display: flex;
  gap: 16px;
  margin-top: 8px;
  /* Properti yang ditambahkan untuk efek rotasi */
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
  border: 2px solid #555;
  z-index: 1;

  /* Properti yang ditambahkan untuk efek rotasi */
  transform-style: preserve-3d;
}

.footer-social a i {
  position: relative;
  color: #555;
  transition: transform .5s;
  z-index: 3;
  /* Transform awal dihilangkan agar rotasi berfungsi */
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
  background: #f00;
  transition: .5s;
  z-index: 2;
}

.footer-social a:hover::before {
  top: 0;
}

/* Warna spesifik untuk setiap ikon */
.footer-social a:nth-child(1)::before {
  background: #3b5999;
}

.footer-social a:nth-child(2)::before {
  background: #c13584;
}

.footer-social a:nth-child(3)::before {
  background: #ff0000;
}


.footer-separator {
  border: none;
  border-top: 1px solid #ccc;
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
  color: #777;
  font-size: 13px;
  line-height: 1.5;
}

.footer-description i {
  margin-right: 6px;
  color: #555;
}
</style>