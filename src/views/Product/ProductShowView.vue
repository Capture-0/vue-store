<template>
    <Header></Header>
    <article>
        <div>
            <img :src="'/data/' + product.image" alt="">
            <div>
                <h3 v-text="product.name"></h3>
                <span v-text="product.price"></span>
                <button @click="AddToCart(product)">add</button>
            </div>
        </div>
        <p v-text="product.desc"></p>
    </article>
</template>
<script>
import Header from '@/components/Header.vue';

export default {
    components: { Header },
    data() {
        return {
            product: []
        }
    },
    mounted() {
        fetch('http://localhost:3000/public/api/handler.php?o=getpost&id=' + this.$route.params.id).then(res => res.json()).then(json => {
            this.product = json;
        });
    }
}
</script>
<style lang="scss">
article {
    margin-inline: auto;
    width: 960px;
    max-width: 90%;
    display: flex;
    flex-direction: column;

    &>div {
        display: flex;
        gap: 1em;

        &>img{
            width: 20vw;
        }
        &>div {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    }
}
</style>