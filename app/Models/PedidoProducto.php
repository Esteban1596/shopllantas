<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PedidoProducto extends Model
{
    //
    use HasFactory;

    protected $fillable = ['pedido_id', 'producto_id', 'cantidad', 'precio_unitario'];

    // Relación muchos a uno con Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relación muchos a uno con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
