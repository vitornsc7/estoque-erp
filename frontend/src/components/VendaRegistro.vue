<template>
  <section class="card">
    <h2>Registrar Venda</h2>
    <form @submit.prevent="registrarVenda" class="form">
      <input v-model="venda.cliente" placeholder="Cliente" />

      <div v-for="(item, index) in venda.produtos" :key="index" class="linha">
        <input v-model.number="item.id" type="number" placeholder="ID Produto" />
        <input v-model.number="item.quantidade" type="number" placeholder="Quantidade" />
        <input v-model.number="item.preco_unitario" type="number" placeholder="Preço Unitário" />
        <button @click.prevent="removerProduto(index)" class="btn-remover">Remover</button>
      </div>
      <div class="buttons">
        <button @click.prevent="adicionarProduto">+ Produto</button>
        <button type="submit">Registrar Venda</button>
      </div>
    </form>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import api from '../services/api'

const venda = ref({
  cliente: '',
  produtos: [{ id: null, quantidade: null, preco_unitario: null }]
})

const adicionarProduto = () => {
  venda.value.produtos.push({ id: null, quantidade: null, preco_unitario: null })
}
const removerProduto = (i) => venda.value.produtos.splice(i, 1)

const registrarVenda = async () => {
  await api.post('/vendas', venda.value)
  venda.value = { cliente: '', produtos: [{ id: null, quantidade: null, preco_unitario: null }] }
}
</script>

<style scoped>
.form { display: flex; flex-direction: column; gap: 8px; }
.linha { display: flex; gap: 6px; }
.btn-remover {
  background-color: #c0392b;
}
</style>
