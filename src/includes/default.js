export default {
    methods: {
        AddToCart(id) {
            if (!sessionStorage.getItem("items"))
                sessionStorage.setItem("items", JSON.stringify([id]));
            else {
                let a = JSON.parse(sessionStorage.getItem("items"));
                a.push(id);
                sessionStorage.setItem("items", JSON.stringify(a));
            }
        }
    }
}