<?php
// Incluir el archivo de conexión a la base de datos
include_once __DIR__.'/database.php';

// Variable para almacenar la respuesta que se enviará al cliente
$response = [];

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto_json = file_get_contents('php://input');

if (!empty($producto_json)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO PHP
    $data = json_decode($producto_json);

    // Validar que los datos necesarios no estén vacíos
    if (!isset($data->nombre) || !isset($data->marca) || !isset($data->modelo) || !isset($data->precio) || !isset($data->unidades)) {
        $response = ['status' => 'error', 'message' => 'Datos incompletos.'];
    } else {
        // Asignar datos a variables para mayor claridad
        $nombre = $conn->real_escape_string($data->nombre);
        $marca = $conn->real_escape_string($data->marca);
        $modelo = $conn->real_escape_string($data->modelo);
        $precio = floatval($data->precio);
        $detalles = $conn->real_escape_string($data->detalles);
        $unidades = intval($data->unidades);
        $imagen = 'img/default.png'; // Valor por defecto para la imagen

        // 1. VALIDACIÓN EN SERVIDOR: VERIFICAR SI EL PRODUCTO YA EXISTE
        // Se busca un producto activo (eliminado = 0) que coincida con (nombre Y marca) O (marca Y modelo)
        $query_check = "SELECT id FROM productos WHERE ((nombre = ? AND marca = ?) OR (marca = ? AND modelo = ?)) AND eliminado = 0";
        
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("ssss", $nombre, $marca, $marca, $modelo);
        $stmt_check->execute();
        $stmt_check->store_result(); // Necesario para poder usar num_rows

        if ($stmt_check->num_rows > 0) {
            // Si se encuentra un producto, se prepara una respuesta de error
            $response = ['status' => 'error', 'message' => 'El producto ya existe en la base de datos.'];
        } else {
            // 2. INSERCIÓN: Si no existe, se procede a insertar el nuevo producto
            $query_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt_insert = $conn->prepare($query_insert);
            // 'sssdsis' indica los tipos de datos: string, string, string, double, string, integer, string
            $stmt_insert->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);

            if ($stmt_insert->execute()) {
                $response = ['status' => 'success', 'message' => 'Producto agregado exitosamente.'];
            } else {
                $response = ['status' => 'error', 'message' => 'Error al agregar el producto: ' . $conn->error];
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
} else {
    $response = ['status' => 'error', 'message' => 'No se recibieron datos.'];
}

$conn->close();

// Devolver la respuesta en formato JSON al cliente
header('Content-Type: application/json');
echo json_encode($response);
?>