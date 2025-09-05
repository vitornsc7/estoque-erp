<template>
  <section class="card">
    <h2>Cancelar Venda</h2>
    <form @submit.prevent="cancelarVenda" class="form">
      <input v-model.number="vendaId" type="number" placeholder="ID da Venda" />
      <button type="submit" class="btn-cancelar">Cancelar</button>
    </form>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import api from '../services/api'

const vendaId = ref(null)

const cancelarVenda = async () => {
  await api.delete(`/vendas/${vendaId.value}`)
  vendaId.value = null
}
</script>

<style scoped>
.form { display: flex; flex-direction: column; gap: 8px; }
</style>
