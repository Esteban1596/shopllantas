@extends('layouts.app')

@section('content')
 <!-- Mostrar mensajes de éxito -->
 @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<div class="container mt-2 mb-2 p-2">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4">Agregar Cliente</h2>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del cliente</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>

        <div class="mb-3">
            <label for="celular" class="form-label">Celular</label>
            <input type="text" class="form-control" id="celular" name="celular" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

 
        <div class="mb-3">
            <label for="nombre_comercial" class="form-label">Nombre Comercial</label>
            <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" required>
        </div>

  
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
        </div>

 
        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" class="form-control" id="website" name="website">
        </div>

        <div class="text-lett mt-3">
                <button type="submit" class="btn btn-success btn">
                    <i class="fas fa-save"></i> Guardar Cliente
                </button>
        </div>
        <div class="text-lett mt-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
        </div>

    </form>
</div>
@endsection
