<template>
  <div class="property-card">
    <!-- Image Gallery -->
    <div class="image-gallery" v-if="cardData.images && cardData.images.length > 0">
      <div
        v-for="(image, index) in cardData.images.slice(0, 3)"
        :key="image.id"
        class="gallery-image"
        :style="{ backgroundImage: 'url(' + image.image_url + ')' }"
        :class="{ 'active': index === 0 }"
      >
        <div v-if="cardData.images.length > 3 && index === 2" class="more-images">
          +{{ cardData.images.length - 3 }}
        </div>
      </div>
    </div>
    <!-- Single Image Fallback -->
    <div v-else class="property-image" :style="{ backgroundImage: 'url(' + cardData.imageUrl + ')' }">
    </div>

    <div class="property-description">
      <h5>{{ cardData.title }}</h5>
      <p>{{ cardData.description }}</p>
    </div>

    <!-- PDF Download Link -->
    <a v-if="cardData.pdfUrl" :href="cardData.pdfUrl" target="_blank" class="pdf-download-link">
      <div class="property-social-icons pdf-icon">
        📄
      </div>
    </a>
    <!-- Default icon if no PDF -->
    <div v-else class="property-social-icons default-icon">
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardItem',
  props: {
    cardData: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
};
</script>

<style scoped>
/*
  ==========================================
  Kode CSS dari wpdean.com
  ==========================================
*/
.property-card
{
  height:18em;
  width:14em;
  display:flex;
  flex-direction:column;
  position:relative;
  transition:all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
  border-radius:16px;
  overflow:hidden;
  box-shadow:  15px 15px 27px #e1e1e3, -15px -15px 27px #ffffff;
}

.property-image
{
  height:6em;
  width:14em;
  padding:1em 2em;
  position:absolute;
  top:0px;
  transition:all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
  background-size:cover;
  background-repeat:no-repeat;
  background-position: center;
}

.property-description
{
  background-color: #FAFAFC;
  height:12em;
  width:14em;
  position:absolute;
  bottom:0em;
  transition:all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
  padding: 0.5em 1em;
  text-align:center;
}

h5
{
  margin:0px;
  font-size:1.4em;
  font-weight:700;
}

p
{
  font-size:12px;
}

.property-social-icons
{
  width:1em;
  height:1em;
  background-color:black;
  position:absolute;
  bottom:1em;
  left:1em;
  transition:all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
}

.property-card:hover .property-description
{
  height:0em;
  padding:0px 1em;
}

.property-card:hover .property-image
{
  height:18em;
}

.property-card:hover .property-social-icons
{
  background-color:white;
}

.property-card:hover .property-social-icons:hover
{
  background-color:blue;
  cursor:pointer;
}

/* PDF Download Link Styles */
.pdf-download-link
{
  text-decoration: none;
  position: absolute;
  bottom: 1em;
  left: 1em;
  z-index: 10;
}

.pdf-icon
{
  width: 1em;
  height: 1em;
  background-color: #dc3545;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 0.8em;
  transition: all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
}

.default-icon
{
  width: 1em;
  height: 1em;
  background-color: black;
  position: absolute;
  bottom: 1em;
  left: 1em;
  transition: all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
}

.property-card:hover .pdf-icon
{
  background-color: #c82333;
  transform: scale(1.1);
}

.property-card:hover .default-icon
{
  background-color: white;
}

/* Image Gallery Styles */
.image-gallery
{
  height: 6em;
  width: 14em;
  position: absolute;
  top: 0px;
  display: flex;
  transition: all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
}

.gallery-image
{
  flex: 1;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  transition: all 0.4s cubic-bezier(0.645, 0.045, 0.355, 1);
  position: relative;
}

.gallery-image.active
{
  flex: 2;
}

.more-images
{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 1.2em;
}

.property-card:hover .image-gallery
{
  height: 18em;
}

.property-card:hover .gallery-image
{
  flex: 1;
}

.property-card:hover .gallery-image.active
{
  flex: 3;
}
</style>