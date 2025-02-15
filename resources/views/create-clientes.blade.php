@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Cliente</h2>

    <!-- Mostrar mensajes de éxito -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario de registro de cliente -->
    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <!-- Teléfono -->
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>

        <!-- Celular -->
        <div class="mb-3">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular" name="celular" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Nombre Comercial -->
        <div class="mb-3">
            <label for="nombre_comercial" class="form-label">Nombre Comercial</label>
            <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" required>
        </div>

        <!-- Dirección -->
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>

        <!-- Website -->
        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" id="website" name="website">
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="btn btn-primary">Registrar Cliente</button>
    </form>
</div>
@endsection
