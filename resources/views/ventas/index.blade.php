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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->cotizacion->codigo_pedido }}</td> 
                        <td>{{ $venta->cliente->nombre }}</td>           
                        <td>{{ $venta->fecha_venta }}</td>              
                        <td>{{ number_format($venta->total, 2) }}</td> 
                        <td>
                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta venta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
