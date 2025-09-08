<template>
	<div class="container">
		<VendaRegistro tipo="venda" />
		<VendaCancelar />
	</div>
</template>

<script setup>
import VendaRegistro from '../components/RegistroMovimentacao.vue'
import VendaCancelar from '../components/VendaCancelar.vue'
</script>