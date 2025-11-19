<?php
use TECWEB\MYAPI\Products;
require_once __DIR__ . '/myapi/Products.php';
header('Content-Type: application/json');
   
    try {
    // 3. Crear instancia
    $productos = new Products("marketzone", "root", "Isra2818");

    // 4. Invocar al método search() pasándole los datos del GET
    $productos->search($_GET);

    // 5. Devolver respuesta JSON
    echo $productos->getData();

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>