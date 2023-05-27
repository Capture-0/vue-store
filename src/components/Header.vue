<template>
    <div id="menu">
        <h3>Cart</h3>
        <div v-if="cartUpader" v-for="(i, index) in Cart()">
            <img :src="i.thumbnail" alt="">
            <div>
                <h4 v-text="i.brand"></h4>
                <div>
                    <span v-text="i.price + '$'"></span>
                    <i @click.stop.prevent="RemoveFromCart($event, index)" class="fa-solid fa-xmark"></i>
                </div>
            </div>
        </div>
    </div>
    <header>
        <h3><router-link to="/">STORE</router-link></h3>
        <nav>
            <router-link to="/prods">Products</router-link>
            <router-link to="/">Contribute</router-link>
            <router-link to="/">About us</router-link>
        </nav>
        <div>
            <img src="@/assets/user.png" alt="">
            <ul>
                <li @click="OpenAuth"><i class="fa-solid fa-user"></i>panel</li>
                <li @click="OpenCart"><i class="fa-solid fa-cart-shopping"></i>cart</li>
                <li><i class="fa-solid fa-percent"></i>promotion</li>
                <li @click="Logout" v-if="LoggedIn()"><i class="fa-solid fa-arrow-right-from-bracket"></i>logout</li>
            </ul>
        </div>
    </header>
</template>
<script>
export default {
    methods: {
        OpenAuth() {
            if (sessionStorage.token) {
                let x = sessionStorage.token;
                if (JSON.parse(atob(x.split(".")[1]))["role"] == 1) {
                    this.$router.push("/panel/user");
                } else if (JSON.parse(atob(x.split(".")[1]))["role"] == 0) {
                    this.$router.push("/panel/manage");
                }
            } else
                document.querySelector("section#auth").style.display = "block";
        },
        OpenCart() {
            var menu = document.querySelector("#menu");
            setTimeout(() => {
                menu.style.left = "0px";
            }, 10);
            this.cartUpader++;
        },
        RemoveFromCart(e, i) {
            e.target.parentNode.parentNode.parentNode.remove();
            var a = JSON.parse(sessionStorage.getItem("items"));
            a.splice(i, 1);
            sessionStorage.setItem("items", JSON.stringify(a));
        },
        Logout() {
            document.querySelector("#app > header > div > ul > li:nth-child(4)").remove();
            sessionStorage.token = "";
            this.$router.replace("/");
        },
        LoggedIn() {
            return !!sessionStorage.token;
        },
        Cart() {
            return JSON.parse(sessionStorage.getItem("items"));
        }
    },
    data() {
        return { cartUpader: 1 };
    },
    mounted() {
        document.body.addEventListener("click", function (e) {
            var menu = document.querySelector("#menu");
            if ((menu.style.left == 0 || menu.style.left == "0px" || menu.style.left == "") && !menu.contains(e.target)) {
                menu.style.left = -menu.getBoundingClientRect().width + "px";
                e.preventDefault();
            }
        })
    }
}
</script>
<style lang="scss">
#menu {
    z-index: 10;
    position: fixed;
    top: 0;
    left: -100%;
    transition: left 200ms ease-in-out;
    height: 100vh;
    padding: 0 1em;
    box-shadow: 0 0 4px 2px silver;
    min-width: 20vw;
    max-width: 90vw;
    background-color: #fff;
    font-family: sans-serif;

    &>div {
        display: flex;
        gap: 0.4em;
        width: 100%;

        &>img {
            width: 3em;
        }

        &>div {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;

            &>h4 {
                margin: 0;
                font-weight: normal;
            }

            &>div {
                display: flex;
                justify-content: space-between;
                align-items: center;

                &>span {
                    font-size: 0.8em;
                    font-style: italic;
                }

                &>i {
                    cursor: pointer;
                }
            }
        }
    }
}

header {
    position: sticky;
    top: 0;
    background-color: #fff;
    font-family: sans-serif;
    display: flex;
    align-items: center;
    gap: 1.6em;
    margin-inline: auto;
    width: 960px;
    max-width: 90%;

    &>h3 {
        margin: 0.6em 0;

        &>a {
            text-decoration: none;
            color: #333;
            font-weight: normal;
        }
    }

    &>nav {
        display: flex;
        gap: 0.8em;
    }

    &>div {
        margin-left: auto;
        width: 2em;
        position: relative;

        &:hover>ul {
            display: block;
        }

        &>img {
            width: 100%;
        }

        &>ul {
            list-style-type: none;
            padding: 0.4em 0;
            margin: 0;
            position: absolute;
            display: none;
            font-size: 0.9em;
            color: #333;
            border-radius: 4px;
            box-shadow: 0 0 4px 2px silver;
            background-color: #fff;

            &>li {
                cursor: pointer;
                padding: 0.4em 3em 0.4em 1em;
                display: flex;
                align-items: center;
                gap: 0.4em;

                &:hover {
                    background-color: #ddd;
                }
            }
        }
    }
}
</style>