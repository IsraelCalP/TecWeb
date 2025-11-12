<?php
// 1. Usar el namespace y la clase
use TECWEB\MYAPI\Products;

// 2. Incluir el archivo de la clase (que ya incluye DataBase.php)
require_once __DIR__ . '/myapi/Products.php';

/*
 *
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );
    if(isset($_POST['nombre'])) {
        // SE TRANSFORMA EL POST A UN STRING EN JSON, Y LUEGO A OBJETO
        $jsonOBJ = json_decode( json_encode($_POST) );
        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
	    $result = $conexion->query($sql);
        
        if ($result->num_rows == 0) {
            $conexion->set_charset("utf8");
            $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            if($conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto agregado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
            }
        }

        $result->free();
        // Cierra la conexion
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
*/


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