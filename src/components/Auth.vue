<template>
    <section @click.self="close" id="auth">
        <div class="wrapper">
            <div id="login">
                <div>
                    <h4>Login</h4>
                    <a href="#register">register</a>
                </div>
                <span v-text="lflash" v-if="lflash"></span>
                <input v-model="flogin.email" placeholder="email">
                <input v-model="flogin.password" type="password" placeholder="password">
                <input @click.prevent="login" type="submit" value="Login">
            </div>
            <div id="register">
                <div>
                    <h4>Register</h4>
                    <a href="#login">login</a>
                </div>
                <span v-text="rflash" v-if="rflash"></span>
                <input v-model="fregister.email" placeholder="email">
                <input v-model="fregister.password" type="password" placeholder="password">
                <input type="password" placeholder="confirm password">
                <input @click.prevent="register" type="submit" value="Register">
            </div>
        </div>
    </section>
</template>
<script>
export default {
    data() {
        return {
            lflash: "",
            rflash: "",
            flogin: {
                email: "",
                password: ""
            },
            fregister: {
                email: "",
                password: ""
            }
        }
    },
    methods: {
        login() {
            if (!this.flogin.email.match(/^\w+@\w+\.\w+$/g)) {
                this.lflash = "invalid email.";
                return;
            } else this.lflash = "";
            fetch("http://localhost:3000/public/api/handler.php?o=login", {
                method: "POST",
                body: JSON.stringify(this.flogin)
            }).then(x => x.text()).then(x => {
                if (x != "") {
                    this.redirect(x);
                } else
                    this.lflash = "invalid credential.";
            });
        },
        register() {
            if (!this.fregister.email.match(/^\w+@\w+\.\w+$/g)) {
                this.rflash = "invalid email.";
                return;
            } else this.rflash = "";
            fetch("http://localhost:3000/public/api/handler.php?o=register", {
                method: "POST",
                body: JSON.stringify(this.fregister)
            }).then(x => x.text()).then(x => {
                if (x != "") {
                    this.redirect(x);
                } else
                    this.lflash = "invalid credential.";
            });
        },
        redirect(x) {
            sessionStorage.setItem("token", x);
            this.close();
            if (JSON.parse(atob(x.split(".")[1]))["role"] == 1) {
                this.$router.push("/panel/user");
            } else if (JSON.parse(atob(x.split(".")[1]))["role"] == 0) {
                this.$router.push("/panel/manage");
            }
        },
        close() {
            document.querySelector("section#auth").style.display = "none";
        }
    },
}
</script>
<style lang="scss">
section#auth {
    display: none;
    font-family: sans-serif;
    font-size: 1.2rem;
    position: fixed;
    top: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(200, 200, 200, 0.2);

    &>.wrapper {
        max-width: 90vw;
        scroll-behavior: smooth;
        display: flex;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        overflow: hidden;
        box-shadow: 0 0 2px 1px silver;

        &>div {
            flex: 1 0 100%;
            display: flex;
            gap: 1em;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            background-color: #fff;
            padding: 1em;
            position: relative;

            &>div {
                display: flex;
                align-items: center;
                gap: 0.4em;

                &>h4 {
                    margin: 0;
                }

                &>a {
                    position: absolute;
                    right: 1em;
                }
            }

            &>input {
                font-size: 1.2rem;
                outline: none;

                &[type=submit] {
                    padding: 0.3em 1em;
                }

                &:not([type=submit]) {
                    border: 0;
                    border-bottom: 2px royalblue solid;
                    width: 100%;
                }
            }
        }
    }
}
</style>