<template>
  <section class="card">
    <h2>Produtos Cadastrados</h2>
    <button @click="carregarProdutos">Atualizar Lista</button>
    <ul class="lista">
      <li v-for="p in produtos" :key="p.id">
        {{ p.id }} - {{ p.nome }} | Preço: R$ {{ p.preco_venda }}
      </li>
    </ul>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const produtos = ref([])

const carregarProdutos = async () => {
  const { data } = await api.get('/produtos')
  produtos.value = data
}

onMounted(carregarProdutos)

defineExpose({ carregarProdutos })
</script>

<style scoped>
ul { margin-top: 10px; padding-left: 20px; }
</style>
