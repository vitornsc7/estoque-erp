<template>
  <header class="app-header">
    <h1>Sistema de Gestão de Estoque</h1>
    <nav>
      <ul class="nav-list">
        <li><router-link to="/" class="nav-link">Produtos</router-link></li>
        <li><router-link to="/compras" class="nav-link">Compras</router-link></li>
        <li><router-link to="/vendas" class="nav-link">Vendas</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<style scoped>
.app-header {
  background: var(--primary-color);
  padding: var(--spacing-md);
  box-shadow: var(--shadow);
  margin-bottom: var(--spacing-md);
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.nav-list {
  display: flex;
  gap: var(--spacing-lg);
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav-link {
  color: white;
  font-weight: 500;
  text-decoration: none;
  transition: var(--transition);
}

.nav-link:hover {
  text-decoration: underline;
}

h1 {
  color: white;
  margin: 0;
  font-size: 1.0rem;
  font-weight: 400;
}

</style>