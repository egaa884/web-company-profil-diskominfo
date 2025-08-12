<template>
  <div class="blog-card" :class="{ alt: isAlt }">
    <div class="meta">
      <div class="photo" :style="{ backgroundImage: 'url(' + photo + ')' }"></div>
      <ul class="details">
        <li class="author"><a href="#">{{ author }}</a></li>
        <li class="date">{{ date }}</li>
        <li class="tags">
          <ul>
            <li v-for="tag in tags" :key="tag"><a href="#">{{ tag }}</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="description">
      <h1>{{ title }}</h1>
      <h2>{{ subtitle }}</h2>
      <p>{{ description }}</p>
      <p class="read-more">
        <a href="#">Read More</a>
      </p>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  title: String,
  subtitle: String,
  author: String,
  date: String,
  tags: Array,
  description: String,
  photo: String,
  isAlt: {
    type: Boolean,
    default: false
  }
});
</script>

<style scoped>
.blog-card {
  display: flex;
  flex-direction: column;
  margin: 1rem auto;
  box-shadow: 0 3px 7px -1px rgba(0, 0, 0, 0.1);
  margin-bottom: 1.6%;
  background: #fff;
  line-height: 1.4;
  font-family: sans-serif;
  border-radius: 5px;
  overflow: hidden;
  z-index: 0;
  height: 400px; /* --- PERUBAHAN: TINGGI CARD DIBUAT TETAP --- */
}

.blog-card a {
  color: inherit;
  text-decoration: none;
}

.blog-card a:hover {
  color: #3b70fc;
}

.blog-card:hover .photo {
  transform: scale(1.3) rotate(3deg);
}

.blog-card .meta {
  position: relative;
  z-index: 0;
  height: 200px;
}

.blog-card .photo {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-size: cover;
  background-position: center;
  transition: transform 0.2s;
}

.blog-card .details,
.blog-card .details ul {
  margin: auto;
  padding: 0;
  list-style: none;
}

.blog-card .details {
  position: absolute;
  top: 0;
  bottom: 0;
  left: -100%;
  margin: auto;
  transition: left 0.2s;
  background: rgba(0, 0, 0, 0.6);
  color: #fff;
  padding: 20px;
  width: 100%;
  font-size: 0.9rem;
}

.blog-card .details a {
  text-decoration: dotted underline;
}

.blog-card .details ul li {
  display: inline-block;
}

.blog-card .details .author::before {
  content: "👤";
  margin-right: 10px;
}

.blog-card .details .date::before {
  content: "📅";
  margin-right: 10px;
}

.blog-card .details .tags ul::before {
  content: "🏷️";
  margin-right: 10px;
}

.blog-card .details .tags li {
  margin-right: 2px;
}

.blog-card .details .tags li:first-child {
  margin-left: -4px;
}

.blog-card .description {
  padding: 1rem;
  background: #fff;
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  flex-grow: 1; /* PERBAIKI: Ini penting agar description mengisi sisa ruang */
}

.blog-card .description h1,
.blog-card .description h2 {
  font-family: Poppins, sans-serif;
  font-weight: normal;
}

.blog-card .description h1 {
  line-height: 1;
  margin: 0;
  font-size: 1rem; /* --- PERUBAHAN: UKURAN FONT h1 MENJADI LEBIH KECIL --- */
}

.blog-card .description h2 {
  font-size: 1rem;
  font-weight: 300;
  text-transform: uppercase;
  color: #a2a2a2;
  margin-top: 5px;
}

.blog-card .description .read-more {
  text-align: right;
  margin-top: auto;
}

.blog-card .description .read-more a {
  color: #3b70fc;
  display: inline-block;
  position: relative;
}

.blog-card .description .read-more a::after {
  content: "→";
  margin-left: -10px;
  opacity: 0;
  vertical-align: middle;
  transition: margin 0.3s, opacity 0.3s;
}

.blog-card .description .read-more a:hover::after {
  margin-left: 5px;
  opacity: 1;
}

.blog-card .description p {
  position: relative;
  margin: 1rem 0 0;
}

.blog-card .description p:first-of-type {
  margin-top: 1.25rem;
}

.blog-card .description p:first-of-type::before {
  content: "";
  position: absolute;
  height: 5px;
  background: #3b70fc;
  width: 35px;
  top: -0.75rem;
  border-radius: 3px;
}

.blog-card:hover .details {
  left: 0%;
}

@media (min-width: 640px) {
  .blog-card {
    flex-direction: row;
    max-width: 800px;
    height: 200px; /* --- PERUBAHAN: TINGGI CARD SAAT LAYAR LEBAR DIBUAT TETAP --- */
  }
  .blog-card .meta {
    flex-basis: 30%;
    height: auto;
  }
  .blog-card .description {
    flex-basis: 60%;
    position: relative;
    display: flex;
    flex-direction: column;
  }
  .blog-card .description::before {
    content: "";
    background: #fff;
    width: 30px;
    position: absolute;
    left: -10px;
    top: 0;
    bottom: 0;
    z-index: -1;
    transform: skewX(-3deg);
  }
  .blog-card.alt {
    flex-direction: row-reverse;
  }
  .blog-card.alt .description::before {
    left: inherit;
    right: -10px;
    transform: skewX(3deg);
  }
  .blog-card.alt .details {
    padding-left: 25px;
  }
}
</style>