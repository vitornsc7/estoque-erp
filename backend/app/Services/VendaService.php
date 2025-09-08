<?php

namespace App\Services;

use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Exception;

class VendaService
{
    public function registrarVenda(array $dados)
    {
        return DB::transaction(function () use ($dados) {
            $venda = Venda::create([
                'cliente' => $dados['cliente'],
            ]);

            $total = 0;
            $lucro = 0;

            foreach ($dados['produtos'] as $item) {
                $produto = Produto::findOrFail($item['id']);

                if ($produto->estoque < $item['quantidade']) {
                    throw new Exception("Estoque insuficiente para o produto {$produto->nome}");
                }

                // Baixar estoque
                $produto->update([
                    'estoque' => $produto->estoque - $item['quantidade'],
                ]);

                // Calcular valores
                $subtotal = $item['preco_unitario'] * $item['quantidade'];
                $lucroItem = ($item['preco_unitario'] - $produto->custo_medio) * $item['quantidade'];

                $total += $subtotal;
                $lucro += $lucroItem;

                $venda->produtos()->attach($produto->id, [
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario'],
                ]);
            }

            $venda->update([
                'total' => $total,
                'lucro' => $lucro,
            ]);

            return $venda;
        });
    }

    public function cancelarVenda(int $vendaId)
    {
        return DB::transaction(function () use ($vendaId) {
            $venda = Venda::with('produtos')->findOrFail($vendaId);

            foreach ($venda->produtos as $produto) {
                $produto->update([
                    'estoque' => $produto->estoque + $produto->pivot->quantidade,
                ]);
            }

            $venda->delete();

            return ['message' => 'Venda cancelada e estoque revertido.'];
        });
    }
}