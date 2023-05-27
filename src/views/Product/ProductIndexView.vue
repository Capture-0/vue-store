<template>
    <Header></Header>
    <section class="products">
        <div>
            <input placeholder="search" @input="search">
            sort: <select @change="sort">
                <option value="name">name</option>
                <option value="time">time</option>
                <option value="price">price</option>
            </select>
        </div>
        <h2>Products</h2>
        <div>
            <div @click="navigate(i.id)" v-for="i in manipulated">
                <img :src="'/data/' + i.image" alt="">
                <h4 v-text="i.name"></h4>
                <span v-text="i.price + '$'"></span>
                <button @click.stop="AddToCart(i)">add</button>
            </div>
        </div>
    </section>
</template>
<script>
import Header from "@/components/Header.vue"
export default {
    components: { Header },
    data() {
        return {
            products: [],
            manipulated: []
        }
    },
    methods: {
        search(e) {
            this.manipulated = this.products.filter(x => x.name.toLowerCase().includes(e.target.value.toLowerCase()));
        },
        navigate(i) {
            this.$router.push("/prods/" + i);
        },
        sort(e) {
            this.manipulated = this.manipulated.sort((a, b) => {
                if (e.target.value == "price") {
                    if (a.price < b.price) return -1;
                    if (a.price > b.price) return 1;
                    return 0;
                } else if (e.target.value == "name") {
                    if (a.name < b.name) return -1;
                    if (a.name > b.name) return 1;
                    return 0;
                } else {
                    if (a.id < b.id) return -1;
                    if (a.id > b.id) return 1;
                    return 0;
                }
            });
        }
    },
    mounted() {
        fetch('http://localhost:3000/public/api/handler.php?o=getpost').then(res => res.json()).then(json => {
            this.products = json;
            this.manipulated = json
        });
    }
}
</script>
<style lang="scss">
.products {
    font-family: sans-serif;
    display: flex;
    flex-direction: column;
    margin-inline: auto;
    width: 960px;
    max-width: 90%;

    &>div {
        display: flex;
        flex-wrap: wrap;
        gap: 1em;

        &>div {
            display: flex;
            gap: 0.6em;
            flex-direction: column;
            width: 8em;

            &>img {
                width: 100%;
                height: 100%;
                aspect-ratio: 1/1;
                object-fit: cover;
            }

            &>h4 {
                margin: 0;
            }
        }
    }
}
</style>