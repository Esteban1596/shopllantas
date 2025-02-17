<?php
namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CotizacionController extends Controller
{
     // Método index para listar las cotizaciones
     public function index()
     {
         // Obtener todas las cotizaciones
         $cotizaciones = Cotizacion::all();
 
         // Pasar las cotizaciones a la vista
         return view('cotizaciones.lista_cotizaciones', compact('cotizaciones'));
     }
     
    // Método para mostrar el formulario
    public function create()
    {
        // Obtiene todos los clientes para mostrarlos en el formulario
        $clientes = Cliente::all();
        return view('cotizaciones.create', compact('clientes'));
    }

        public function store(Request $request)
        {
            // Verificar si el código de cotización ya existe
            $existeCodigo = Cotizacion::where('codigo_pedido', $request->codigo_pedido)->exists();

            if ($existeCodigo) {
                return redirect()->back()->with('error', 'El código de cotización ya está registrado.');
            }

            // Obtener la fecha actual
            $fechaActual = Carbon::now();

             // Validación de los datos recibidos
        $request->validate([
            'codigo_pedido' => 'required|string|max:6',
            'nombre' => 'required|string',
            'cliente_id' => 'required|integer',
            'productos' => 'required|integer',
            'total' => 'required|numeric',
        ]);

        // Crear la cotización en la base de datos
        $cotizacion = new Cotizacion();
        $cotizacion->codigo_pedido = $request->codigo_pedido;
        $cotizacion->nombre = $request->nombre;
        $cotizacion->cliente_id = $request->cliente_id;
        $cotizacion->productos = $request->productos;  // Número de productos
        $cotizacion->total = $request->total;  // Total de la cotización
        $cotizacion->fecha = now();  // Fecha actual
        $cotizacion->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Cotización guardada correctamente.');
        }


}
