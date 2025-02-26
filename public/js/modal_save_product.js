document.addEventListener("DOMContentLoaded", function () {
    function actualizarFormularioCotizacion() {
        let numProductos = document.getElementById("num-productos")?.textContent.trim() || "0";
        let total = document.getElementById("total")?.textContent.replace('$', '').trim() || "0";

        document.getElementById("productos").value = numProductos;
        document.getElementById("total-modal").value = parseFloat(total) || 0;

        let productosSeleccionados = [];
        let productosSeleccionadosModal = document.getElementById("productosSeleccionados");
        productosSeleccionadosModal.innerHTML = '';

        document.querySelectorAll("#productos-seleccionados tbody tr").forEach(row => {
            if (row.cells.length >= 8) {
                let id = row.cells[0]?.textContent.trim() || '';
                let codigo = row.cells[1]?.textContent.trim() || '';
                let nombre = row.cells[2]?.textContent.trim() || '';
                let precio = parseFloat(row.cells[3]?.querySelector(".precio")?.textContent.replace("$", "").trim()) || 0;
                let existencia = row.cells[4]?.textContent.trim() || '';
                let cantidad = parseInt(row.querySelector(".cantidad")?.textContent.trim()) || 0;
                let totalProducto = parseFloat(row.querySelector(".total")?.textContent.replace("$", "").trim()) || 0;

                let newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td>${id}</td>
                    <td>${codigo}</td>
                    <td>${nombre}</td>
                    <td>${cantidad}</td>
                    <td>$${totalProducto.toFixed(2)}</td>
                `;
                productosSeleccionadosModal.appendChild(newRow);

                productosSeleccionados.push({ id, codigo, nombre, existencia, cantidad, precio, total: totalProducto });
            }
        });

        document.getElementById("productos_json").value = JSON.stringify(productosSeleccionados);
    }

    document.getElementById("modalGuardarCotizacion").addEventListener("show.bs.modal", function () {
        actualizarFormularioCotizacion();
    });

    document.querySelector("#formGuardarCotizacion").addEventListener("submit", function (event) {
        event.preventDefault(); // Evita el envío del formulario hasta validar

        let codigo = document.getElementById("codigo_pedido").value.trim();
        let errorMensaje = document.getElementById("error-codigo");

        if (!codigo) {
            errorMensaje.textContent = "El código de cotización no puede estar vacío.";
            errorMensaje.style.display = "block";
            return;
        }

        fetch(`/validar-codigo/${codigo}`)
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    errorMensaje.textContent = "El código de cotización ya está registrado.";
                    errorMensaje.style.display = "block";
                } else {
                    errorMensaje.style.display = "none";
                    event.target.submit(); // Si el código no existe, envía el formulario
                }
            })
            .catch(error => {
                console.error("Error validando el código:", error);
                errorMensaje.textContent = "Hubo un error al validar el código.";
                errorMensaje.style.display = "block";
            });
    });
});
