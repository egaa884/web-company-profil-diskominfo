<template>
  <div>
    <HeroSection :title="heroTitle" />
    <CardList :cards="laporanPenerimaanList" />
  </div>
</template>

<script>
// Komponen yang sama diimpor dari lokasi yang sama
import HeroSection from '@/components/laporanpengaduan/HeroSection.vue';
import CardList from '@/components/laporanpengaduan/CardList.vue';

// Impor foto lokal yang berbeda
import fotoA from '@/assets/img/berita/laporan1.jpeg';
import fotoB from '@/assets/img/berita/laporan2.jpeg';
import fotoC from '@/assets/img/berita/laporan3.jpeg';

export default {
  name: 'LaporanPenerimaan',
  components: {
    HeroSection,
    CardList
  },
  data() {
    return {
      heroTitle: 'LAPORAN PENERIMAAN DISKOMINFO',
      // Data yang berbeda untuk laporan penerimaan
      laporanPenerimaanList: [
        {
          id: 1,
          foto: fotoA,
          judul: 'Laporan Penerimaan Barang Bulan Juni 2025',
          tanggal: '10 Juli 2025',
          penjelasan: 'Ringkasan laporan penerimaan barang dan aset TI pada bulan Juni. Memuat daftar barang, jumlah, dan vendor terkait.',
          link: '#'
        },
        {
          id: 2,
          foto: fotoB,
          judul: 'Laporan Penerimaan Surat Masuk April-Juni 2025',
          tanggal: '05 Juli 2025',
          penjelasan: 'Laporan triwulan mengenai jumlah surat masuk, kategori, dan tindak lanjut yang telah dilakukan oleh dinas.',
          link: '#'
        },
        {
          id: 3,
          foto: fotoC,
          judul: 'Laporan Penerimaan Tamu Kunjungan Kerja Bulan Mei 2025',
          tanggal: '01 Juni 2025',
          penjelasan: 'Dokumentasi kunjungan kerja dari dinas lain dan pihak ketiga selama bulan Mei.',
          link: '#'
        }
      ]
    };
  }
};
</script>

<style scoped>
/* Anda bisa menambahkan styling spesifik untuk halaman ini jika diperlukan,
   tetapi untuk tampilan card, style-nya sudah ada di CardList.vue */
</style>