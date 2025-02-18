<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'codigo_pedido',
        'nombre',
        'cliente_id',
        'productos',
        'fecha',
        'total'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function productosRelacionados() // Cambia el nombre para evitar conflictos
{
    return $this->belongsToMany(Producto::class, 'cotizacion_producto')
                ->withPivot('cantidad', 'precio_unitario');
}
}
