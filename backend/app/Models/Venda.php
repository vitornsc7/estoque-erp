<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = ['cliente', 'total', 'lucro'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'venda_produto')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }
}