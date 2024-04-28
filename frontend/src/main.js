import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import axios from "axios";
import router from './router/router'

axios.defaults.baseURL = "http://backend.test";

const app = createApp(App);

app.config.globalProperties.$axios = axios;
app.use(router);
app.mount("#app");
