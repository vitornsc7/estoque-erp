<template>
  <section class="card">
    <div class="card-header">
      <h2>{{ titulo }}</h2>
      <p>{{ descricao }}</p>
    </div>

    <form @submit.prevent="registrarMovimentacao">
      <div class="form-group">
        <label :for="campoId">{{ campoLabel }}:</label>
        <input
          :id="campoId"
          v-model="movimentacao[campoId]"
          type="text"
          :placeholder="campoPlaceholder"
          required
        />
      </div>

      <div class="form-group">
        <label>Produtos:</label>
        <div v-if="produtosErro" class="erro-produtos">{{ produtosErro }}</div>
        <table class="produtos-table" v-if="!produtosErro">
          <thead>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preço Unitário</th>
              <th v-if="movimentacao.produtos.length > 1">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in movimentacao.produtos" :key="index">
              <td>
                <select v-model.number="item.id" required>
                  <option disabled :value="null">Selecione</option>
                  <option v-for="p in produtos" :key="p.id" :value="p.id">
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
              <td v-if="movimentacao.produtos.length > 1">
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
        <button class="btn-produto" @click.prevent="adicionarProduto" type="button">Adicionar Produto</button>
        <button type="submit">{{ botaoTexto }}</button>
      </div>
    </form>
  </section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import api from '../services/api'

const props = defineProps({
  tipo: { type: String, required: true }
})

const titulo = props.tipo === 'compra' ? 'Registrar Compra' : 'Registrar Venda'
const descricao =
  props.tipo === 'compra'
    ? 'Preencha os dados para registrar uma nova compra no sistema'
    : 'Preencha os dados para registrar uma nova venda no sistema'
const campoLabel = props.tipo === 'compra' ? 'Fornecedor' : 'Cliente'
const campoId = props.tipo === 'compra' ? 'fornecedor' : 'cliente'
const campoPlaceholder =
  props.tipo === 'compra' ? 'Ex: Empresa XYZ' : 'Ex: Fulano da Silva'
const botaoTexto = props.tipo === 'compra' ? 'Registrar Compra' : 'Registrar Venda'

const movimentacao = reactive({
  [campoId]: '',
  produtos: [{ id: null, quantidade: 1, preco_unitario: 0 }]
})

const produtos = ref([])
const produtosErro = ref('')

const carregarProdutos = async () => {
  try {
    const { data } = await api.get('/produtos')
    produtos.value = data
    produtosErro.value = ''
  } catch (error) {
    produtosErro.value = 'Erro ao carregar produtos. Tente novamente mais tarde.'
    produtos.value = []
  }
}

onMounted(carregarProdutos)

const adicionarProduto = () => {
  movimentacao.produtos.push({
    id: null,
    quantidade: 1,
    preco_unitario: 0
  })
}

const removerProduto = (index) => {
  if (movimentacao.produtos.length > 1) {
    movimentacao.produtos.splice(index, 1)
  }
}

const registrarMovimentacao = async () => {
  const rota = props.tipo === 'compra' ? '/compras' : '/vendas'
  await api.post(rota, movimentacao)

  // resetar formulário
  movimentacao[campoId] = ''
  movimentacao.produtos = [{ id: null, quantidade: 1, preco_unitario: 0 }]
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
.btn-produto { background: var(--border-color); color: var(--text-primary);}

.erro-produtos {
  color: #d32f2f;
  margin-bottom: 10px;
  font-size: 14px;
}

</style>