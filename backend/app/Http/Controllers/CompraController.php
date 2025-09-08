<?php

namespace App\Http\Controllers;

use App\Services\CompraService;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    protected $compraService;

    public function __construct(CompraService $compraService)
    {
        $this->compraService = $compraService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'fornecedor' => 'required|string|max:255',
            'produtos' => 'required|array|min:1',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.preco_unitario' => 'required|numeric|min:0'
        ]);

        $compra = $this->compraService->registrarCompra($request->all());

        return response()->json([
            'message' => 'Compra registrada com sucesso!',
            'compra_id' => $compra->id
        ], 201);
    }
}