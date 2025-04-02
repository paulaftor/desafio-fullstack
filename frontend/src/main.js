import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import './assets/styles.css' // Importando o arquivo de estilos
import VueTheMask from 'vue-the-mask'

const app = createApp(App);
app.use(router);
app.use(VueTheMask)
app.mount("#app");
