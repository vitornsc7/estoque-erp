<?php

namespace App\Services;

use App\Models\Produto;

class ProdutoService
{
    /**
     * List all products
     */
    public function listarProdutos()
    {
        return Produto::all(['id', 'nome', 'custo_medio', 'preco_venda', 'estoque']);
    }

    /**
     * Create a new product
     */
    public function criarProduto(array $dados)
    {
        return Produto::create([
            'nome' => $dados['nome'],
            'preco_venda' => $dados['preco_venda'],
            'estoque' => 0,
            'custo_medio' => 0,
        ]);
    }
}