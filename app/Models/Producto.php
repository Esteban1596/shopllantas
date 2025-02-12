<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    //
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'precio', 'existencia'];

    // Relación muchos a muchos con Cotizaciones a través de cotizaciones_productos
    public function cotizaciones()
    {
        return $this->belongsToMany(Cotizacion::class, 'cotizaciones_productos')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }

    // Relación muchos a muchos con Pedidos a través de pedidos_productos
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedidos_productos')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }

    // Relación uno a muchos con Inventario
    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }
}
