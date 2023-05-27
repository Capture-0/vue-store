import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import defaultMixin from "@/includes/default";

var app = createApp(App);
app.mixin(defaultMixin);
app.use(router);
app.mount('#app');
