<template>
  <section class="card">
    <div class="card-header">
      <h2>Registrar Compra</h2>
      <p>Preencha os dados para registrar uma nova compra no sistema</p>
    </div>

    <form @submit.prevent="registrarCompra">
      <div class="form-group">
        <label for="fornecedor">Nome do fornecedor:</label>
        <input
          id="fornecedor"
          v-model="compra.fornecedor"
          type="text"
          placeholder="Ex: Empresa XYZ"
          required
        />
      </div>

      <div class="form-group">
        <label>Produtos:</label>
        <table class="produtos-table">
          <thead>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preço Unitário</th>
              <th v-if="compra.produtos.length > 1">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in compra.produtos" :key="index">
              <td>
                <select v-model="item.id" required>
                  <option disabled value="">Selecione</option>
                  <option v-for="p in produtos" :key="p.id" :value="Number(p.id)">
                    {{ p.nome }}
                  </option>
                </select>
              </td>
              <td>
                <input
                  v-model.number="item.quantidade"
                  type="number"
                  min="1"
                  placeholder="0"
                  required
                />
              </td>
              <td>
                <div class="input-wrapper">
                  <span class="input-prefix">R$</span>
                  <input
                    v-model.number="item.preco_unitario"
                    type="number"
                    min="0"
                    step="0.01"
                    placeholder="0,00"
                    required
                  />
                </div>
              </td>
              <td v-if="compra.produtos.length > 1">
                <button
                  @click.prevent="removerProduto(index)"
                  type="button"
                  class="btn-remover"
                >
                  Remover
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="form-actions">
        <button @click.prevent="adicionarProduto" type="button">Adicionar Produto</button>
        <button type="submit">Registrar Compra</button>
      </div>
    </form>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue"
import api from "../services/api"

const compra = ref({
  fornecedor: "",
  produtos: [{ id: null, quantidade: null, preco_unitario: null }]
})

const produtos = ref([])

const carregarProdutos = async () => {
  const { data } = await api.get("/produtos")
  produtos.value = data
}

onMounted(carregarProdutos)

const adicionarProduto = () => {
  compra.value.produtos.push({
    id: null,
    quantidade: null,
    preco_unitario: null
  })
}
const removerProduto = (i) => {
  if (compra.value.produtos.length > 1) {
    compra.value.produtos.splice(i, 1)
  }
}

const registrarCompra = async () => {
  await api.post("/compras", compra.value)
  compra.value = {
    fornecedor: "",
    produtos: [{ id: null, quantidade: null, preco_unitario: null }]
  }
}
</script>

<style scoped>
.produtos-table { width: 100%; border-collapse: collapse; margin-top: var(--spacing-sm); }

.produtos-table th, .produtos-table td { border: 1px solid var(--border-color); padding: var(--spacing-sm); text-align: left; font-size: 14px; }

.produtos-table th { background: #f4f6f8; color: var(--text-secondary); font-weight: 600; }

.produtos-table td select, .produtos-table td input { width: 100%; }

.input-wrapper { position: relative; display: flex; align-items: center; }

.input-prefix { position: absolute; left: 12px; color: var(--text-secondary); font-size: 14px; pointer-events: none; }

.input-wrapper input { padding-left: 36px; }

.form-actions { display: flex; justify-content: space-between; gap: var(--spacing-sm); margin-top: var(--spacing-md); }

.btn-remover { background: none; color: #46474b; text-decoration: underline; }
</style>