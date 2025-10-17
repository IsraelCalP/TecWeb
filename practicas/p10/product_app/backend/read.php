<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Isra2818');
define('DB_NAME', 'marketzone');

$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conexion) {
    // Para producción, es mejor no mostrar detalles del error al usuario final
    // En su lugar, se podría registrar el error en un archivo de log.
    die(json_encode(['error' => 'Error de conexión a la base de datos.']));
}

$data = array();

// 1. VERIFICAR HABER RECIBIDO UN DATO POR GET 
if (isset($_GET['search'])) {
    
    // 2. PREPARAR LA CONSULTA PARA MÁXIMA SEGURIDAD
    // Usamos '?' como marcador de posición para los datos.
    $sql = "SELECT * FROM productos 
            WHERE eliminado = 0 AND (
                nombre LIKE ? 
                OR marca LIKE ? 
                OR detalles LIKE ?
            )";
    
    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // 3. VINCULAR LOS PARÁMETROS
        // Se crea el término de búsqueda con los comodines '%'
        $searchTerm = "%" . $_GET['search'] . "%";
        
        // 'sss' indica que los tres parámetros son de tipo string (cadena)
        $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
        
        // 4. EJECUTAR LA CONSULTA
        $stmt->execute();
        
        // Obtener los resultados
        $result = $stmt->get_result();
        
        // Recorrer los resultados y guardarlos en el array
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        // Cerrar la sentencia
        $stmt->close();
    } else {
        // Manejo de error si la preparación de la consulta falla
        die(json_encode(['error' => 'Error en la preparación de la consulta.']));
    }
}

// Cerrar la conexión
$conexion->close();

// Devolver el resultado como JSON. La respuesta será un array vacío [] si no hay búsqueda o resultados.
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);

?>