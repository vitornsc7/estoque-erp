import { createRouter, createWebHistory } from 'vue-router'
import ProductsView from '../views/ProductsView.vue'
import ComprasView from '../views/ComprasView.vue'
import VendasView from '../views/VendasView.vue'

const routes = [
  { path: '/', component: ProductsView },
  { path: '/compras', component: ComprasView },
  { path: '/vendas', component: VendasView }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
