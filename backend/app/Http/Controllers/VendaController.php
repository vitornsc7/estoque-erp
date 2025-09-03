<?php

namespace App\Http\Controllers;

use App\Services\VendaService;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    protected $vendaService;

    public function __construct(VendaService $vendaService)
    {
        $this->vendaService = $vendaService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente' => 'required|string|max:255',
            'produtos' => 'required|array|min:1',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'produtos.*.preco_unitario' => 'required|numeric|min:0',
        ]);

        try {
            $venda = $this->vendaService->registrarVenda($validated);
            return response()->json([
                'message' => 'Venda registrada com sucesso!',
                'total' => $venda->total,
                'lucro' => $venda->lucro,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $res = $this->vendaService->cancelarVenda($id);
            return response()->json($res, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}