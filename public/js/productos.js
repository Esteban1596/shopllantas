document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const productosTableContainer = document.getElementById("productos-table-container");
    const productosTable = document.querySelectorAll("#productos-table tbody tr");
    const productosSeleccionados = document.querySelector("#productos-seleccionados tbody");
    const subtotalElement = document.getElementById("subtotal");

    // 📌 Búsqueda en tiempo real
    searchInput.addEventListener("keyup", function () {
        let searchText = this.value.toLowerCase();

        // Mostrar la tabla cuando se empieza a escribir en el campo de búsqueda
        productosTableContainer.style.display = searchText.length > 0 ? "block" : "none";

        productosTable.forEach(row => {
            let codigo = row.cells[0].textContent.toLowerCase();
            let nombre = row.cells[1].textContent.toLowerCase();
            
            row.style.display = (codigo.includes(searchText) || nombre.includes(searchText)) ? "" : "none";
        });
    });

    // 📌 Agregar productos a la tabla de selección
    document.querySelectorAll(".agregar-producto").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.getAttribute("data-id");
            let codigo = this.getAttribute("data-codigo");
            let nombre = this.getAttribute("data-nombre");
            let precio = parseFloat(this.getAttribute("data-precio"));
            let existencia = parseInt(this.getAttribute("data-existencia"));

            // Verificar si el producto ya está en la tabla
            let existingRow = document.querySelector(`#producto-${productId}`);
            if (existingRow) {
                let cantidadElement = existingRow.querySelector(".cantidad");
                let totalElement = existingRow.querySelector(".total");
                
                let cantidad = parseInt(cantidadElement.textContent) + 1;
                if (cantidad <= existencia) {
                    cantidadElement.textContent = cantidad;
                    totalElement.textContent = `$${(cantidad * precio).toFixed(2)}`;
                }
            } else {
                let newRow = document.createElement("tr");
                newRow.id = `producto-${productId}`;
                newRow.innerHTML = `
                    <td>${codigo}</td>
                    <td>${nombre}</td>
                    <td>$${precio.toFixed(2)}</td>
                    <td>${existencia}</td>
                    <td>
                        <div class="numeric-input">
                            <button class="btn btn-danger btn-sm update-quantity" data-id="${productId}" data-action="decrease">-</button>
                            <span id="cantidad-${productId}" class="cantidad" data-max="${existencia}">1</span>
                            <button class="btn btn-success btn-sm update-quantity" data-id="${productId}" data-action="increase">+</button>
                        </div>
                    </td>
                    <td class="total">$${precio.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger btn-sm eliminar-producto" data-id="${productId}">Eliminar</button>
                    </td>
                `;
                productosSeleccionados.appendChild(newRow);
            }
            actualizarSubtotal();
        });
    });

    // 📌 Modificar cantidad con botones "+" y "-"
    productosSeleccionados.addEventListener("click", function (e) {
        if (e.target.classList.contains("update-quantity")) {
            let productId = e.target.getAttribute("data-id");
            let action = e.target.getAttribute("data-action");
            let cantidadSpan = document.getElementById(`cantidad-${productId}`);
            let maxExistencia = parseInt(cantidadSpan.getAttribute("data-max"));
            let cantidad = parseInt(cantidadSpan.textContent);

            if (action === "increase" && cantidad < maxExistencia) {
                cantidad += 1;
            } else if (action === "decrease" && cantidad > 1) {
                cantidad -= 1;
            }

            cantidadSpan.textContent = cantidad;

            // Actualizar el total
            const precio = parseFloat(e.target.closest("tr").querySelector("td:nth-child(3)").textContent.replace("$", ""));
            const total = cantidad * precio;
            e.target.closest("tr").querySelector(".total").textContent = `$${total.toFixed(2)}`;

            actualizarSubtotal();
        }

        // 📌 Eliminar producto de la lista
        if (e.target.classList.contains("eliminar-producto")) {
            e.target.closest("tr").remove();
            actualizarSubtotal();
        }
    });

    // 📌 Función para calcular el subtotal
    function actualizarSubtotal() {
        let subtotal = 0;
        document.querySelectorAll(".total").forEach(totalElement => {
            subtotal += parseFloat(totalElement.textContent.replace("$", "")) || 0;
        });
        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
    }
});
