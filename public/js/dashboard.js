document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const productosTableContainer = document.getElementById("productos-table-container");
    const productosTable = document.querySelectorAll("#productos-table tbody tr");
    const productosSeleccionados = document.querySelector("#productos-seleccionados tbody");
    const subtotalElement = document.getElementById("subtotal");

    // Función para filtrar productos en tiempo real
    searchInput.addEventListener("keyup", function () {
        let searchText = this.value.toLowerCase();
        
        // Mostrar la tabla cuando se empieza a escribir en el campo de búsqueda
        if (searchText.length > 0) {
            productosTableContainer.style.display = "block";
        } else {
            productosTableContainer.style.display = "none";
        }

        productosTable.forEach(row => {
            let codigo = row.cells[0].textContent.toLowerCase();
            let nombre = row.cells[1].textContent.toLowerCase();
            
            row.style.display = (codigo.includes(searchText) || nombre.includes(searchText)) ? "" : "none";
        });
    });

    // Función para agregar productos a la tabla de selección
    document.querySelectorAll(".agregar-producto").forEach(button => {
        button.addEventListener("click", function () {
            let productId = this.getAttribute("data-id");
            let codigo = this.getAttribute("data-codigo");
            let nombre = this.getAttribute("data-nombre");
            let precio = parseFloat(this.getAttribute("data-precio"));
            let existencia = this.getAttribute("data-existencia");

            // Verificar si 'existencia' es un número válido
            existencia = parseInt(existencia);

            // Si 'existencia' no es un número válido, asignar 0
            if (isNaN(existencia)) {
                existencia = 0;
            }

            // Verificar si el producto ya está en la tabla
            let existingRow = document.querySelector(`#producto-${productId}`);
            if (existingRow) {
                let cantidadElement = existingRow.querySelector(".cantidad");
                let totalElement = existingRow.querySelector(".total");
                
                let cantidad = parseInt(cantidadElement.textContent) + 1;
                cantidadElement.textContent = cantidad;
                totalElement.textContent = `$${(cantidad * precio).toFixed(2)}`;
            } else {
                let newRow = document.createElement("tr");
                newRow.id = `producto-${productId}`;
                newRow.innerHTML = `
                    <td>${codigo}</td>
                    <td>${nombre}</td>
                    <td>$${precio.toFixed(2)}</td>
                    <td>${existencia}</td> <!-- Mostrar existencia -->
                    <td class="cantidad">1</td>
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

    // Función para eliminar productos
    productosSeleccionados.addEventListener("click", function (e) {
        if (e.target.classList.contains("eliminar-producto")) {
            e.target.closest("tr").remove();
            actualizarSubtotal();
        }
    });

    // Función para calcular el subtotal
    function actualizarSubtotal() {
        let subtotal = 0;
        document.querySelectorAll(".total").forEach(totalElement => {
            subtotal += parseFloat(totalElement.textContent.replace("$", "")) || 0;
        });
        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
    }
});
