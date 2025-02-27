@extends('layouts.app')

@section('content')

@if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container mt-4">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4">Editar Producto</h2>

        <form action="{{ route('productos.update', $producto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
            </div>
            
            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" name="codigo" class="form-control" value="{{ $producto->codigo }}" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="{{ $producto->precio }}" required>
            </div>

            <div class="mb-3">
                <label for="existencia" class="form-label">Existencia</label>
                <input type="number" name="existencia" class="form-control no-arrows" value="{{ $producto->existencia }}" required>
            </div>

            <div class="text-lett mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

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
