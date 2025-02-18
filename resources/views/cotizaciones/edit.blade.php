<form action="{{ route('cotizaciones.update', $cotizacion->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Información de la cotización -->
    <input type="text" name="codigo_pedido" value="{{ $cotizacion->codigo_pedido }}" required>
    <input type="text" name="nombre" value="{{ $cotizacion->nombre }}" required>

    <!-- Productos asignados -->
    @foreach($cotizacion->productos as $producto)
        <div>
            <label>{{ $producto->nombre }}</label>
            <input type="number" name="cantidades[{{ $producto->id }}]" value="{{ $producto->pivot->cantidad }}" min="1">
        </div>
    @endforeach

    <button type="submit">Actualizar Cotización</button>
</form>
