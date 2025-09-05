import { createApp } from 'vue'
import './assets/main.css'
import App from './App.vue'
import router from './routes'
import axios from 'axios'
import VueAxios from 'vue-axios'

const app = createApp(App)
app.use(router)
app.mount('#app')
app.use(VueAxios, axios)