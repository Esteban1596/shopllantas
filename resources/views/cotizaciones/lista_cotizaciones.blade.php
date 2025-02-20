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

    <!-- Input de búsqueda -->
    <input type="text" id="search" class="form-control mb-3" placeholder="Buscar cotizaciones...">

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Cliente</th>
                    <th>Productos</th>
                    <th>Fecha de cotización</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="cotizaciones-tbody">
                @foreach($cotizaciones as $cotizacion)
                    <tr>
                        <td>{{ $cotizacion->codigo_pedido }}</td>
                        <td>{{ $cotizacion->nombre }}</td>
                        <td>{{ $cotizacion->cliente->nombre }}</td>
                        <td>{{ $cotizacion->productos }}</td>
                        <td>{{ $cotizacion->fecha }}</td>
                        <td>{{ $cotizacion->total }}</td>
                        <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('cotizaciones.show', $cotizacion->id) }}" class="btn btn-info rounded-pill me-2">Ver</a>
                            
                            <!-- Ícono de usuario para abrir el modal -->
                            <button type="button" class="btn btn-primary rounded-pill me-2" data-bs-toggle="modal" data-bs-target="#userModal{{ $cotizacion->id }}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </button>

                            <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta cotización?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger rounded-pill">Eliminar</button>
                            </form>
                        </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach($cotizaciones as $cotizacion)
<!-- Modal de usuario -->
<div class="modal fade" id="userModal{{ $cotizacion->id }}" tabindex="-1" aria-labelledby="userModalLabel{{ $cotizacion->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel{{ $cotizacion->id }}">Información del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nombre:</strong> {{ $cotizacion->cliente->nombre }}</p>
                <p><strong>Teléfono:</strong> {{ $cotizacion->cliente->telefono }}</p>
                <p><strong>Celular:</strong> {{ $cotizacion->cliente->celular }}</p>
                <p><strong>Email:</strong> {{ $cotizacion->cliente->email }}</p>
                <p><strong>Nombre Comercial:</strong> {{ $cotizacion->cliente->nombre_comercial }}</p>
                <p><strong>Dirección:</strong> {{ $cotizacion->cliente->direccion }}</p>
                <p><strong>Website:</strong> <a href="{{ $cotizacion->cliente->website }}" target="_blank">{{ $cotizacion->cliente->website }}</a></p>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- JavaScript para filtrar la tabla -->
<script>
    document.getElementById('search').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#cotizaciones-tbody tr');

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            const codigo = cells[0].textContent.toLowerCase();
            const nombre = cells[1].textContent.toLowerCase();
            const cliente = cells[2].textContent.toLowerCase();
            const productos = cells[3].textContent.toLowerCase();
            const fecha = cells[4].textContent.toLowerCase();
            const total = cells[5].textContent.toLowerCase();

            // Verifica si alguno de los campos contiene el término de búsqueda
            if (codigo.includes(searchTerm) || nombre.includes(searchTerm) || cliente.includes(searchTerm) || productos.includes(searchTerm) || fecha.includes(searchTerm) || total.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
