<template>
    <Header></Header>
    <main>
        <h3>add product</h3>
        <form @submit.prevent="submitProduct">
            <input placeholder="name" v-model="fpost.name">
            <input placeholder="price" v-model="fpost.price">
            <input type="file" @change="fileSelected">
            <textarea placeholder="description" v-model="fpost.desc"></textarea>
            <button>add post</button>
        </form>
    </main>
</template>
<script>
import Header from "@/components/Header.vue"
import axios from "axios";

export default {
    components: { Header },
    data() {
        return {
            fpost: {
                name: "",
                price: "",
                desc: "",
                image: null
            }
        }
    },
    methods: {
        submitProduct() {
            let f = new FormData();
            f.append("data", JSON.stringify(this.fpost));
            f.append("image", this.fpost.image);
            axios.post('http://localhost:3000/public/api/handler.php?o=addpost', f, {
                headers: {
                    token: sessionStorage.token,
                    "content-type": "multipart/form-data"
                }
            }).then(x => {
                console.log(x.data);
            });
        },
        fileSelected(e) {
            this.fpost.image = e.target.files[0];
        }
    }
}
</script>
<style lang="scss">
main {
    max-width: 90%;
    width: 960px;
    margin-inline: auto;

    &>form {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 1em;

        &>textarea {
            width: 100%;
            min-height: 10em;
        }

        &>button {
            padding: 0.3em 1em;
        }
    }
}
</style>