<?php
use TECWEB\MYAPI\Products;
require_once __DIR__ . '/myapi/Products.php';
header('Content-Type: application/json');

    /*// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array(
        'status'  => 'error',
        'message' => 'La consulta falló'
    );
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_POST['id']) ) {
        $id = $_POST['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
        if ( $conexion->query($sql) ) {
            $data['status'] =  "success";
            $data['message'] =  "Producto eliminado";
		} else {
            $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
        }
		$conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT); */

    try {
    // 3. Crear instancia
    $productos = new Products("marketzone", "root", "Isra2818");

    // 4. Invocar al método delete() pasándole los datos del POST
    $productos->delete($_POST);

    // 5. Devolver respuesta JSON
    echo $productos->getData();

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>