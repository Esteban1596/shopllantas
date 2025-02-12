<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CotizacionProducto extends Model
{
    //
    use HasFactory;

    protected $fillable = ['cotizacion_id', 'producto_id', 'cantidad', 'precio_unitario'];

    // Relación muchos a uno con Cotizacion
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    // Relación muchos a uno con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
