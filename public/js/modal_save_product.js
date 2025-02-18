document.addEventListener('DOMContentLoaded', function () {
    // Función para actualizar el número de productos, total y productos seleccionados en el formulario
    function actualizarFormularioCotizacion() {
        // Obtener el número de productos desde la tabla de cotización
        let numProductos = document.getElementById("num-productos") ? document.getElementById("num-productos").textContent : "0";
        console.log("Número de productos:", numProductos); // Debugging

        // Obtener el total desde la tabla de cotización
        let total = document.getElementById("total") ? document.getElementById("total").textContent : "$0";
        console.log("Total desde la tabla:", total); // Debugging

        // Si el total contiene el símbolo de $, lo eliminamos para poder trabajar con el número
        total = total.replace('$', '').trim();
        console.log("Total sin símbolo '$':", total); // Debugging

        // Actualizar los valores en el formulario
        document.getElementById("productos").value = numProductos;
        document.getElementById("total-modal").value = parseFloat(total).toFixed(2);
        
        // Capturar los productos seleccionados
        let productosSeleccionados = [];
        let productosSeleccionadosModal = document.getElementById("productosSeleccionados");

        // Limpiar la tabla de productos en el modal antes de agregar los nuevos productos
        productosSeleccionadosModal.innerHTML = '';

        // Recorrer los productos seleccionados en la tabla y capturarlos
        document.querySelectorAll("#productos-seleccionados tbody tr").forEach(row => {
            // Verificar si la fila tiene al menos las celdas necesarias (8 celdas)
            if (row.cells.length >= 8) { // Verificamos que haya 8 celdas (ID, Código, Nombre, Precio, Existencia, Cantidad, Total, Acción)
                let id = row.cells[0] ? row.cells[0].textContent.trim() : ''; // ID
                let codigo = row.cells[1] ? row.cells[1].textContent.trim() : ''; // Código
                let nombre = row.cells[2] ? row.cells[2].textContent.trim() : ''; // Nombre
                let precio = row.cells[3] ? parseFloat(row.cells[3].querySelector(".precio").textContent.replace("$", "").trim()) : 0; // Precio
                let existencia = row.cells[4] ? row.cells[4].textContent.trim() : ''; // Existencia
                let cantidad = row.cells[5] ? parseInt(row.querySelector(".cantidad").textContent.trim()) : 0; // Cantidad
                let totalProducto = row.cells[6] ? parseFloat(row.querySelector(".total").textContent.replace("$", "").trim()) : 0; // Total por producto

                // Crear una fila en la tabla del modal para cada producto
                let newRow = document.createElement("tr");
                newRow.innerHTML = `
                     <td>${id}</td>
                    <td>${codigo}</td>
                    <td>${nombre}</td>
                    <td>${cantidad}</td>
                    <td>$${totalProducto.toFixed(2)}</td>
                `;
                productosSeleccionadosModal.appendChild(newRow);

                // Guardar el producto en un array para enviar al servidor o realizar otros cálculos
                productosSeleccionados.push({
                    id,
                    codigo,
                    nombre,
                    existencia,
                    cantidad,
                    precio,
                    total: totalProducto
                });
            } else {
                console.log("Fila con celdas insuficientes:", row); // Para debugging
            }
        });

        // Para enviar los productos seleccionados como JSON o guardarlos para uso posterior
        // Se puede usar productosSeleccionados, por ejemplo, para enviarlos en una solicitud AJAX
        // O almacenarlos en un campo oculto:
        document.getElementById("productos_json").value = JSON.stringify(productosSeleccionados);
    }

    // Llamar la función cuando se abre el modal para actualizar los valores en el formulario
    document.getElementById("guardarCotizacionBtn").addEventListener("click", function () {
        console.log("Abriendo el modal..."); // Debugging
        // Asegurarse de que los valores del número de productos, total y productos se pasen al formulario
        setTimeout(function() {
            actualizarFormularioCotizacion();
        }, 200);
    });
});
