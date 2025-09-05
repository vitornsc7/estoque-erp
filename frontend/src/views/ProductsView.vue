<template>
  <div class="container">
    <ProdutoCadastro @atualizar="atualizarProdutos" />
    <ProdutoLista ref="listaProdutos" />
  </div>
</template>

<script setup>
import ProdutoCadastro from '../components/ProdutoCadastro.vue'
import ProdutoLista from '../components/ProdutoLista.vue'

import { ref } from 'vue'

const listaProdutos = ref(null)

const atualizarProdutos = () => {
  listaProdutos.value.carregarProdutos()
}
</script>

<style>
.container {
  max-width: 800px;
  margin: auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}
</style>
