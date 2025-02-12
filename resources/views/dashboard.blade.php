@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenido al Dashboard, {{ Auth::user()->name }}!</h1>

    <!-- Campo de búsqueda -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Buscar producto por código o nombre...">
    </div>

    <!-- Tabla de búsqueda de productos -->
    <div class="table-responsive" id="productos-table-container" style="display: none;">
        <table class="table table-hover" id="productos-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Existencia</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                    <td>{{ $producto->existencia }}</td>
                    <td>
                        <button class="btn btn-success btn-sm agregar-producto" 
                                data-id="{{ $producto->id }}" 
                                data-codigo="{{ $producto->codigo }}" 
                                data-nombre="{{ $producto->nombre }}" 
                                data-precio="{{ $producto->precio }}"
                                data-existencia="{{ $producto->existencia }}">
                            Agregar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <hr>

    <!-- Tabla de productos agregados -->
    <h3>Productos seleccionados</h3>
    <div class="table-responsive">
        <table class="table table-hover" id="productos-seleccionados">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Existencia</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se agregarán dinámicamente los productos -->
            </tbody>
        </table>
    </div>

    <!-- Subtotal -->
    <h4>Subtotal: <span id="subtotal">$0.00</span></h4>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
