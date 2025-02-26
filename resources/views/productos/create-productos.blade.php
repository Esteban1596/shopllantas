@extends('layouts.app')

@section('content')
<!-- Mostrar mensajes de éxito -->
@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
<div class="container  mt-2 mb-2 p-2">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4">Agregar Producto</h2>

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" name="codigo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control no-arrows" required>
            </div>

            <div class="mb-3">
                <label for="existencia" class="form-label">Existencia</label>
                <input type="number" name="existencia" class="form-control no-arrows" required>
            </div>

            <div class="text-lett mt-3">
                <button type="submit" class="btn btn-success btn">
                    <i class="fas fa-save"></i> Guardar Producto
                </button>
            </div>
            <div class="text-lett mt-3">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary btn">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </form>
    </div>
</div>
<!-- CSS para quitar las flechas de los inputs de tipo number -->
<style>
    .no-arrows::-webkit-outer-spin-button,
    .no-arrows::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .no-arrows {
        -moz-appearance: textfield;
    }
</style>
@endsection
