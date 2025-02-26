@extends('layouts.app')

@section('content')
<div class="container">
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
    <div class="container mt-2 mb-2 p-2">
        <input type="text" id="search" class="form-control" placeholder="Buscar producto por código o nombre...">
    </div>

    <!-- Tabla de productos -->
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

    <!-- Productos seleccionados y cotizador -->
    <div class="container mt-4" style="margin-bottom: 8%;">
        <div class="row">
            <!-- Columna de productos seleccionados -->
            <div class="col-md-9">
                <h3>Productos seleccionados</h3>
                <div class="table-responsive">
                    <table class="table table-hover" id="productos-seleccionados">
                        <thead>
                            <tr>
                                <th>ID</ht>
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
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-end"><strong>Subtotal:</strong></td>
                                <td><span id="subtotal">$0.00</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Columna del Cotizador -->
            <div class="col-md-3">
                <h3>Cotizador</h3>
                <div class="table-responsive">
                    <table class="table table-hover" id="cotizador">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Número de productos</td>
                                <td id="num-productos">0</td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td id="subtotal-cotizador">$0.00</td>
                            </tr>
                            <tr>
                                <td>IVA (16%)</td>
                                <td id="iva">$0.00</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td id="total">$0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" id="guardarCotizacionBtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalGuardarCotizacion">Guardar Cotización</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Guardar Cotización -->
<div class="modal fade" id="modalGuardarCotizacion" tabindex="-1" aria-labelledby="modalGuardarCotizacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGuardarCotizacionLabel">Guardar Cotización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
            <form id="formGuardarCotizacion" action="{{ route('cotizaciones.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="codigo_pedido">Código de Cotización</label>
        <input type="text" class="form-control" name="codigo_pedido" id="codigo_pedido" maxlength="6" required>
        <div id="error-codigo" class="text-danger" style="display: none; font-size: 14px; margin-top: 5px;"></div>
    </div>

    <div class="form-group">
        <label for="nombre">Nombre de la Cotización</label>
        <input type="text" class="form-control" name="nombre" id="nombre" required>
    </div>
    <div class="form-group">
        <label for="cliente_id">Cliente</label>
        <select name="cliente_id" id="cliente_id" class="form-control" required>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="productos">Número de Productos</label>
        <input type="number" class="form-control" name="productos" id="productos" value="0" required readonly>
    </div>
    <div class="form-group">
        <label for="total">Total</label>
        <input type="number" class="form-control" name="total" id="total-modal" value="0.00" required readonly>
    </div>

    <!-- Lista de Productos Seleccionados -->
    <div id="productosSeleccionados" style="display: none;"></div>
    <input type="hidden" name="productos_json" id="productos_json">

    <button type="submit" class="btn btn-primary" style="margin-top: 17px;">Guardar Cotización</button>
</form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/modal_save_product.js') }}"></script>
@endpush
