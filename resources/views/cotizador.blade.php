@extends('layouts.app')

@section('content')
    <h1>Bienvenido al cotizador, {{ Auth::user()->name }}!</h1>
    <div class="container">
        <p><strong>Cotizador</strong></p>
        <div class="table-responsive">
        <input type="text" name="search" id="search" class="form-control mb-3" placeholder="Buscar por código o nombre...">
            <table id="productos-table" class="table table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Existencia</th>
                        <th>Cantidad</th>
                        <th></th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr id="producto-{{ $producto->id }}">
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td id="precio-{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                                ${{ number_format($producto->precio, 2) }}
                            </td>
                            <td id="existencia-{{ $producto->id }}">{{ $producto->inventarios->sum('cantidad') }}</td>
                            <td>
                                <div class="numeric-input">
                                <button class="btn btn-danger btn-sm update-quantity" data-id="{{ $producto->id }}" data-action="decrease">-</button>
                                <span id="cantidad-{{ $producto->id }}" data-max="{{ $producto->inventarios->sum('cantidad') }}">0</span>
                                <button class="btn btn-success btn-sm update-quantity" data-id="{{ $producto->id }}" data-action="increase">+</button>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-product" data-id="{{ $producto->id }}">
                                    <i class="fa fa-trash"></i> 
                                </button>
                            </td>
                            <td>
                                <span id="total-{{ $producto->id}}">$0.00</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
        <tr>
            <td colspan="6" class="text-end"><strong>Subtotal:</strong></td>
            <td><span id="subtotal">$0.00</span></td>
        </tr>
    </tfoot>
            </table>
        </div>
    </div>
    
@endsection
@push('scripts')
    <script src="{{ asset('js/productos.js') }}"></script>
@endpush

