<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    
    // Mostrar todos los clientes
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('create-clientes');
    }

   
    public function store(Request $request)
    {
      
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'celular' => 'required|string|max:15',
            'email' => 'required|email|unique:clientes,email',
            'nombre_comercial' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'website' => 'nullable|url',
        ]);

        // Crear el cliente
        Cliente::create($validated);

        return redirect()->route('clientes.create')->with('success', 'Cliente registrado exitosamente');
    }

    // Mostrar el formulario para editar un cliente
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar un cliente
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'celular' => 'required|string|max:15',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'nombre_comercial' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'website' => 'nullable|url',
        ]);

 
        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente!');
    }

    // Eliminar un cliente
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();


        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente!');
    }
}
