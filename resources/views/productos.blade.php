@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Agregar Producto</h2>

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
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>
        <div class="mb-3">
        <label for="existencia" class="form-label">Existencia</label>
        <input type="number" name="existencia" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Producto</button>
    </form>
</div>
@endsection
