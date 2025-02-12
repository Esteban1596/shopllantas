<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotizacion extends Model
{
    //
    use HasFactory;

    protected $fillable = ['cliente_id', 'total'];

    // Relación muchos a uno con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación muchos a muchos con Productos a través de cotizaciones_productos
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'cotizaciones_productos')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }
}
