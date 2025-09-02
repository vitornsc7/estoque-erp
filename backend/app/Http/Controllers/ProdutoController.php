<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // List products
    public function index()
    {
        return Produto::all(['id', 'nome', 'custo_medio', 'preco_venda', 'estoque']);
    }

    // Store new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|min:3',
            'preco_venda' => 'required|numeric|min:0',
        ]);

        $produto = Produto::create([
            'nome' => $validated['nome'],
            'preco_venda' => $validated['preco_venda'],
            'estoque' => 0,
            'custo_medio' => 0,
        ]);

        return response()->json($produto, 201);
    }
}