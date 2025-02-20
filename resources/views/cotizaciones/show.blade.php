@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Detalle de Cotización</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <p><strong>Código de Pedido:</strong> {{ $cotizacion->codigo_pedido }}</p>
                <p><strong>Fecha:</strong> {{ $cotizacion->fecha }}</p>
                <p><strong>Cliente:</strong> {{ $cotizacion->cliente->nombre }}</p>
                <p><strong>Nombre Comercial:</strong> {{ $cotizacion->cliente->nombre_comercial }}</p>
                <h4 class="mt-3">Total de Productos: <span class="badge bg-secondary">{{ $cotizacion->productosRelacionados->count() }}</span></h4>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-active">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp

                        @foreach ($cotizacion->productosRelacionados as $producto)
                            @php
                                $productoSubtotal = $producto->pivot->cantidad * $producto->pivot->precio_unitario;
                                $subtotal += $productoSubtotal;
                            @endphp
                            <tr>
                                <td>{{ $producto->id }}</td>
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

            @php
                $iva = $subtotal * 0.16;  // IVA del 16%
                $total = $subtotal + $iva;
            @endphp

            <div class="row justify-content-end">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Subtotal</th>
                            <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th>IVA (16%)</th>
                            <td class="text-end">${{ number_format($iva, 2) }}</td>
                        </tr>
                        <tr class="table-success">
                            <th>Total</th>
                            <td class="text-end"><strong>${{ number_format($total, 2) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar a Cotizaciones
                </a>

                <div>
                    <a href="{{ route('cotizaciones.descargar', $cotizacion->id) }}" class="btn btn-success me-2">
                        <i class="fa fa-file-pdf-o"></i> Descargar PDF
                    </a>

                    <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta cotización?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
