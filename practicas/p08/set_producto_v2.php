<?php
$nombre   = $_POST['name'];
$marca    = $_POST['marca'];
$modelo   = $_POST['modelo'];
$precio   = $_POST['precio'];
$detalles = $_POST['story'];
$unidades = $_POST['cantidad'];
$imagen   = $_POST['imagen'];

/** SE CREA EL OBJETO DE CONEXION */
@$link = new mysqli('localhost', 'root', 'Isra2818', 'marketzone');

/** comprobar la conexión */
if ($link->connect_errno) {
    die('Falló la conexión: '.$link->connect_error.'<br/>');
}

/** Verificación de que un producto ya existe */
$stmt = $link->prepare("SELECT 1 FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?");
$stmt->bind_param("sss", $nombre, $marca, $modelo);
$stmt->execute();

if ($stmt->get_result()->num_rows > 0) {
    echo '<p style="color:red;">Error: Este producto ya existe en la base de datos.</p>';
    $stmt->close();
} else {
    $stmt->close();

    /** Insertar nuevo producto con eliminado = 0 */
    $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado)
            VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)";

    // Puedes descomentar esta línea si quieres ver la consulta generada:
    // echo $sql;

    if ($link->query($sql)) {
        echo '<p style="color:green;">Producto insertado con ID: '.$link->insert_id.'</p>';

        echo '<h2>Resumen del producto insertado:</h2>';
        echo '<ul>';
        echo '<li><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</li>';
        echo '<li><strong>Marca:</strong> ' . htmlspecialchars($marca) . '</li>';
        echo '<li><strong>Modelo:</strong> ' . htmlspecialchars($modelo) . '</li>';
        echo '<li><strong>Precio:</strong> $' . number_format($precio, 2) . '</li>';
        echo '<li><strong>Detalles:</strong> ' . htmlspecialchars($detalles) . '</li>';
        echo '<li><strong>Unidades:</strong> ' . htmlspecialchars($unidades) . '</li>';
        echo '<li><strong>Imagen:</strong> <img src="' . htmlspecialchars($imagen) . '" width="150"></li>';
        echo '<li><strong>Eliminado:</strong> 0 (no eliminado)</li>';
        echo '</ul>';
    } else {
        echo '<p style="color:red;">El producto no pudo ser insertado: ' . $link->error . '</p>';
    }
}

$link->close();
?>
