$(document).ready(function(){
    // Bandera para modo edición y para guardar el nombre original (Task 7)
    let edit = false;
    let originalName = '';

    $('#product-result').hide();
    listarProductos();

    // --- Tarea 6: Funciones de Status ---
    /**
     * Muestra un mensaje en la barra de estado.
     * @param {string} message - El mensaje a mostrar.
     * @param {boolean} isError - Si es true, muestra el mensaje en rojo.
     */
    function showStatus(message, isError = false) {
        let color = isError ? '#F57373' : '#73F583'; // Rojo para error, Verde para éxito
        let template_bar = `<li style="list-style: none; color: ${color};">${message}</li>`;
        $('#product-result').show();
        $('#container').html(template_bar);
    }

    /**
     * Oculta la barra de estado.
     */
    function hideStatus() {
        $('#product-result').hide();
        $('#container').html('');
    }

    // --- Tarea 5.1: Validación "on-blur" (al perder el foco) ---
    // Se valida que los campos no estén vacíos.
    $('#precio, #unidades, #modelo, #marca, #detalles, #imagen').blur(function() {
        if ($(this).val().trim() === '') {
            let fieldName = $(this).attr('placeholder');
            showStatus(`El campo "${fieldName}" no puede estar vacío.`, true);
        } else {
            let fieldName = $(this).attr('placeholder');
            showStatus(`Campo "${fieldName}" validado.`, false);
        }
    });

    // --- Tarea 7: Validación asíncrona de nombre de producto ---
    $('#name').keyup(function() {
        let nombre = $(this).val().trim();
        
        // Validamos si está vacío (como en Task 5.1)
        if (nombre === '') {
            showStatus('El campo "Nombre de producto" no puede estar vacío.', true);
            return;
        }

        // Si estamos editando y el nombre es el original, no hacemos nada
        if (edit && nombre.toLowerCase() === originalName.toLowerCase()) {
            hideStatus();
            return;
        }

        // Hacemos la petición AJAX para buscar coincidencias
        $.ajax({
            url: './backend/product-search.php?search=' + nombre,
            type: 'GET',
            success: function (response) {
                const productos = JSON.parse(response);
                let nameExists = false;
                
                // Revisamos si algún producto devuelto TIENE EL NOMBRE EXACTO
                if(Object.keys(productos).length > 0) {
                    productos.forEach(producto => {
                        if (producto.nombre.toLowerCase() === nombre.toLowerCase()) {
                            nameExists = true;
                        }
                    });
                }

                if (nameExists) {
                    showStatus('Error: Ese nombre de producto ya existe en la BD.', true);
                } else {
                    showStatus('Nombre de producto disponible.', false);
                }
            }
        });
    });


    function listarProductos() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                const productos =response;
                if(Object.keys(productos).length > 0) {
                    let template = '';
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
                                <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#products').html(template);
                }
            }
        });
    }

    $('#search').keyup(function() {
        if($('#search').val()) {
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php?search='+$('#search').val(),
                data: {search},
                type: 'GET',
                success: function (response) {
                    if(!response.error) {
                        const productos = response;
                        if(Object.keys(productos).length > 0) {
                            let template = '';
                            let template_bar = '';
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
                                        <td><a href="#" class="product-item">${producto.nombre}</a></td>
                                        <td><ul>${descripcion}</ul></td>
                                        <td>
                                            <button class="product-delete btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                template_bar += `
                                    <li>${producto.nombre}</il>
                                `;
                            });
                            $('#product-result').show();
                            $('#container').html(template_bar);
                            $('#products').html(template);    
                        }
                    }
                }
            });
        }
        else {
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();

        // --- Tarea 5.2: Validar campos requeridos antes de enviar ---
        let isValid = true;
        let fieldsToValidate = ['#name', '#precio', '#unidades', '#modelo', '#marca', '#detalles', '#imagen'];
        
        for (const fieldId of fieldsToValidate) {
            let $field = $(fieldId);
            if ($field.val().trim() === '') {
                let fieldName = $field.attr('placeholder');
                
                // << --- MODIFICACIÓN: Se usa alert() --- >>
                alert(`Error: El campo "${fieldName}" es obligatorio para guardar.`);
                // << ------------------------------------ >>

                isValid = false;
                break; // Detener en el primer error
            }
        }

        if (!isValid) {
            return; // Detiene el envío del formulario
        }
        // --- Fin Tarea 5.2 ---

        // (Task 5) Se obtienen los datos de los nuevos campos
        const postData = {
            nombre: $('#name').val(),
            precio: $('#precio').val(),
            unidades: $('#unidades').val(),
            modelo: $('#modelo').val(),
            marca: $('#marca').val(),
            detalles: $('#detalles').val(),
            imagen: $('#imagen').val(),
            id: $('#productId').val()
        };

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
            let respuesta = response;
            
            // (Task 6) Se usa la función de status para mostrar la respuesta del servidor
            let isError = (respuesta.status !== 'success');
            showStatus(respuesta.message, isError);

            // Solo reiniciamos si fue exitoso
            if (!isError) {
                // (Task 5) Se reinician los nuevos campos del formulario
                $('#product-form').trigger('reset'); // Resetea todos los campos
                $('#productId').val(''); // Asegura limpiar el ID oculto

                listarProductos();
                
                edit = false;
                originalName = ''; // Limpia el nombre original
                $('button.btn-primary').text("Agregar Producto");
            }
        });
    });

   $(document).on('click', '.product-delete', function(e) { 
    if(confirm('¿Realmente deseas eliminar el producto?')) {
        const id = $(this).closest('tr').attr('productId'); 
        
        $.post('./backend/product-delete.php', {id}, (response) => {
            
            // --- CÓDIGO CORREGIDO ---
            
            // 1. Leemos la respuesta del servidor
            let respuesta = response;
            let isError = (respuesta.status !== 'success');

            // 2. Usamos showStatus() para mostrar el mensaje
            //    (ej: "Producto eliminado")
            showStatus(respuesta.message, isError);
            
            // 3. Recargamos la lista
            listarProductos();
        });
    }
});

    $(document).on('click', '.product-item', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('productId');
        $.post('./backend/product-single.php', {id}, (response) => {
            let product = response;
            
            // (Task 5) Se insertan los datos en los nuevos campos
            $('#name').val(product.nombre);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#modelo').val(product.modelo);
            $('#marca').val(product.marca);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);
            
            // (Task 7) Guardamos el nombre original para la validación
            originalName = product.nombre;
            edit = true;
            $('button.btn-primary').text("Modificar Producto");

            // (Task 6) Ocultamos cualquier mensaje de estado previo
            hideStatus();
        });
        e.preventDefault();
    });    
});