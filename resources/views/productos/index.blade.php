@extends('layouts.app')

@section('content')
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

<div class="container">
    <a href="{{ route('productos.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Crear Producto
    </a>

    <h3 class="mb-4">Lista de Productos</h3>
    
    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Buscar productos..." aria-label="Buscar productos">
    </div>

    <!-- Tabla de productos -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Existencia</th>
                    <th>Acciones</th> 
                </tr>
            </thead>
            <tbody id="listaproductos">
                @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                    <td>{{ $producto->existencia }}</td>
                    <td>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript para filtrar la tabla -->
<script>
    document.getElementById('search').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#listaproductos tr');

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            const codigo = cells[0].textContent.toLowerCase();
            const nombre = cells[1].textContent.toLowerCase();
            const precio = cells[2].textContent.toLowerCase();
            const existencia = cells[3].textContent.toLowerCase();

            // Verifica si alguno de los campos contiene el término de búsqueda
            if (codigo.includes(searchTerm) || nombre.includes(searchTerm) || precio.includes(searchTerm) || existencia.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
