<?php
    
    require_once __DIR__ . '/src/funciones.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 6</title>
</head>
<body>
    
    <h2>1. Múltiplo de 5 y 7</h2>
    <p>Para probar, agrega en la URL: ?Numero que desees comprobar</p>
    <?php
        if (isset($_GET['numero'])) {
            $num = $_GET['numero'];
            
            echo multiplo($num) ? "$num es múltiplo de 5 y 7." : "$num no es múltiplo de 5 y 7.";
        }
    ?>
</body>
</html>