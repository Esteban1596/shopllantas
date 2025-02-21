@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Ventas Registradas</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Código de Cotización</th>
                    <th>Cliente</th>
                    <th>Fecha de Venta</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->cotizacion->codigo_pedido }}</td>  <!-- Mostrar código de cotización -->
                        <td>{{ $venta->cliente->nombre }}</td>            <!-- Mostrar nombre del cliente -->
                        <td>{{ $venta->fecha_venta }}</td>                <!-- Mostrar fecha de venta -->
                        <td>{{ number_format($venta->total, 2) }}</td>     <!-- Mostrar el total de la venta -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
