<template>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-grid">
        <!-- Informasi -->
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

        <!-- Layanan Publik -->
        <div class="footer-column">
          <h3 class="footer-heading">Layanan Publik</h3>
          <ul class="footer-links">
            <li><a href="#">Informasi Publik</a></li>
            <li><a href="#">Permohonan Informasi</a></li>
            <li><a href="#">PPID Madiun</a></li>
            <li><a href="#">Statistik</a></li>
          </ul>
        </div>

        <!-- Tautan Cepat -->
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

        <!-- Media Sosial -->
        <div class="footer-column">
          <h3 class="footer-heading">Ikuti Kami</h3>
          <div class="footer-social">
           <a href="#"><i class="ri-facebook-fill"></i></a>
           <a href="#"><i class="ri-instagram-fill"></i></a>
           <a href="#"><i class="ri-twitter-x-fill"></i></a>
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

/* Sosial Media */
.footer-social {
  display: flex;
  gap: 16px;
  margin-top: 8px;
}

.footer-social a {
  font-size: 20px;
  color: #555;
  transition: color 0.3s;
}

.footer-social a:hover {
  color: #007BFF;
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
