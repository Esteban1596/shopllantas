<?php

namespace App\Http\Controllers;

use App\Models\CotizacionProducto;
use Illuminate\Http\Request;

class CotizacionProductoController extends Controller
{
    public function store(Request $request)
{
    $productos = json_decode($request->productos_json);

    foreach ($productos as $producto) {
        CotizacionProducto::create([
            'cotizacion_id' => $request->cotizacion_id, // ID de la cotización
            'producto_id' => $producto->id, // ID del producto
            'cantidad' => $producto->cantidad, // Cantidad
            'precio_unitario' => $producto->precio, // Precio unitario
        ]);
    }

    return redirect()->route('cotizaciones.index')->with('success', 'Cotización guardada con éxito.');
}

}
