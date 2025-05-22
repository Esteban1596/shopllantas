<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\Http\Request;
use App\Models\VentaRealizada;
use Barryvdh\DomPDF\Facade\Pdf;


class VentaController extends Controller
{
    public function index()
    {
        $ventas = VentaRealizada::all();

        return view('ventas.index', compact('ventas'));
    }

    // Método para guardar una nueva venta
    public function store(Request $request)
    {
        // Lógica para guardar la venta (tu código existente)
        $venta = VentaRealizada::create([
            'cotizacion_id' => $request->cotizacion_id,
            'cliente_id' => $request->cliente_id,
            'fecha_venta' => now(),
            'total' => $request->total,
        ]);

        // Cambiar el status de la cotización a 'vendida'
        $cotizacion = Cotizacion::find($request->cotizacion_id);
        $cotizacion->status = 'vendida';
        $cotizacion->save();

        return redirect()->route('cotizaciones.index')->with('success', 'Venta registrada y cotización marcada como vendida.');
    }
    public function show($id)
    {
        
        $venta = VentaRealizada::with(['cotizacion', 'cliente'])->findOrFail($id);
        return view('ventas.show', compact('venta'));
    }

    public function destroy($id)
    {
        $venta = VentaRealizada::findOrFail($id);

        if ($venta->cotizacion) {
            $venta->cotizacion->delete(); 
        }

        $venta->delete(); // Eliminar la venta

        return redirect()->back()->with('success', 'Venta y cotización eliminadas correctamente.');
    }
    public function descargarPDF($id)
    {
        $venta = VentaRealizada::findOrFail($id);

        $pdf = Pdf::loadView('ventas.pdf', compact('venta'));

        return $pdf->download('venta_'.$venta->id.'.pdf');
    }



}
