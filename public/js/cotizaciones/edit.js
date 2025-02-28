  // Función para recalcular el subtotal, IVA y total
  function calcularTotales() {
    let subtotal = 0;
    let num_productos = 0;
    const productos = document.querySelectorAll('#productosTable tr');

    productos.forEach(producto => {
        // Obtener los valores de cantidad y precio unitario
        const cantidad = parseFloat(producto.querySelector('.cantidad').value) || 0;
        const precioUnitario = parseFloat(producto.querySelector('.precio_unitario').value) || 0;
        const subtotalProducto = cantidad * precioUnitario;

        num_productos += cantidad;

        // Actualizar el subtotal de cada producto
        producto.querySelector('.subtotal').textContent = `$${subtotalProducto.toFixed(2)}`;
        subtotal += subtotalProducto;
    });

    // Calcular el IVA y el total
    const iva = subtotal * 0.16;  // IVA del 16%
    const total = subtotal + iva;
    
    // Actualizar los valores en la interfaz
    document.getElementById('num_productos').textContent = num_productos;
    document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('iva').textContent = `$${iva.toFixed(2)}`;
    document.getElementById('total').innerHTML = `<strong>$${total.toFixed(2)}</strong>`;
}

// Ejecutar la función al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    calcularTotales();
});
//////////////////////////////////////////
