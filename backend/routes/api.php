<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VendaController;

Route::get('/produtos', [ProdutoController::class, 'index']);
Route::post('/produtos', [ProdutoController::class, 'store']);
Route::post('/compras', [CompraController::class, 'store']);
Route::post('/vendas', [VendaController::class, 'store']);
Route::delete('/vendas/{id}', [VendaController::class, 'destroy']);