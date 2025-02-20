<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'telefono', 'celular', 'email', 'nombre_comercial', 'direccion', 'website'
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
}
