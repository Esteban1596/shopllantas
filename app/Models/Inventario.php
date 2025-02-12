<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    //
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = ['producto_id', 'cantidad'];

    // Relación muchos a uno con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
