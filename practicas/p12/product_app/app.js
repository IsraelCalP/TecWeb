$(document).ready(function(){
    let edit = false;
    let originalName = ''; 

    // Se eliminó la inicialización del textarea JSON
    $('#product-result').hide();
    listarProductos();

    // --- Funciones de Estado ---
    function showStatus(message, isError = false) {
        let color = isError ? '#F57373' : '#73F583'; 
        let template_bar = `<li style="list-style: none; color: ${color};">${message}</li>`;
        $('#product-result').show();
        $('#container').html(template_bar);
    }

    function hideStatus() {
        $('#product-result').hide();
        $('#container').html('');
    }

    // --- Validación al perder foco (on-blur) y tipos de datos ---
    $('#precio, #unidades, #modelo, #marca, #detalles, #imagen').blur(function() {
        let fieldName = $(this).attr('placeholder');
        let value = $(this).val().trim();

        if (value === '') {
            showStatus(`El campo "${fieldName}" no puede estar vacío.`, true);
            return;
        } 
        
        // Validación de formato numérico
        if ($(this).is('#precio') || $(this).is('#unidades')) {
            let isInteger = $(this).is('#unidades');
            let isError = false;
            
            let num = isInteger ? parseInt(value) : parseFloat(value);

            if (isNaN(num) || num < 0) {
                 isError = true;
            } else if (isInteger && num != parseFloat(value)) {
                isError = true; // No permite decimales en unidades
            }

            if (isError) {
                let typeMsg = isInteger ? 'un entero positivo' : 'un número positivo';
                showStatus(`Error: El campo "${fieldName}" debe ser ${typeMsg}.`, true);
                return;
            }
        }
        
        showStatus(`Campo "${fieldName}" validado.`, false);
    });
    
    // --- Validación asíncrona de nombre de producto ---
    $('#name').keyup(function() {
        let nombre = $(this).val().trim();
        
        if (nombre === '') {
            showStatus('El campo "Nombre de producto" no puede estar vacío.', true);
            return;
        }

        if (edit && nombre.toLowerCase() === originalName.toLowerCase()) {
            hideStatus();
            return;
        }

        $.ajax({
            url: './backend/product-search.php?search=' + nombre,
            type: 'GET',
            success: function (response) {
                const productos = JSON.parse(response); 
                let nameExists = false;
                
                if(Object.keys(productos).length > 0 && Array.isArray(productos)) {
                    productos.forEach(producto => {
                        if (producto.nombre && producto.nombre.toLowerCase() === nombre.toLowerCase()) {
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
                const productos = JSON.parse(response);
            
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
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#products').html(template);
                } else {
                    $('#products').html('<tr><td colspan="4" class="text-center">No hay productos disponibles.</td></tr>');
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
                        const productos = JSON.parse(response);
                        
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

        let postData = {};
        let errors = [];
        
        hideStatus();

        // Lista de campos a validar y recopilar
        const fieldsToValidate = [
            { id: '#name', key: 'nombre', placeholder: 'Nombre de producto', type: 'string' },
            { id: '#precio', key: 'precio', placeholder: 'Precio', type: 'float' },
            { id: '#unidades', key: 'unidades', placeholder: 'Unidades', type: 'integer' },
            { id: '#modelo', key: 'modelo', placeholder: 'Modelo', type: 'string' },
            { id: '#marca', key: 'marca', placeholder: 'Marca', type: 'string' },
            { id: '#detalles', key: 'detalles', placeholder: 'Detalles', type: 'string' },
            { id: '#imagen', key: 'imagen', placeholder: 'Ruta de Imagen (ej: img/default.png)', type: 'string' }
        ];

        // 1. Recopilación de datos y validación de campos requeridos/tipos
        fieldsToValidate.forEach(field => {
            let $field = $(field.id);
            let value = $field.val().trim();
            
            // 1a: Campo faltante o vacío
            if (value === '') {
                errors.push(`El campo "${field.placeholder}" es obligatorio.`);
                return;
            } 
            
            // 1b: Validación numérica
            if (field.type === 'float' || field.type === 'integer') {
                if (field.type === 'float') {
                    let num = parseFloat(value);
                    if (isNaN(num) || num < 0) {
                        errors.push(`El "${field.placeholder}" debe ser un número positivo (decimal permitido).`);
                    } else {
                        postData[field.key] = num;
                        return;
                    }
                } else if (field.type === 'integer') {
                    let num = parseInt(value);
                    if (isNaN(num) || num < 0 || num != parseFloat(value)) {
                        errors.push(`Las "${field.placeholder}" deben ser un número entero positivo.`);
                    } else {
                        postData[field.key] = num;
                        return;
                    }
                }
            }
            
            postData[field.key] = value;
        });

        // 2. VALIDACIÓN ASÍNCRONA DE NOMBRE (Revisar si el keyup reportó un error)
        if ($('#container').html().includes('Error: Ese nombre de producto ya existe')) {
            errors.push('El nombre del producto ya existe en la BD.');
        }

        // 3. Finalización de postData y manejo de errores
        postData['id'] = $('#productId').val();

        if (errors.length > 0) {
            let error_html = '';
            errors.forEach(error => {
                error_html += `<li style="list-style: none; color: red;">- ${error}</li>`;
            });
            $('#product-result').show();
            $('#container').html('<li style="list-style: none; color: red; font-weight: bold;">Error de Validación:</li>' + error_html);
            return; 
        }

        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);
            
            let isError = (respuesta.status !== 'success');
            showStatus(respuesta.message, isError);

            // Reiniciar si es exitoso
            if (!isError) {
                $('#product-form').trigger('reset');
                $('#productId').val('');
                listarProductos();
                edit = false;
                originalName = '';
                $('button[type="submit"]').text("Agregar Producto");
            }
        });
    });

    // --- LÓGICA DE ELIMINACIÓN ---
    $(document).on('click', '.product-delete', function(e) { 
        const id = $(this).closest('tr').attr('productId'); 
        
        if(!id) {
            showStatus("Error interno: ID del producto no encontrado para eliminar.", true);
            return; 
        }

        if(confirm('¿Realmente deseas eliminar el producto con ID ' + id + '?')) {
            $.post('./backend/product-delete.php', {id: id}, (response) => { 
                let respuesta = JSON.parse(response);
                let isError = (respuesta.status !== 'success');
                showStatus(respuesta.message, isError);

                listarProductos();
            });
        }
    });

    // --- LÓGICA DE EDICIÓN (Carga de datos) ---
    $(document).on('click', '.product-item', function(e) { 
        e.preventDefault();
        const id = $(this).closest('tr').attr('productId'); 
        
        $.post('./backend/product-single.php', {id: id}, (response) => {
            let product = JSON.parse(response);
            
            // 1. Establece banderas y oculta status ANTES de cargar los valores
            edit = true;
            originalName = product.nombre;
            hideStatus(); 

            // 2. Carga datos a los campos individuales
            $('#name').val(product.nombre);
            $('#precio').val(product.precio);
            $('#unidades').val(product.unidades);
            $('#modelo').val(product.modelo);
            $('#marca').val(product.marca);
            $('#detalles').val(product.detalles);
            $('#imagen').val(product.imagen);
            $('#productId').val(product.id);
            
            // 3. Cambia el texto del botón
            $('button[type="submit"]').text("Modificar Producto");
        });
    });    
});