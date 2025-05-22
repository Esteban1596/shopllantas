<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Cotizacion;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $productos = Producto::all(); 
        $clientes = Cliente::all();    
        return view('dashboard', compact('productos', 'clientes'));
    }

    /**
     * Guarda la cotización seleccionada.
     */
    public function storeCotizacion(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre_cotizacion' => 'required|string|max:255',
            'productos' => 'required|array',
        ]);

        // Guardar la cotización
        $cotizacion = new Cotizacion();
        $cotizacion->cliente_id = $validated['cliente_id'];
        $cotizacion->nombre_cotizacion = $validated['nombre_cotizacion'];
        $cotizacion->save();

        foreach ($validated['productos'] as $producto) {
            // Logica para asociar productos a la cotización
        }

        return response()->json(['success' => 'Cotización guardada exitosamente']);
    }
}
