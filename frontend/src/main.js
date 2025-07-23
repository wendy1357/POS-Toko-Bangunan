import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router'; // Impor router kita
import App from './App.vue';
import './style.css'; // Impor Tailwind CSS

const app = createApp(App);
const pinia = createPinia();

app.use(pinia); // Gunakan Pinia
app.use(router); // Gunakan Router

app.mount('#app');
