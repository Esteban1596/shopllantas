@extends('layouts.app')

@section('content')
<div class="container">
<div class="container mt-4 option-table">
            <div class="row">
                <!-- Botón Dashboard -->
                <div class="col-3">
                    <button class="btn btn-dashboard">
                         Dashboard
                    </button>
                </div>

                <!-- Botón Analíticas -->
                <div class="col-3">
                    <button class="btn btn-analiticas">
                        Analíticas
                    </button>
                </div>

                <!-- Botón CxC -->
                <div class="col-3">
                    <button class="btn btn-cxc">
                        CxC
                    </button>
                </div>

                <!-- Botón CxP -->
                <div class="col-3">
                    <button class="btn btn-cxp">
                        CxP
                    </button>
                </div>
            </div>
        </div>
        
        <div class="container mt-4 option-view">
            <div class="row">
                <div class="col-3">
                    <button class="btn btn-productos">
                         Productos
                    </button>
                </div>
                <div class="col-3">
                    <button class="btn btn-clientes">
                        Clientes
                    </button>
                </div>
            </div>
        </div>
   
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

    <div class="container mt-4">
        <div class="row">
            <!-- Columna de productos seleccionados -->
            <div class="col-md-9">
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
                    <button class="btn btn-primary" id="guardarCotizacion">Guardar Cotización</button>
                    <button class="btn btn-success" id="enviarCotizacion">Enviar Cotización</button>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
