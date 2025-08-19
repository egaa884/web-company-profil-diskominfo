<template>
  <div class="card-list-container">
    <div class="card-grid">
      <div v-for="card in cards" :key="card.id" class="card">
        <img :src="card.foto" :alt="card.judul" />
        <div class="card-content">
          <h3 class="card-title">{{ card.judul }}</h3>
          <p class="card-date">{{ card.tanggal }}</p>
          <p class="card-description">{{ card.penjelasan }}</p>
          <a :href="card.link" class="card-button">Selengkapnya</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardList',
  props: {
    cards: {
      type: Array,
      required: true
    }
  }
};
</script>

<style scoped>
.card-list-container {
  padding: 20px;
}

.card-grid {
  display: grid;
  /* MODIFIKASI HANYA DI BAGIAN INI */
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.card-content {
  padding: 15px;
}

.card-title {
  font-size: 1.5em;
  margin: 0 0 10px;
  color: #333;
}

.card-date {
  font-size: 0.9em;
  color: #666;
  margin-bottom: 10px;
}

.card-description {
  font-size: 1em;
  color: #555;
  line-height: 1.5;
}

.card-button {
  display: inline-block;
  margin-top: 15px;
  padding: 10px 15px;
  background-color: #007bff;
  color: #fff;
  text-align: center;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.2s ease;
}

.card-button:hover {
  background-color: #0056b3;
}
</style>