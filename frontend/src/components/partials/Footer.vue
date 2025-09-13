<template>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-grid">
        <div class="footer-column footer-logo-column">
          <img
            src="../../assets/img/logo-madiun.png"
            alt="Logo Diskominfo"
            class="footer-diskominfologo"
          />
          <p class="footer-description-logo">
            Dinas Komunikasi dan Informatika Kota Madiun.
          </p>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Informasi</h3>
          <ul class="footer-links">
            <li><a href="/home">Beranda</a></li>
            <li><a href="/profil">Profil</a></li>
            <li><a href="/layanan-pengaduan">Layanan Pengaduan</a></li>
            <li><a href="/faq">FAQ</a></li>
            <li><a href="/profil">Kontak Kami</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Layanan Publik</h3>
          <ul class="footer-links">
            <li><a href="/profil">Informasi Publik</a></li>
            <li><a href="/pengaduan">Permohonan Informasi</a></li>
            <li>
              <a href="https://ppid.madiunkota.go.id/" target="_blank"
                >PPID Madiun</a
              >
            </li>
            <li><a href="/profil">Statistik</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Tautan Cepat</h3>
          <ul class="footer-links">
            <li><a href="/berita">Berita Terbaru</a></li>
            <li><a href="/siaranpers">Publikasi</a></li>
            <li><a href="/kabarwarga">Agenda</a></li>
            <li><a href="/home">Sitemap</a></li>
            <li><a href="/pengaduan">Forms</a></li>
          </ul>
        </div>

        <div class="footer-column">
          <h3 class="footer-heading">Ikuti Kami</h3>
          <div class="footer-social">
            <a href="https://www.facebook.com/share/1716Qjuhxn/"
              ><i class="ri-facebook-fill"></i
            ></a>
            <a
              href="https://www.instagram.com/diskominfomadiunkota?igsh=bnFkZjF2cnBhbjdn"
              ><i class="ri-instagram-fill"></i
            ></a>
            <a href="https://www.youtube.com/@PemkotMadiun"
              ><i class="ri-youtube-fill"></i
            ></a>
          </div>

          <div class="footer-feedback">
            <h4 class="feedback-heading">Berikan Masukan Anda</h4>
            <form action="#" method="post">
              <textarea
                class="feedback-input"
                placeholder="Tuliskan masukan atau saran Anda di sini..."
                rows="4"
              ></textarea>
              <button type="submit" class="feedback-button">Kirim</button>
            </form>
          </div>
        </div>
      </div>

      <hr class="footer-separator" />

      <div class="footer-bottom">
        <p class="footer-description">
          <a
            href="https://maps.app.goo.gl/9tHqP6WqP7W8bHhA9"
            target="_blank"
            class="footer-address-link"
          >
            <i class="fas fa-map-marker-alt"></i> Jl. Perintis Kemerdekaan No.
            32, Madiun, 63116, Jawa Timur</a
          >
          <br />
          <i class="fas fa-envelope"></i> Email: diskominfo@madiunkota.go.id
        </p>
      </div>

      <div class="footer-copyright">
        <p>
          © {{ new Date().getFullYear() }} Copyright By UNIPMA.
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
// Tidak ada logic JS tambahan
</script>

<style scoped>
.footer {
  background-color: #0059a6;
  color: #fff;
  padding: 64px 16px;
  font-family: Arial, sans-serif;
  font-size: 14px;
  position: relative;
  overflow: hidden;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
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
    grid-template-columns: 1fr repeat(4, 1fr);
    gap: 20px;
  }
}

.footer-column {
  /* Gaya dasar untuk setiap kolom footer */
}

.footer-diskominfologo {
  max-width: 200px;
  height: auto;
  margin-bottom: 16px;  
}

.footer-description-logo {
  font-size: 14px;
  color: #f0f0f0;
  line-height: 1.5;
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
  color: #ffd700;
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
  color: #0059a6;
  transition: transform 0.5s, color 0.3s;
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
  transition: 0.5s;
  z-index: 2;
}

.footer-social a:nth-child(1)::before {
  background: #3b5999;
}
.footer-social a:nth-child(2)::before {
  background: #c13584;
}
.footer-social a:nth-child(3)::before {
  background: #ff0000;
}

/* Gaya untuk form masukan */
.footer-feedback {
  margin-top: 24px;
}

.feedback-heading {
  font-size: 14px;
  font-weight: bold;
  color: #fff;
  margin-bottom: 10px;
}

.feedback-input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  color: #333;
  font-size: 14px;
  margin-bottom: 10px;
}

.feedback-input::placeholder {
  color: #999;
}

.feedback-button {
  width: 100%;
  padding: 10px;
  background-color: #ffd700;
  color: #0059a6;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.feedback-button:hover {
  background-color: #ffc400;
}

.footer-separator {
  border: none;
  border-top: 1px solid rgba(255, 255, 255, 0.3);
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
  color: #ffd700;
}

.footer-address-link {
  color: #f0f0f0;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-address-link:hover {
  color: #ffd700;
}

/* Gaya baru untuk mengatur jarak copyright */
.footer-copyright {
  width: 100%;
  text-align: center;
  color: #fff;
  padding-top: 40px; /* Menambahkan padding yang lebih besar */
  padding-bottom: 20px;
}
</style>