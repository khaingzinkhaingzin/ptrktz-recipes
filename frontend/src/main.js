import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import axios from "axios"

axios.defaults.baseURL = 'http://backend.test';

const app = createApp(App);

app.config.globalProperties.$axios = axios;
app.mount('#app')
