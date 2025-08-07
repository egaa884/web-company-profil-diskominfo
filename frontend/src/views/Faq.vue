<template>
  <div class="faq-container">
    <FAQHeader />
    <FAQList :faqs="faqs" />
  </div>
</template>

<script setup>
import FAQHeader from '../components/faq/FAQHeader.vue'
import FAQList from '../components/faq/FAQList.vue'

const faqs = [
  {
    question: 'Apakah tugas dan fungsi Dinas Komunikasi dan Informatika Kota Madiun?',
    answer: `Dinas Komunikasi dan Informatika Kota Madiun merupakan unsur pelaksana urusan pemerintahan di bidang komunikasi dan informatika, persandian, dan statistik yang mengelola media informasi resmi dan aplikasi untuk Pemerintah Kota Madiun.`
  },
  {
    question: 'Apa saja layanan yang tersedia di Dinas Komunikasi dan Informatika Kota Madiun?',
    answer: `Dinas Komunikasi dan Informatika Kota Madiun menyediakan layanan publik, yaitu: \n\
    a. Pemberian informasi oleh Pejabat Pengelola Informasi dan Dokumentasi (PPID)\n\
    b. Pembuatan/Pengembangan Aplikasi untuk Internal Pemerintah Kota Madiun\n\
    c. Pemeliharaan Jaringan Intranet dan Internet\n\
    d. Profil IT M-Tech\n\
    e. Madiun Call Center 112\n\
    f. Awak Sigap (Anda WA, Kami Siap Segera Tanggap)\n\
    g. Government Chief Information Officer (GCIO)\n\
    h. Layanan Kelian Sahabat\n\
    i. Kegiatan Keprotokolan Pemerintah Kota Madiun\n\
    j. Monitoring CCTV di LPJU dan Penyeberangan Warga\n\
    k. Madiun Today/Neges Ekonomi\n\
    l. Madiun Today/Neges Ekonomi\n\
    m. Data Statistik Sektoral\n\
    n. Fasilitasi TTE (Tanda Tangan Elektronik)`
  },
  {
    question: 'Bagaimana tata cara mengakses layanan publik yang tersedia pada Dinas Komunikasi dan Informatika Kota Madiun?',
    answer: `Untuk mengakses layanan publik yang tersedia, silakan kunjungi: https://kominfo.madiunkota.go.id/profile/standarpelayanan`
  },
  {
    question: 'Bagaimana cara mengajukan permohonan informasi publik di Dinas Komunikasi dan Informatika Kota Madiun?',
    answer: `Permohonan informasi publik dapat diajukan melalui Pejabat Pengelola Informasi dan Dokumentasi (PPID) Dinas Komunikasi dan Informatika Kota Madiun. Permohonan dapat dilakukan secara daring melalui: \n\
    a. PPID Kota Madiun: https://awaksigap.madiunkota.go.id/masuk/awaksigap\n\
    b. SP4N-Lapor!: https://www.lapor.go.id/`
  },
  {
    question: 'Bagaimana cara menyampaikan pengaduan mengenai layanan publik Dinas Komunikasi dan Informatika Kota Madiun?',
    answer: `Pengaduan dapat disampaikan melalui: \n\
    a. Awak Sigap: https://awaksigap.madiunkota.go.id/ atau WhatsApp 08113577800\n\
    b. SP4N-Lapor!: https://www.lapor.go.id/`
  },
  {
    question: 'Apakah Dinas Komunikasi dan Informatika menyediakan layanan Gawat Darurat?',
    answer: `Ya, layanan gawat darurat tersedia melalui Madiun Siaga 112 dengan nomor darurat 112 (gratis).`
  },
  {
    question: 'Bagaimana cara mendapatkan informasi terkini mengenai Dinas Komunikasi dan Informatika Kota Madiun?',
    answer: `Masyarakat dapat mengikuti informasi terkini melalui: \n\
    a. Website: https://kominfo.madiunkota.go.id/\n\
    b. Media Sosial: https://www.instagram.com/diskominfomadiunkota/\n\
    c. Radio: LPPL Radio Suara Madiun 93 FM atau live streaming https://93fm.madiunkota.go.id/`
  }
]
</script>

<style scoped>
.faq-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem 1rem;
  
}
</style>