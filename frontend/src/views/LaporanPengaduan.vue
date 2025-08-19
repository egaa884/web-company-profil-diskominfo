<template>
  <div>
    <HeroSection />
    <CardList :cards="beritaList" />

    </div>
</template>

<script>
import HeroSection from '@/components/laporanpengaduan/HeroSection.vue';
import CardList from '@/components/laporanpengaduan/CardList.vue';
import foto1 from '@/assets/img/berita/laporan1.jpeg';
import foto2 from '@/assets/img/berita/laporan2.jpeg';
import foto3 from '@/assets/img/berita/laporan3.jpeg';

export default {
  name: 'HalamanUtama',
  components: {
    HeroSection,
    CardList
  },
  data() {
    return {
      beritaList: [
        {
          id: 1,
          foto: foto1,
          judul: 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Juni Tahun 2025',
          tanggal: '14 Agustus 2025',
          penjelasan: 'Ini adalah penjelasan singkat mengenai isi artikel. Anda bisa memasukkan beberapa kalimat deskriptif di sini agar pembaca tertarik.',
          link: '#'
        },
        {
          id: 2,
          foto: foto2,
          judul: 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan Mei Tahun 2025',
          tanggal: '13 Agustus 2025',
          penjelasan: 'Penjelasan sekilas tentang artikel kedua. Fokus pada poin-poin utama yang dibahas di dalamnya. Buatlah teks ini menarik dan informatif.',
          link: '#'
        },
        {
          id: 3,
          foto: foto3,
          judul: 'Laporan Pengaduan Pelayanan Publik Dinas Komunikasi dan Informatika Kota Madiun Bulan April Tahun 2025',
          tanggal: '12 Agustus 2025',
          penjelasan: 'Teks ini menjelaskan isi dari artikel ketiga. Anda bisa menambahkan detail penting yang membuat pembaca ingin tahu lebih banyak tentang topik ini.',
          link: '#'
        }
      ]
    };
  }
};
</script>

<style scoped>

/* Anda bisa menambahkan styling global di sini jika diperlukan */
</style>