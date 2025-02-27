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

    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Buscar ventas..." aria-label="Buscar venta">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Código de Cotización</th>
                    <th>Cliente</th>
                    <th>Fecha de Venta</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="listaventas">
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->cotizacion->codigo_pedido }}</td> 
                        <td>{{ $venta->cliente->nombre }}</td>           
                        <td>{{ $venta->fecha_venta }}</td>              
                        <td>{{ number_format($venta->total, 2) }}</td> 
                        <td>
                        <div class="btn-group gap-2" role="group">
                        <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info rounded-pill me-2" title="Ver detalles">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta venta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger rounded-pill me-2">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    document.getElementById('search').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#listaventas tr');

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            const codigo_pedido = cells[0].textContent.toLowerCase();
            const nombre = cells[1].textContent.toLowerCase();
            const fecha_venta = cells[2].textContent.toLowerCase();

            if (codigo_pedido.includes(searchTerm) || nombre.includes(searchTerm) || fecha_venta.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
  