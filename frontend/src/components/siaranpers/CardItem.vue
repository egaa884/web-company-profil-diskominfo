<template>
  <div class="property-card">
    <div class="property-image" :style="{ backgroundImage: 'url(' + cardData.imageUrl + ')' }">
      </div>
    <div class="property-description">
      <h5>{{ cardData.title }}</h5>
      <p>{{ cardData.description }}</p>
    </div>
    <a href="#">
      <div class="property-social-icons">
        </div>
    </a>
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
</style>