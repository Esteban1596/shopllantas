<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_pedido', 'nombre', 'productos', 'fecha', 'total', 'cliente_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class); // Cada cotización pertenece a un cliente
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'cotizaciones_productos', 'cotizacion_id', 'producto_id');
        // Una cotización puede tener muchos productos, a través de la tabla intermedia cotizaciones_productos
    }
}
