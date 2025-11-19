<?php
// 1. Usar el namespace y la clase
use TECWEB\MYAPI\Products;

// 2. Incluir el archivo de la clase (que ya incluye DataBase.php)
require_once __DIR__ . '/myapi/Products.php';



// Indicar que la respuesta es JSON
header('Content-Type: application/json');

try {
    // 3. (c) Crea una instancia de la clase Products
    $productos = new Products("marketzone", "root", "Isra2818");

    // 4. (d) Usa el método correcto para la operación
    $productos->add($_POST);

    // 5. (e) Usa getData() para devolver la respuesta JSON
    echo $productos->getData();

} catch (Exception $e) {
    // Manejo de errores por si la conexión falla
    echo json_encode(['error' => $e->getMessage()]);
}
?>