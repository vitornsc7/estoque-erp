<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = ['fornecedor'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'compra_produto')
                    ->withPivot('quantidade', 'preco_unitario')
                    ->withTimestamps();
    }
}