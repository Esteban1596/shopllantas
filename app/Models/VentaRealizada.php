<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaRealizada extends Model
{
    use HasFactory;

    protected $fillable = [
        'cotizacion_id', 'producto_id', 'cantidad', 'total', 'fecha'
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class); // Una venta realizada está asociada a una cotización
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class); // Una venta realizada tiene un producto
    }
}
