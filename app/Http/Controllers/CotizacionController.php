<?php
namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\CotizacionProducto;
use Illuminate\Http\Request;
use Carbon\Carbon; 
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf; 

class CotizacionController extends Controller
{
    public function index()
    {
        // Obtener todas las cotizaciones
        $cotizaciones = Cotizacion::orderBy('id', 'desc')->get();

        // Pasar las cotizaciones a la vista
        return view('cotizaciones.lista_cotizaciones', compact('cotizaciones'));
    }
    public function store(Request $request)
{
    $existeCodigo = Cotizacion::where('codigo_pedido', $request->codigo_pedido)->exists();

    if ($existeCodigo) {
        return redirect()->back()->with('error', 'El código de cotización ya está registrado.');
    }

    // Validación de los datos recibidos
    $request->validate([
        'codigo_pedido' => 'required|string|max:6',
        'nombre' => 'required|string',
        'cliente_id' => 'required|integer',
        'productos' => 'required|integer',
        'total' => 'required|numeric',
    ]);

    // Decodificar los productos seleccionados desde el JSON
    $productosSeleccionados = json_decode($request->productos_json, true);

    // Contar el número de productos seleccionados
    $numProductos = count($productosSeleccionados);

    // Crear la cotización en la base de datos, incluyendo el número de productos y la fecha
    $cotizacion = Cotizacion::create([
        'codigo_pedido' => $request->codigo_pedido,
        'nombre' => $request->nombre,
        'cliente_id' => $request->cliente_id,
        'productos' => $request->productos,
        'total' => $request->total,
        'fecha' => Carbon::now(), // Fecha de la cotización (ahora)
    ]);

    // Insertar los productos seleccionados en la tabla cotizacion_producto y actualizar la existencia
    foreach ($productosSeleccionados as $producto) {
        $productoDb = Producto::find($producto['id']); // Encontrar el producto en la base de datos

        if ($productoDb && $productoDb->existencia >= $producto['cantidad']) {
            // Restar la cantidad del producto al momento de guardar la cotización
            $productoDb->existencia -= $producto['cantidad'];
            $productoDb->save();

            // Insertar el producto en la tabla cotizacion_producto
            CotizacionProducto::create([
                'cotizacion_id' => $cotizacion->id, // ID de la cotización recién creada
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio']
            ]);
        } else {
            // Si no hay suficiente existencia, puedes retornar un error o manejarlo de otra manera
            return redirect()->back()->with('error', 'No hay suficiente existencia del producto: ' . $productoDb->nombre);
        }
    }

    // Redirigir al usuario a la vista de cotizaciones o cualquier otra página
    return redirect()->route('cotizaciones.index')->with('success', 'Cotización guardada con éxito');
}

    // En el controlador CotizacionController

    public function show($id)
    {
        
        $cotizacion = Cotizacion::with('productosRelacionados')->find($id);


        return view('cotizaciones.show', compact('cotizacion'));


    }  

    public function destroy($id)
        {
            $cotizacion = Cotizacion::findOrFail($id);

            
            foreach ($cotizacion->productosRelacionados as $producto) {
                $producto->existencia += $producto->pivot->cantidad;
                $producto->save();
            }

           
            $cotizacion->productosRelacionados()->detach();

           
            $cotizacion->delete();

            return redirect()->route('cotizaciones.index')->with('success', 'Cotización eliminada correctamente.');
        }

        public function descargarCotizacion($id)
        {
                $cotizacion = Cotizacion::with('productosRelacionados', 'cliente')->findOrFail($id);

                
                $pdf = PDF::loadView('cotizaciones.pdf', compact('cotizacion'));

                
                return $pdf->download('cotizacion_' . $cotizacion->codigo_pedido . '.pdf');
        }


    
}
