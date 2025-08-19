<template>
    <div class="container">
        <h1></h1>
    </div>
  <div class="card-page">
    <div class="card-container">
      <CardItem 
        v-for="card in cards" 
        :key="card.id" 
        :cardData="card" 
      />
    </div>
  </div>
</template>

<script>
import CardItem from '../components/siaranpers/CardItem.vue'; // Sesuaikan path jika folder CardItem berbeda

// Impor gambar dari folder assets
import image1 from '@/assets/img/1.jpeg';
import image2 from '@/assets/img/2.jpeg';
import image3 from '@/assets/img/3.jpg';
import image4 from '@/assets/img/4.jpg';

export default {
  name: 'SiaranPers',
  components: {
    CardItem,
  },
  data() {
    return {
      cards: [
        {
          id: 1,
          title: 'Pengenalan Keterbukaan Informasi Publik',
          description: 'Diskominfostandi Kota Depok menggelar sosialisasi Pengenalan Keterbukaan Informasi Publik (KIP) dengan tema “Pola Interaksi dan Pola Komunikasi di Era Digital” di Balai Kota Depok pada 26 Juli 2023.',
          imageUrl: image1,
        },
        {
          id: 2,
          title: 'Gerakan Masyarakat Hidup Sehat',
          description: 'Diskominfostandi Kota Depok bersama perangkat daerah lainnya turut menyukseskan Gerakan Masyarakat Hidup Sehat dengan 15.000 peserta senam di Lapangan Balai Kota Depok.',
          imageUrl: image2,
        },
        {
          id: 3,
          title: 'Peringatan Hari Pers Nasional 2024',
          description: 'Walikota Depok, Mohammad Idris, secara simbolis menyerahkan piagam penghargaan dan santunan kepada 5 orang jurnalis Kota Depok saat acara Peringatan Hari Pers Nasional 2024.',
          imageUrl: image3,
        },
        {
          id: 4,
          title: 'Penyerahan Santunan Satlinmas Program JKK-JKM',
          description: 'Diskominfostandi Kota Depok menyerahkan santunan Jaminan Kematian (JKK) kepada 28 orang Satuan Perlindungan Masyarakat (Satlinmas) di Aula Balai Kota Depok.',
          imageUrl: image4,
        },
      ],
    };
  },
};
</script>

<style scoped>
.card-page {
    margin-top: 5%;
  font-family: 'RobotoDraft', 'Roboto', sans-serif;
  background-color: #f2f2f2;
  padding: 2rem;
}

.card-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  justify-items: center;
}
</style>