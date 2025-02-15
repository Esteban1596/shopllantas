<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'codigo', 'precio', 'existencia'
    ];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class); // Muchos productos pueden estar asociados a un cliente
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class); // Un producto puede tener muchos registros en inventario
    }
}
