@extends('layouts.app')

@section('content')
    <div class="container">
    <h3>Detalle de Cotización</h3>

<p><strong>Código de Pedido:</strong> {{ $cotizacion->codigo_pedido }}</p>
<p><strong>Cliente:</strong> {{ $cotizacion->cliente->nombre }}</p>
<h3>Total de Productos: {{ $cotizacion->productosRelacionados->count() }}</h3>
<table class="table table-bordered">
    <thead>
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
        @php
            $subtotal = 0;
        @endphp

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

@php
    $iva = $subtotal * 0.16;  // IVA del 16%
    $total = $subtotal + $iva;
@endphp

<table class="table">
    <tr>
        <th>Subtotal</th>
        <td>${{ number_format($subtotal, 2) }}</td>
    </tr>
    <tr>
        <th>IVA (16%)</th>
        <td>${{ number_format($iva, 2) }}</td>
    </tr>
    <tr>
        <th>Total</th>
        <td><strong>${{ number_format($total, 2) }}</strong></td>
    </tr>
</table>

<a href="{{ route('cotizaciones.index') }}" class="btn btn-primary mt-3">
    <i class="fas fa-arrow-left"></i> Regresar a Cotizaciones
</a>
<form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta cotización?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Eliminar</button>
</form>

        </div>
    </div>
@endsection
