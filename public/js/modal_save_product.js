document.addEventListener('DOMContentLoaded', function () {
    // Función para actualizar el número de productos y total en el formulario
    function actualizarFormularioCotizacion() {
        // Obtener el número de productos desde la tabla de cotización
        let numProductos = document.getElementById("num-productos").textContent;
        console.log("Número de productos:", numProductos); // Debugging

        // Obtener el total desde la tabla de cotización
        let total = document.getElementById("total").textContent;
        console.log("Total desde la tabla:", total); // Debugging

        // Si el total contiene el símbolo de $, lo eliminamos para poder trabajar con el número
        total = total.replace('$', '').trim();
        console.log("Total sin símbolo '$':", total); // Debugging

        // Actualizar los valores en el formulario
        document.getElementById("productos").value = numProductos;
        document.getElementById("total-modal").value = parseFloat(total).toFixed(2);
    }

    // Llamar la función cuando se abre el modal para actualizar los valores en el formulario
    document.getElementById("guardarCotizacionBtn").addEventListener("click", function () {
        console.log("Abriendo el modal..."); // Debugging
        // Asegurarse de que los valores del número de productos y total se pasen al formulario
        setTimeout(function() {
            actualizarFormularioCotizacion();
        }, 200);
    });
});
