<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('productos');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|unique:productos',
            'precio' => 'required|numeric',
            'existencia' => 'required|integer|min:0',
        ]);
    
        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'precio' => $request->precio,
            'existencia' => $request->existencia,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente.');
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
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
    
        $producto->delete();
        return response()->json(['success' => 'Producto eliminado correctamente']);
    }
}
