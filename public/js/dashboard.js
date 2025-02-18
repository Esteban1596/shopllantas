document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const productosTableContainer = document.getElementById("productos-table-container");
    const productosTable = document.querySelectorAll("#productos-table tbody tr");
    const productosSeleccionados = document.querySelector("#productos-seleccionados tbody");

    // Elementos de la tabla cotizador
    const numProductosElement = document.getElementById("num-productos");
    const subtotalElement = document.getElementById("subtotal-cotizador");
    const ivaElement = document.getElementById("iva");
    const totalElement = document.getElementById("total");

    // Objeto para almacenar la existencia inicial de cada producto
    let existenciaInicial = {};

    // Función para filtrar productos en tiempo real
    searchInput.addEventListener("keyup", function () {
        let searchText = this.value.trim().toLowerCase();
        let anyVisible = false;

        productosTable.forEach(row => {
            let codigo = row.cells[0].textContent.toLowerCase();
            let nombre = row.cells[1].textContent.toLowerCase();
            let match = codigo.includes(searchText) || nombre.includes(searchText);

            row.style.display = match ? "" : "none";
            if (match) anyVisible = true;
        });

        productosTableContainer.style.display = searchText && anyVisible ? "block" : "none";
    });

    // Función para agregar productos a la tabla de selección
    document.querySelectorAll(".agregar-producto").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.getAttribute("data-id");
            let codigo = this.getAttribute("data-codigo");
            let nombre = this.getAttribute("data-nombre");
            let precio = parseFloat(this.getAttribute("data-precio"));
            let existencia = parseInt(this.getAttribute("data-existencia")) || 0;

            let existingRow = document.querySelector(`#producto-${productId}`);
            if (existingRow) {
                alert("Este producto ya está en la lista. Usa los botones '+' y '-' para modificar la cantidad.");
                return;
            }

            // Guardar la existencia inicial del producto
            existenciaInicial[productId] = existencia;

            // Reducir la existencia en 1
            if (existencia > 0) {
                existencia -= 1;
                existenciaInicial[productId] = existencia; // Actualizamos la existencia inicial
            }

            let newRow = document.createElement("tr");
            newRow.id = `producto-${productId}`;
            newRow.innerHTML = `
            <td>${productId}</td>
                <td>${codigo}</td>
                <td>${nombre}</td>
                <td>$<span class="precio">${precio.toFixed(2)}</span></td>
                <td class="existencia">${existencia}</td>
                <td style="display:flex;">
                    <button class="btn btn-danger btn-sm update-quantity" data-action="decrease" data-id="${productId}">-</button>
                    <span class="cantidad">1</span>
                    <button class="btn btn-success btn-sm update-quantity" data-action="increase" data-id="${productId}">+</button>
                </td>
                <td>$<span class="total">${precio.toFixed(2)}</span></td>
                <td>
                    <button class="btn btn-danger btn-sm eliminar-producto" data-id="${productId}">Eliminar</button>
                </td>
            `;
            productosSeleccionados.appendChild(newRow);

            // Actualizar la tabla con la nueva existencia
            actualizarCotizacion();
        });
    });

    // Manejo de incremento y decremento de productos
    productosSeleccionados.addEventListener("click", function (e) {
        let row = e.target.closest("tr");

        if (e.target.classList.contains("update-quantity")) {
            let productId = e.target.getAttribute("data-id");
            let cantidadElement = row.querySelector(".cantidad");
            let totalElement = row.querySelector(".total");
            let existenciaElement = row.querySelector(".existencia");
            let precio = parseFloat(row.querySelector(".precio").textContent);
            let cantidad = parseInt(cantidadElement.textContent);
            let existenciaActual = parseInt(existenciaElement.textContent);
            let existenciaMax = existenciaInicial[productId]; // Existencia original
            let action = e.target.getAttribute("data-action");

            if (action === "increase" && existenciaActual > 0) {
                cantidad++;
                existenciaActual--;
                existenciaInicial[productId]--; // Restar de la existencia original
            } else if (action === "decrease" && cantidad > 1) {
                cantidad--;
                existenciaActual++;
                existenciaInicial[productId]++; // Restaurar de la existencia original
            }

            cantidadElement.textContent = cantidad;
            existenciaElement.textContent = existenciaActual;
            totalElement.textContent = (cantidad * precio).toFixed(2);
            actualizarCotizacion();
        }

        // Eliminación de productos
        if (e.target.classList.contains("eliminar-producto")) {
            let productId = e.target.getAttribute("data-id");
            let cantidad = parseInt(row.querySelector(".cantidad").textContent);
            let existenciaElement = row.querySelector(".existencia");

            // Restaurar la existencia al eliminar
            existenciaInicial[productId] += cantidad; // Restaurar la existencia original
            existenciaElement.textContent = existenciaInicial[productId];

            row.remove();
            actualizarCotizacion();
        }
    });

    // Función para calcular el subtotal, IVA y total
    function actualizarCotizacion() {
        let subtotalSeleccionados = 0;
        let numProductos = 0;

        // Recorrer la tabla de productos seleccionados
        document.querySelectorAll("#productos-seleccionados tbody tr").forEach(row => {
            let cantidad = parseInt(row.querySelector(".cantidad").textContent);
            let total = parseFloat(row.querySelector(".total").textContent.replace("$", "")); // Limpiar formato
            subtotalSeleccionados += total;
            numProductos += cantidad;
        });

        let iva = subtotalSeleccionados * 0.16;
        let totalCotizador = subtotalSeleccionados + iva;

        // Obtener los elementos de los subtotales
        const subtotalElement = document.getElementById("subtotal");
        const subtotalCotizadorElement = document.getElementById("subtotal-cotizador");
        const ivaElement = document.getElementById("iva");
        const totalElement = document.getElementById("total");
        const numProductosElement = document.getElementById("num-productos");

        // Actualizar valores en la tabla
        numProductosElement.textContent = numProductos;
        subtotalElement.textContent = `$${subtotalSeleccionados.toFixed(2)}`;
        subtotalCotizadorElement.textContent = `$${subtotalSeleccionados.toFixed(2)}`;
        ivaElement.textContent = `$${iva.toFixed(2)}`;
        totalElement.textContent = `$${totalCotizador.toFixed(2)}`;
    }
});
