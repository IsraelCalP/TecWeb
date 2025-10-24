// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * Se usa jQuery para seleccionar el elemento y .val() para asignar el valor
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    $('#description').val(JsonString);
}

// Se encapsula todo el código en $(document).ready() para asegurar que el DOM esté cargado
$(document).ready(function() {
    
    // Carga el JSON base en el textarea al iniciar
    init();

    // (i) Cargar toda la lista de productos NO eliminados al abrir la página.
    listarProductos();

    // --- MANEJADORES DE EVENTOS JQUERY ---

    /**
     * (ii) y (iii) Cargar tabla y barra de estado al "teclear" en búsqueda.
     */
    $('#search').keyup(function() {
        let search = $(this).val();

        // Si el campo de búsqueda no está vacío, realiza la búsqueda
        if(search) {
            $.ajax({
                url: './backend/product-search.php',
                type: 'GET',
                data: { search: search }, // jQuery formatea la URL (product-search.php?search=valor)
                success: function(response) {
                    let productos = JSON.parse(response);
                    
                    let template = ''; // (ii) Plantilla para la TABLA
                    let template_bar = ''; // (iii) Plantilla para la BARRA DE ESTADO

                    if(Object.keys(productos).length > 0) {
                        productos.forEach(producto => {
                            
                            // (iii) Cargar en la barra de estado los NOMBRES
                            template_bar += `<li>${producto.nombre}</li>`;

                            // (ii) Cargar la TABLA con la descripción completa (5 CELDAS)
                            let descripcion = '';
                            descripcion += '<li>precio: '+producto.precio+'</li>';
                            descripcion += '<li>unidades: '+producto.unidades+'</li>';
                            descripcion += '<li>modelo: '+producto.modelo+'</li>';
                            descripcion += '<li>marca: '+producto.marca+'</li>';
                            descripcion += '<li>detalles: '+producto.detalles+'</li>';
                        
                            template += `
                                <tr productId="${producto.id}">
                                    <td>${producto.id}</td>
                                    <td>${producto.nombre}</td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="product-edit btn btn-info">
                                            Editar
                                        </button>
                                    </td>
                                    <td>
                                        <button class="product-delete btn btn-danger">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                        
                        // (iii) Mostrar barra de estado y actualizar su contenido
                        $('#product-result').removeClass('d-none').addClass('d-block');
                        $('#container').html(template_bar);

                    } else {
                        // Si no hay resultados (CON COLSPAN 5)
                        template = `<tr><td colspan="5">No se encontraron productos.</td></tr>`;
                        // Ocultar la barra de estado
                        $('#product-result').removeClass('d-block').addClass('d-none');
                    }
                    
                    // (ii) Actualizar siempre la tabla
                    $('#products').html(template);
                }
            });
        } else {
            // Si la búsqueda está vacía, oculta la barra y muestra todos los productos
            $('#product-result').removeClass('d-block').addClass('d-none');
            listarProductos();
        }
    });

    /**
     * (iv) y (v) Registrar o Actualizar un producto (CON VALIDACIÓN).
     */
    $('#product-form').submit(function(e) {
        // Previene el comportamiento por defecto del formulario (recargar la página)
        e.preventDefault();

        // --- VALIDACIÓN AÑADIDA ---
        let nombreProducto = $('#name').val(); // Obtengo el nombre primero

        // Se usa .trim() para eliminar espacios en blanco al inicio o final
        if (nombreProducto.trim() === '') {
            // Si el nombre está vacío (o solo tiene espacios)
            let template_bar = `<li style="list-style: none; color: yellow;">Error: El nombre del producto no puede estar vacío.</li>`;
            $('#product-result').removeClass('d-none').addClass('d-block');
            $('#container').html(template_bar);
            return; 
        }
        // --- FIN VALIDACIÓN ---


        // Si la validación pasa, se continúa con el proceso
        var productoJsonString = $('#description').val();
        var finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = nombreProducto; // Usa la variable que ya validamos

        // --- LÓGICA DE EDICIÓN ---
        // Se revisa el input oculto
        let id = $('#productId').val();
        // Se decide la URL: si hay ID, se actualiza; si no, se agrega
        let url = id ? './backend/product-update.php' : './backend/product-add.php';
        // Si estamos editando, se agrega el ID al JSON que se enviará
        if (id) {
            finalJSON['id'] = id;
        }
        
        productoJsonString = JSON.stringify(finalJSON, null, 2);

        // Se envía el producto usando $.ajax (POST)
        $.ajax({
            url: url, // Se usa la URL dinámica
            type: 'POST',
            data: productoJsonString, // Se envía el JSON como string
            contentType: 'application/json;charset=UTF-8',
            success: function(response) {
                // (iv) Recibir estatus y mensaje
                let respuesta = JSON.parse(response);
                let template_bar = '';
                template_bar += `
                            <li style="list-style: none;">status: ${respuesta.status}</li>
                            <li style="list-style: none;">message: ${respuesta.message}</li>
                        `;
                // Mostrar barra de estado
                $('#product-result').removeClass('d-none').addClass('d-block');
                $('#container').html(template_bar);

                // (v) Cargar lista actualizada
                listarProductos();

                // Limpiar formulario y recargar JSON base
                $('#product-form').trigger('reset'); // Limpia el input "name"
                $('#productId').val(''); // Limpia el ID oculto
                init(); // Recarga el textarea
            }
        });
    });

    /**
     * (vi) Eliminar un producto.
     */
    $(document).on('click', '.product-delete', function() {
        if( confirm("De verdad deseas eliminar el Producto") ) {
            // $(this) se refiere al botón presionado
            // .closest('tr') busca el ancestro <tr> más cercano
            let element = $(this).closest('tr');
            let id = $(element).attr('productId'); // Obtiene el ID del atributo

            // Se envía la petición de borrado por GET
            $.get('./backend/product-delete.php', { id: id }, function(response) {
                
                // (iv) Mostrar respuesta del servidor (estatus y mensaje)
                let respuesta = JSON.parse(response);
                let template_bar = '';
                template_bar += `
                            <li style="list-style: none;">status: ${respuesta.status}</li>
                            <li style="list-style: none;">message: ${respuesta.message}</li>
                        `;
                $('#product-result').removeClass('d-none').addClass('d-block');
                $('#container').html(template_bar);
                
                // (vi) Cargar lista actualizada
                listarProductos();
            });
        }
    });

    /**
     * (NUEVO) Manejador para el botón "Editar"
     */
    $(document).on('click', '.product-edit', function() {
        // Se obtiene el ID del producto desde el atributo de la fila <tr>
        let element = $(this).closest('tr');
        let id = $(element).attr('productId');

        // Se hace la petición AJAX al nuevo script product-single.php
        $.get('./backend/product-single.php', { id: id }, function(response) {
            // Se parsea la respuesta (que es un solo objeto de producto)
            let producto = JSON.parse(response);
            
            // 1. Se llena el campo de nombre
            $('#name').val(producto.nombre);
            // 2. Se guarda el ID en el input oculto (¡MUY IMPORTANTE!)
            $('#productId').val(producto.id);
            
            // 3. Se crea el JSON para el textarea con el resto de los datos
            let descriptionJSON = {
                "precio": producto.precio,
                "unidades": producto.unidades,
                "modelo": producto.modelo,
                "marca": producto.marca,
                "detalles": producto.detalles,
                "imagen": producto.imagen
            };
            $('#description').val(JSON.stringify(descriptionJSON, null, 2));
            
            // 4. (Opcional) Mover la vista al formulario
            $('html, body').animate({
                scrollTop: $("nav").offset().top
            }, 500);
        });
    });


    // --- FUNCIÓN HELPER ---

    /**
     * Función para cargar TODOS los productos (Req i)
     * (Modificada para incluir el botón Editar - 5 CELDAS)
     */
    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                // Parsea la respuesta JSON
                let productos = JSON.parse(response);
                let template = '';

                // Recorre los productos y crea la plantilla HTML
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: '+producto.precio+'</li>';
                    descripcion += '<li>unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>marca: '+producto.marca+'</li>';
                    descripcion += '<li>detalles: '+producto.detalles+'</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-edit btn btn-info">
                                    Editar
                                </button>
                            </td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                // Inserta la plantilla en el <tbody>
                $('#products').html(template);
            }
        });
    }

});