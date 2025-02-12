<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factura extends Model
{
    //
    use HasFactory;

    protected $fillable = ['pedido_id', 'numero_factura'];

    // Relación muchos a uno con Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
