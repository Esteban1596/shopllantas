@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Cotizaciones</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('dashboard') }}" class="btn btn-primary mb-3">Crear Cotización</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Productos</th>
                    <th>Fecha de venta</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizaciones as $cotizacion)
                    <tr>
                        <td>{{ $cotizacion->codigo_pedido }}</td>
                        <td>{{ $cotizacion->cliente->nombre }}</td>
                        <td>{{ $cotizacion->productos }}</td>
                        <td>{{ $cotizacion->fecha }}</td>
                        <td>{{ $cotizacion->total }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <!--<a href="{{ route('cotizaciones.show', $cotizacion->id) }}" class="btn btn-info">Ver</a>-->
                                <a href="{{ route('cotizaciones.edit', $cotizacion->id) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta cotización?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
