import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./router";
import App from "./App.vue";
import "./style.css";

import Toast from "vue-toastification"; // <-- Impor Toast
import "vue-toastification/dist/index.css"; // <-- Impor CSS-nya

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(Toast); // <-- Gunakan Toast

app.mount("#app");
