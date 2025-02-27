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
<a href="{{ route('clientes.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Crear Cliente
    </a>
    <h3 class="mb-4">Lista de Clientes</h3>
    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Buscar productos..." aria-label="Buscar productos">
    </div>
    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>Nombre Comercial</th>
                    <th>Dirección</th>
                    <th>Website</th>
                    <th>Accion</th>
                </tr>
            </thead>
        <tbody id="listaclientes">
            @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->celular }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->nombre_comercial }}</td>
                <td>{{ $cliente->direccion }}</td>
                <td>{{ $cliente->website }}</td>
                <td>
                    <div class="btn-group gap-2" role="group">
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE') 
                            <button type="submit" class="btn btn-danger me-2" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                        <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    <!-- JavaScript para filtrar la tabla -->
    <script>
        document.getElementById('search').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#listaclientes tr');

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                const nombre = cells[0].textContent.toLowerCase();
                const telefono = cells[1].textContent.toLowerCase();
                const celular = cells[2].textContent.toLowerCase();
                const email = cells[3].textContent.toLowerCase();
                const nombre_comercial = cells[4].textContent.toLowerCase();
                const direccion = cells[5].textContent.toLowerCase();
                const website = cells[6].textContent.toLowerCase();

                // Verifica si alguno de los campos contiene el término de búsqueda
                if (nombre.includes(searchTerm) || telefono.includes(searchTerm) || celular.includes(searchTerm) || email.includes(searchTerm) || nombre_comercial.includes(searchTerm) || direccion.includes(searchTerm) || website.includes(searchTerm
                )) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
