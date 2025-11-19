<?php
    use TECWEB\MYAPI\Products;
    require_once __DIR__ . '/myapi/Products.php';


header('Content-Type: application/json');

try {
    // 3. Crear una instancia de la clase Products 
    $productos = new Products("marketzone", "root", "Isra2818"); 

    // 4. Usar el método correcto 
    $productos->list();

    // 5. Devolver la respuesta en formato JSON 
    echo $productos->getData();

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
