<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    //
    use HasFactory;

    protected $fillable = ['cliente_id', 'user_id', 'total'];

    // Relación muchos a uno con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación muchos a uno con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a muchos con Productos a través de pedidos_productos
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedidos_productos')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }

    // Relación uno a muchos con Facturas
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
