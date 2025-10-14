<?php
// update_producto.php

// Conexión a la base de datos
$link = mysqli_connect("localhost", "root", "Isra2818", "marketzone"); 

if($link === false){ 
    die("ERROR: No se pudo conectar con la DB. " . mysqli_connect_error()); 
}

// Verificar que los datos necesarios fueron enviados
if(!isset($_POST['id'], $_POST['name'], $_POST['marca'], $_POST['modelo'], $_POST['precio'], $_POST['cantidad'], $_POST['story'], $_POST['imagen'])){
    die("ERROR: Faltan datos del producto.");
}

// Recibir datos del formulario
$id = intval($_POST['id']);
$nombre = mysqli_real_escape_string($link, $_POST['name']);
$marca = mysqli_real_escape_string($link, $_POST['marca']);
$modelo = mysqli_real_escape_string($link, $_POST['modelo']);
$precio = floatval($_POST['precio']);
$cantidad = intval($_POST['cantidad']);
$detalles = mysqli_real_escape_string($link, $_POST['story']);
$imagen = mysqli_real_escape_string($link, $_POST['imagen']);

// Consulta SQL para actualizar
$sql = "UPDATE productos SET 
        nombre='$nombre', 
        marca='$marca', 
        modelo='$modelo', 
        precio=$precio, 
        unidades=$cantidad, 
        detalles='$detalles', 
        imagen='$imagen'
        WHERE id=$id";

// Ejecutar consulta
if(mysqli_query($link, $sql)){
    echo "<div>Registro actualizado correctamente.</div>";
} else { 
    echo "ERROR: No se ejecutó $sql. " . mysqli_error($link); 
}

// Hipervínculos de navegación
echo '<br><a href="get_productos_xhtml_v2.php">Volver al listado de productos</a>';
echo '<br><a href="get_productos_vigentes_v2.php">Volver a productos vigentes</a>';

// Cerrar conexión
mysqli_close($link); 
?>
