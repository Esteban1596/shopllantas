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
            'cotizacion_id' => $request->cotizacion_id, 
            'producto_id' => $producto->id, 
            'cantidad' => $producto->cantidad, 
            'precio_unitario' => $producto->precio, 
        ]);
    }

    return redirect()->route('cotizaciones.index')->with('success', 'Cotización guardada con éxito.');
}

}
