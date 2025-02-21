<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaRealizada extends Model
{
    use HasFactory;
    protected $table = 'ventas_realizadas'; 
    protected $fillable = [
        'cotizacion_id', 'cliente_id', 'fecha_venta', 'total'
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class); // Una venta realizada está asociada a una cotización
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class); // Una venta realizada tiene un producto
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
