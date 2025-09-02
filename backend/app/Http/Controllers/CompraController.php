<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fornecedor' => 'required|string|max:255',
            'produtos' => 'required|array|min:1',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.preco_unitario' => 'required|numeric|min:0'
        ]);

        DB::transaction(function () use ($request) {
            // Criar a compra
            $compra = Compra::create([
                'fornecedor' => $request->fornecedor
            ]);

            foreach ($request->produtos as $item) {
                $produto = Produto::find($item['id']);

                // Atualiza estoque
                $estoqueAntigo = $produto->estoque ?? 0;
                $novoEstoque = $estoqueAntigo + $item['quantidade'];

                // Atualiza custo médio
                $custoAntigo = $produto->custo_medio ?? 0;
                $quantidadeAntiga = $estoqueAntigo;
                $quantidadeNova = $item['quantidade'];

                $custoMedio = ($custoAntigo * $quantidadeAntiga + $item['preco_unitario'] * $quantidadeNova)
                            / max(($quantidadeAntiga + $quantidadeNova), 1);

                $produto->update([
                    'estoque' => $novoEstoque,
                    'custo_medio' => $custoMedio
                ]);

                // Relaciona produto à compra
                $compra->produtos()->attach($produto->id, [
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario']
                ]);
            }
        });

        return response()->json(['message' => 'Compra registrada com sucesso!'], 201);
    }
}