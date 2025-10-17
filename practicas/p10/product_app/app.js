/**
 * Se ejecuta cuando el contenido del DOM está completamente cargado.
 * Asigna los listeners a los formularios para interceptar sus envíos.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Listener para el formulario de búsqueda
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Evita la recarga de la página
            buscarProducto();
        });
    }

    // Listener para el formulario de agregar producto
    const productForm = document.getElementById('product-form');
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Evita la recarga de la página
            agregarProducto();
        });
    }
});

/**
 * Realiza una petición AJAX con GET para buscar productos.
 * Renderiza los resultados en la tabla.
 */
function buscarProducto() {
    // 1. OBTENER VALOR y usar el ID correcto ('search-input')
    const searchTerm = document.getElementById('search-input').value.trim();

    // Validar que el campo de búsqueda no esté vacío
    if (searchTerm === "") {
        document.getElementById('tabla-resultados').innerHTML = '<tr><td colspan="7">Por favor, escribe algo para buscar.</td></tr>';
        return;
    }

    // Usar el objeto XMLHttpRequest nativo
    const xhr = new XMLHttpRequest();

    // 2. CONFIGURAR LA PETICIÓN CON GET
    // Los datos se envían directamente en la URL
    const url = `backend/read.php?search=${encodeURIComponent(searchTerm)}`;
    xhr.open('GET', url, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const productos = JSON.parse(xhr.responseText);
                let template = '';
                
                if (productos.length > 0) {
                    // 3. GENERAR UNA FILA CON CELDAS SEPARADAS (<td>) para cada dato
                    productos.forEach(producto => {
                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>${producto.nombre}</td>
                                <td>${producto.marca}</td>
                                <td>${producto.modelo}</td>
                                <td>$${producto.precio}</td>
                                <td>${producto.detalles}</td>
                                <td>${producto.unidades}</td>
                            </tr>
                        `;
                    });
                } else {
                    template = '<tr><td colspan="7">No se encontraron productos que coincidan.</td></tr>';
                }
                
                // 4. USAR EL ID CORRECTO de la tabla ('tabla-resultados')
                document.getElementById('tabla-resultados').innerHTML = template;

            } catch (error) {
                console.error("Error al procesar la respuesta JSON:", error);
                alert("Ocurrió un error al recibir los datos del servidor.");
            }
        }
    };

    // 5. ENVIAR LA PETICIÓN (sin datos en send() para GET)
    xhr.send();
}

/**
 * Realiza una petición AJAX con POST para agregar un nuevo producto.
 * Muestra una alerta con el resultado y actualiza la tabla.
 */
function agregarProducto() {
    // Obtener los valores de los campos del formulario
    const producto = {
        nombre: document.getElementById('nombre').value,
        marca: document.getElementById('marca').value,
        modelo: document.getElementById('modelo').value,
        precio: parseFloat(document.getElementById('precio').value),
        detalles: document.getElementById('detalles').value,
        unidades: parseInt(document.getElementById('unidades').value)
    };

    // Validación del lado del cliente
    if (!producto.nombre || !producto.marca || !producto.modelo || producto.precio <= 0 || producto.unidades < 0) {
        alert('Por favor, completa los campos obligatorios y asegúrate de que los valores numéricos sean válidos.');
        return;
    }
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'backend/create.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            alert(response.message); // Muestra el mensaje del servidor

            if (response.status === 'success') {
                document.getElementById('product-form').reset(); // Limpia el formulario
                buscarProducto(); // Actualiza la tabla para mostrar el nuevo producto
            }
        }
    };

    xhr.send(JSON.stringify(producto));
}