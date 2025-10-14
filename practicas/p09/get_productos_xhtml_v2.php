<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos por Tope de Unidades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h3>Productos con Unidades Menores o Iguales al Tope Especificado</h3>
    <br/>

    <?php
    // Validar que el parámetro 'tope' fue proporcionado
    if(isset($_GET['tope'])) {
        $tope = $_GET['tope'];
    } else {
        // Si no se proporciona el tope, se muestra un mensaje y se termina el script.
        die('<div class="alert alert-danger" role="alert">Error: El parámetro "tope" no fue especificado.</div>');
    }

    // Asegurarse de que el tope no esté vacío y sea un número.
    if (!empty($tope) && is_numeric($tope)) {
        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', 'Isra2818', 'marketzone');

        /** comprobar la conexión */
        if ($link->connect_errno) {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
        }

        /** Crear la consulta SQL con el parámetro tope */
        $sql = "SELECT * FROM productos WHERE unidades <= {$tope}";

        /** Ejecutar la consulta */
        if ($result = $link->query($sql)) {
            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
    ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Unidades</th>
                            <th scope="col">Detalles</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Modificar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Iterar sobre los resultados y mostrarlos en la tabla
                        while($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <th scope="row"><?= $row['id'] ?></th>
                                <td><?= utf8_encode($row['nombre']) ?></td>
                                <td><?= $row['marca'] ?></td>
                                <td><?= $row['modelo'] ?></td>
                                <td>$<?= number_format($row['precio'], 2) ?></td>
                                <td><?= $row['unidades'] ?></td>
                                <td><?= utf8_encode($row['detalles']) ?></td>
                                <td><img src="<?= $row['imagen'] ?>" alt="Imagen del producto" style="max-width: 100px;"></td>
                                <td><a href="formulario_productos_v2.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
    <?php
            } else {
                // Si no hay productos que cumplan la condición
                echo '<div class="alert alert-warning" role="alert">No se encontraron productos con unidades menores o iguales a ' . $tope . '.</div>';
            }
            // Liberar la memoria del resultado
            $result->free();
        } else {
            // Si hay un error en la consulta
            echo '<div class="alert alert-danger" role="alert">Error al ejecutar la consulta.</div>';
        }
        // Cerrar la conexión
        $link->close();
    } else {
        // Si el parámetro 'tope' no es válido
        echo '<div class="alert alert-danger" role="alert">El valor del parámetro "tope" no es válido.</div>';
    }
    ?>
</body>
</html>