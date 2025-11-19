<?php
    use TECWEB\MYAPI\Products;
    require_once __DIR__ . '/myapi/Products.php';
header('Content-Type: application/json');

   
try {
    // (Paso 3.c) Crear instancia
    $productos = new Products("marketzone", "root", "Isra2818");

    // (Paso 3.d) Invocar al método edit() pasándole los datos del POST
    $productos->edit($_POST);

    // (Paso 3.e) Devolver respuesta JSON (¡CORREGIDO!)
    // Esta línea ahora tiene 'echo'
    echo $productos->getData();

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>