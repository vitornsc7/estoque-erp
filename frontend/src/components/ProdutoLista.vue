<template>
  <section class="card">
    <div class="card-header">
      <h2>Produtos Cadastrados</h2>
      <p>Visualize todos os produtos cadastrados no sistema</p>
    </div>

    <table class="produtos-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome do Produto</th>
          <th>Custo Médio</th>
          <th>Preço de Venda</th>
          <th>Estoque</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="produtos.length === 0">
          <td colspan="5">
            <p>Nenhum produto cadastrado.</p>
          </td>
        </tr>
        <tr v-for="p in produtos" :key="p.id" v-else>
          <td>{{ p.id }}</td>
          <td>{{ p.nome }}</td>
          <td>R$ {{ Number(p.custo_medio).toFixed(2) }}</td>
          <td>R$ {{ Number(p.preco_venda).toFixed(2) }}</td>
          <td>{{ p.estoque }}</td>
        </tr>
      </tbody>
    </table>
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
.produtos-table { width: 100%; border-collapse: collapse; margin-top: var(--spacing-sm); }

.produtos-table th, .produtos-table td { border: 1px solid var(--border-color); padding: var(--spacing-sm); text-align: left; font-size: 14px; }

.produtos-table th { background: #f4f6f8; color: var(--text-secondary); font-weight: 600; }

button { margin: var(--spacing-md) 0; }
</style>
