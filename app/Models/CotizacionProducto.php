<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CotizacionProducto extends Model
{
    //
    use HasFactory;

    protected $table = 'cotizacion_producto';

    protected $fillable = ['cotizacion_id', 'producto_id', 'cantidad', 'precio_unitario'];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
