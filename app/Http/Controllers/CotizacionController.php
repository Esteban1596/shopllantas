<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
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
        
        $cotizaciones = Cotizacion::orderBy('id', 'desc')->get();
        $cotizaciones = Cotizacion::where('status', '!=', 'vendida')->get();

       
        return view('cotizaciones.lista_cotizaciones', compact('cotizaciones'));
    }
    public function store(Request $request)
    {
        $existeCodigo = Cotizacion::where('codigo_pedido', $request->codigo_pedido)->exists();

        if ($existeCodigo) {
            return redirect()->back()->with('error', 'El código de cotización ya está registrado.');
        }

        $request->validate([
            'codigo_pedido' => 'required|string|max:6',
            'nombre' => 'required|string',
            'cliente_id' => 'required|integer',
            'productos' => 'required|integer',
            'total' => 'required|numeric',
        ]);

        // Decodificar los productos seleccionados desde el JSON
        $productosSeleccionados = json_decode($request->productos_json, true);

       
        $numProductos = count($productosSeleccionados);

        $cotizacion = Cotizacion::create([
            'codigo_pedido' => $request->codigo_pedido,
            'nombre' => $request->nombre,
            'cliente_id' => $request->cliente_id,
            'productos' => $request->productos,
            'total' => $request->total,
            'fecha' => Carbon::now(),
        ]);

        // Insertar los productos seleccionados en la tabla cotizacion_producto y actualizar la existencia
        foreach ($productosSeleccionados as $producto) {
            $productoDb = Producto::find($producto['id']); 

            if ($productoDb && $productoDb->existencia >= $producto['cantidad']) {
                $productoDb->existencia -= $producto['cantidad'];
                $productoDb->save();

                // Insertar el producto en la tabla cotizacion_producto
                CotizacionProducto::create([
                    'cotizacion_id' => $cotizacion->id, 
                    'producto_id' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $producto['precio']
                ]);
            } else {
                
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
    public function edit($id)
    {
        $cotizacion = Cotizacion::with('productosRelacionados')->findOrFail($id);
        $clientes = Cliente::all(); 
        return view('cotizaciones.edit', compact('cotizacion', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo_pedido' => 'required|string|max:6|unique:cotizaciones,codigo_pedido,' . $id,
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $cotizacion = Cotizacion::findOrFail($id);

        // Obtener productos antes de la actualización
        $productosAnteriores = $cotizacion->productosRelacionados()->get();

        // Obtener los IDs de los productos que se están enviando en la actualización
        $productosNuevosIds = array_keys($request->productos);

        // Identificar productos eliminados
        $productosEliminados = $productosAnteriores->whereNotIn('id', $productosNuevosIds);

        // Restaurar existencias de los productos eliminados y eliminarlos de la tabla intermedia
        foreach ($productosEliminados as $productoEliminado) {
            $cantidadAnterior = $productoEliminado->pivot->cantidad;

            $productoEliminado->update([
                'existencia' => $productoEliminado->existencia + $cantidadAnterior
            ]);

            // Eliminar relación en la tabla intermedia `cotizacion_producto`
            $cotizacion->productosRelacionados()->detach($productoEliminado->id);
        }

        // Actualizar la cotización con los nuevos datos
        $cotizacion->update([
            'codigo_pedido' => $request->codigo_pedido,
            'cliente_id' => $request->cliente_id,
            'updated_at' => now()
        ]);

        $subtotal = 0;
        $num_productos = 0;
        $productosParaSync = [];

        foreach ($request->productos as $productoId => $datos) {
            $producto = Producto::findOrFail($productoId);

            // Obtener cantidad anterior
            $cantidadAnterior = optional($productosAnteriores->where('id', $productoId)->first())->pivot->cantidad ?? 0;

            // Calcular diferencia de cantidad
            $diferencia = $datos['cantidad'] - $cantidadAnterior;

            // Actualizar existencia del producto
            $producto->update([
                'existencia' => $producto->existencia - $diferencia
            ]);

            // Preparar datos para actualizar la tabla intermedia
            $productosParaSync[$productoId] = [
                'cantidad' => $datos['cantidad'],
                'precio_unitario' => $datos['precio_unitario'],
            ];

            $subtotal += $datos['cantidad'] * $datos['precio_unitario'];
            $num_productos += $datos['cantidad'];
        }

        // Actualizar relación en `cotizacion_producto`
        $cotizacion->productosRelacionados()->sync($productosParaSync);

        // Calcular IVA y total
        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;

        // Actualizar cotización
        $cotizacion->update([
            'total' => $total,
            'productos' => $num_productos
        ]);

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización actualizada correctamente.');
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

    public function buscarProducto(Request $request)
    {
        $query = $request->input('query');
        $productos = Producto::where('nombre', 'like', "%{$query}%")->get();

        return response()->json(['productos' => $productos]);
    }
    public function validarCodigo($codigo)
    {
        $existe = Cotizacion::where('codigo_pedido', $codigo)->exists();
        return response()->json(['existe' => $existe]);
    }
        
}
