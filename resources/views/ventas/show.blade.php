@extends('layouts.app')

@section('content')
<div class="container mt-2 mb-2 p-2">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Detalle de Venta</h3>
        </div>
        <div class="card-body">
            <p><strong>Código de Cotización:</strong> {{ $venta->cotizacion->codigo_pedido }}</p>
            <p><strong>Fecha de Venta:</strong> {{ $venta->fecha_venta }}</p>
            <p><strong>Cliente:</strong> {{ $venta->cotizacion->cliente->nombre }}</p>
            <p><strong>Nombre Comercial:</strong> {{ $venta->cotizacion->cliente->nombre_comercial }}</p>
            <h4 class="mt-3">Total de Productos: <span class="badge bg-secondary">{{ $venta->cotizacion->productosRelacionados->count() }}</span></h4>
            <h4 class="mt-3">Productos Vendidos</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach ($venta->cotizacion->productosRelacionados as $producto)
                            @php
                                $productoSubtotal = $producto->pivot->cantidad * $producto->pivot->precio_unitario;
                                $subtotal += $productoSubtotal;
                            @endphp
                            <tr>
                                <td>{{ $producto->codigo }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->pivot->cantidad }}</td>
                                <td>${{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                                <td>${{ number_format($productoSubtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Subtotal</th>
                            <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th>IVA (16%)</th>
                            <td class="text-end">${{ number_format($subtotal * 0.16, 2) }}</td>
                        </tr>
                        <tr class="table-success">
                            <th>Total</th>
                            <td class="text-end"><strong>${{ number_format($subtotal * 1.16, 2) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <a href="{{ route('ventas.descargar', $venta->id) }}" class="btn btn-success">
                <i class="fa fa-file-pdf-o"></i> Descargar PDF
            </a>
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>
</div>
@endsection
