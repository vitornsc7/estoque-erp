<template>
  <section class="card">
    <div class="card-header">
      <h2>Cadastro de Produto</h2>
      <p>Preencha os dados para cadastrar um novo produto no sistema</p>
    </div>
    <form @submit.prevent="cadastrarProduto" class="form">
      <div>
        <label for="nome">Nome do Produto:</label>
        <input v-model="produto.nome" placeholder="Ex: Teclado MTX40" />
      </div>
      <div class="form-group">
        <label for="preco">Preço de Venda:</label>
        <div class="input-wrapper">
          <span class="input-prefix">R$</span>
          <input
            id="preco"
            v-model.number="produto.preco_venda"
            type="number"
            min="0"
            step="0.01"
            placeholder="0,00"
            required
          />
        </div>
      </div>
      <button type="submit">Cadastrar Produto</button>
    </form>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import api from '../services/api'

const emit = defineEmits(['atualizar'])
const produto = ref({ nome: '', preco_venda: 0 })

const cadastrarProduto = async () => {
  await api.post('/produtos', produto.value)
  produto.value = { nome: '', preco_venda: 0 }
  emit('atualizar')
}
</script>

<style scoped>
.form { display: flex; flex-direction: column; gap: 12px; }
.input-wrapper { position: relative; display: flex; align-items: center; }
.input-prefix { position: absolute; left: 12px; color: var(--text-secondary); font-size: 14px; pointer-events: none; }
.input-wrapper input { padding-left: 36px; }
</style>