@extends('layouts.app')

@section('content')
<div class="container mt-2 mb-2 p-2">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark">
            <h3 class="mb-0">Editar Cotización</h3>
        </div>
        <div class="card-body">
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cotizaciones.update', $cotizacion->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="codigo_pedido" class="form-label">Código de Pedido</label>
                    <input type="text" name="codigo_pedido" class="form-control" value="{{ $cotizacion->codigo_pedido }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <input type="text" class="form-control" value="{{ $cotizacion->cliente->nombre_comercial }}" readonly>
                </div>
                <input type="hidden" name="cliente_id" value="{{ $cotizacion->cliente->id }}">
                <div class="mb-3">
                    <label for="buscar_producto" class="form-label">Buscar Producto</label>
                    <input type="text" id="buscar_producto" class="form-control" placeholder="Buscar producto...">
                </div>

                <div id="productos_busqueda" class="mt-3"></div>
                <h4 class="mt-3">Productos</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="productosTable">
                        @php $subtotal = 0; @endphp
                            @foreach ($cotizacion->productosRelacionados as $producto)
                                @php
                                    $productoSubtotal = $producto->pivot->cantidad * $producto->pivot->precio_unitario;
                                    $subtotal += $productoSubtotal;
                                @endphp
                                <tr data-producto-id="{{ $producto->id }}">
                                    <td>{{ $producto->nombre }}</td>
                                    <td>
                                        <input type="number" name="productos[{{ $producto->id }}][cantidad]" 
                                               value="{{ $producto->pivot->cantidad }}" 
                                               class="form-control cantidad" min="1" 
                                               onchange="calcularTotales()">
                                    </td>
                                    <td>
                                        <input type="number" name="productos[{{ $producto->id }}][precio_unitario]" 
                                            value="{{ $producto->precio }}" 
                                            class="form-control precio_unitario" 
                                            readonly>
                                    </td>
                                    <td class="subtotal">
                                        ${{ number_format($producto->pivot->cantidad * $producto->pivot->precio_unitario, 2) }}
                                    </td>
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
                                <th>Número de productos</th>
                                <td class="text-end" id="num_productos">0</td>
                            </tr>
                            <tr>
                                <th>Subtotal</th>
                                <td class="text-end" id="subtotal">${{ number_format($subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th>IVA (16%)</th>
                                <td class="text-end" id="iva">${{ number_format($iva, 2) }}</td>
                            </tr>
                            <tr class="table-success">
                                <th>Total</th>
                                <td class="text-end" id="total"><strong>${{ number_format($total, 2) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Función para recalcular el subtotal, IVA y total
    function calcularTotales() {
        let subtotal = 0;
        let num_productos = 0;
        const productos = document.querySelectorAll('#productosTable tr');

        productos.forEach(producto => {
            // Obtener los valores de cantidad y precio unitario
            const cantidad = parseFloat(producto.querySelector('.cantidad').value) || 0;
            const precioUnitario = parseFloat(producto.querySelector('.precio_unitario').value) || 0;
            const subtotalProducto = cantidad * precioUnitario;

            num_productos += cantidad;

            // Actualizar el subtotal de cada producto
            producto.querySelector('.subtotal').textContent = `$${subtotalProducto.toFixed(2)}`;
            subtotal += subtotalProducto;
        });

        // Calcular el IVA y el total
        const iva = subtotal * 0.16;  // IVA del 16%
        const total = subtotal + iva;
        
        // Actualizar los valores en la interfaz
        document.getElementById('num_productos').textContent = num_productos;
        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('iva').textContent = `$${iva.toFixed(2)}`;
        document.getElementById('total').innerHTML = `<strong>$${total.toFixed(2)}</strong>`;
    }

    // Ejecutar la función al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        calcularTotales();
    });
    //////////////////////////////////////////
    document.addEventListener("DOMContentLoaded", function () {
    let productosDisponibles = [];

    // Cargar productos desde la base de datos cuando se escribe en el buscador
    document.getElementById("buscar_producto").addEventListener("keyup", function () {
        const filtro = this.value.trim().toLowerCase();
        
        if (filtro.length === 0) {
            document.getElementById("productos_busqueda").innerHTML = "";
            return;
        }

        fetch("{{ route('productos.lista') }}")
            .then(response => response.json())
            .then(data => {
                productosDisponibles = data.filter(p => p.nombre.toLowerCase().includes(filtro));
                mostrarProductos(productosDisponibles);
            });
    });

    function mostrarProductos(productos) {
        const contenedor = document.getElementById("productos_busqueda");
        contenedor.innerHTML = "";

        if (productos.length === 0) {
            contenedor.innerHTML = `<p class="text-muted">No se encontraron productos.</p>`;
            return;
        }

        productos.forEach(producto => {
            const productoHTML = `
                <div class="card p-2 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${producto.nombre}</strong> <br>
                            Precio: $${producto.precio}
                        </div>
                        <button type="button" class="btn btn-success btn-sm" onclick="agregarProducto(${producto.id}, '${producto.nombre}', ${producto.precio})">
                            Agregar
                        </button>
                    </div>
                </div>
            `;
            contenedor.innerHTML += productoHTML;
        });
    }
});

// Función para agregar un producto a la tabla de cotización sin enviar el formulario
function agregarProducto(id, nombre, precio) {
    const tabla = document.getElementById("productosTable");

    // Verificar si el producto ya está en la tabla
    if (document.querySelector(`[data-producto-id="${id}"]`)) {
        alert("Este producto ya está agregado.");
        return;
    }

    const nuevaFila = document.createElement("tr");
    nuevaFila.setAttribute("data-producto-id", id);
    nuevaFila.innerHTML = `
        <td>${nombre}</td>
        <td>
            <input type="number" name="productos[${id}][cantidad]" value="1" class="form-control cantidad" min="1" onchange="calcularTotales()">
        </td>
        <td>
            <input type="number" name="productos[${id}][precio_unitario]" value="${precio}" class="form-control precio_unitario" readonly>
        </td>
        <td class="subtotal">$${precio.toFixed(2)}</td>
    `;

    tabla.appendChild(nuevaFila);
    calcularTotales();
}
</script>
@endsection
