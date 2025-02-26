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
        return $this->belongsTo(Cotizacion::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }    

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
   
}
