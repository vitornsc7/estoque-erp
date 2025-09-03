<?php

namespace App\Http\Controllers;

use App\Services\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    // List products
    public function index()
    {
        return $this->produtoService->listarProdutos();
    }

    // Store new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|min:3',
            'preco_venda' => 'required|numeric|min:0',
        ]);

        $produto = $this->produtoService->criarProduto($validated);

        return response()->json($produto, 201);
    }
}