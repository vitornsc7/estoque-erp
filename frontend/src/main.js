import { createApp } from 'vue'
import './assets/main.css'
import App from './App.vue'
import router from './routes'
import axios from 'axios'
import VueAxios from 'vue-axios'

const app = createApp(App).use(router).mount('#app')
app.use(VueAxios, axios)
app.config.globalProperties.axios = axios
app.config.globalProperties.axios.defaults.baseURL = 'http://localhost:8000/api'