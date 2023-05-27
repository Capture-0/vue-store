<template>
  <Header></Header>
  <section class="onboard">
    <img src="@/assets/onboard.gif">
    <div>
      <h2>presenting the best products</h2>
      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Minus, odio molestiae dolore nam labore quae in quis
        earum, aliquid accusamus, adipisci quam iste saepe molestias. Tempore voluptatem minus blanditiis illum aut, ipsa
        cum vero! Voluptatem rem, eos ex ad doloremque laborum ducimus, fuga aut voluptas accusantium harum. Consectetur,
        eveniet. Ratione enim impedit voluptatem porro reiciendis minus nihil saepe sapiente eligendi.
        <button>Get Started</button>
      </p>
    </div>
  </section>
  <section class="slider">
    <h3>Featured</h3>
    <span class="scroll" @click="scroll($event)">&lt;</span>
    <span class="scroll" @click="scroll($event, true)" style="right:0">&gt;</span>
    <div>
      <div v-for="i in sliderItems">
        <img :src="i.thumbnail" alt="">
        <h4 v-text="i.brand"></h4>
        <span v-text="i.price + '$'"></span>
      </div>
    </div>
  </section>
  <br v-for="i in 10">
</template>
<script>
import Header from "@/components/Header.vue";
export default {
  components: { Header },
  data() {
    return { sliderItems: [] }
  },
  methods: {
    scroll(e, right = false) {
      e.target.parentNode.querySelector("div").scrollBy(400 * (right ? 1 : -1), 0);
    }
  },
  mounted() {
    fetch("https://dummyjson.com/products?limit=10&skip=30")
      .then(x => x.json()).then(x => this.sliderItems = x.products);
  }
}
</script>
<style lang="scss">
.onboard {
  font-family: sans-serif;
  display: flex;
  gap: 1em;
  align-items: center;
  margin-inline: auto;
  width: 960px;
  max-width: 90%;

  &>img {
    width: 100%;
    aspect-ratio: 5/4;
    object-fit: cover;
  }

  &>div {
    display: flex;
    flex-direction: column;

    &>p {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1em;

      &>button {
        font-family: Arial, Helvetica, sans-serif;
        background-color: royalblue;
        color: #fff;
        padding: 1em;
        outline: none;
        border: none;
      }
    }
  }
}

.slider {
  margin-inline: auto;
  width: 960px;
  max-width: 90%;
  position: relative;
  font-family: sans-serif;

  .scroll {
    position: absolute;
    top: 0.8em;
    font-weight: bolder;
    font-size: 1.4em;
    cursor: pointer;
  }

  &>div {
    display: flex;
    overflow: hidden;
    gap: 1em;
    scroll-behavior: smooth;

    &>div {
      display: flex;
      flex-direction: column;

      &>img {
        width: 10em;
        aspect-ratio: 1/1;
        object-fit: cover;
      }

      &>h4 {
        margin: 0.4em;
      }
    }
  }
}
</style>