<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'nombre', 'email', 'telefono'];

    // Relación inversa de muchos a uno con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación uno a muchos con Cotizaciones
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }

    // Relación uno a muchos con Pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

}
