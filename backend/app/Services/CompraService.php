<?php

namespace App\Services;

use App\Models\Compra;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class CompraService
{
    public function registrarCompra(array $dados): Compra
    {
        return DB::transaction(function () use ($dados) {
            // Criar a compra
            $compra = Compra::create([
                'fornecedor' => $dados['fornecedor']
            ]);

            foreach ($dados['produtos'] as $item) {
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

            return $compra;
        });
    }
}