<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Cotizacion;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create-productos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|unique:productos',
            'precio' => 'required|numeric',
            'existencia' => 'required|integer|min:0',
        ]);
    
        Producto::create($validated);
         
        return redirect()->route('productos.create')->with('success', 'producto registrado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Verificar si el producto está relacionado con alguna cotización
        $isInCotizacion = Cotizacion::whereHas('productosRelacionados', function($query) use ($producto) {
            $query->where('producto_id', $producto->id);
        })->exists();

        if ($isInCotizacion) {
            // Si está en una cotización, no permitir la eliminación
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar el producto, ya está en una cotización.');
        }

        // Si no está en ninguna cotización, proceder con la eliminación
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

}
