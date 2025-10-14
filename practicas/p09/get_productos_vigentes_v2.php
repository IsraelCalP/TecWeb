<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos Vigentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h3>Productos Vigentes</h3>
    <br/>

    <?php
    /** SE CREA EL OBJETO DE CONEXION */
    @$link = new mysqli('localhost', 'root', 'Isra2818', 'marketzone');

    /** comprobar la conexión */
    if ($link->connect_errno) {
        die('Falló la conexión: '.$link->connect_error.'<br/>');
    }

    /** Crear la consulta SQL para mostrar solo productos no eliminados */
    $sql = "SELECT * FROM productos WHERE eliminado = 0";

    /** Ejecutar la consulta */
    if ($result = $link->query($sql)) {
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
            echo '<div class="alert alert-warning" role="alert">No se encontraron productos vigentes.</div>';
        }
        $result->free();
    } else {
        echo '<div class="alert alert-danger" role="alert">Error al ejecutar la consulta.</div>';
    }

    $link->close();
    ?>
</body>
</html>
