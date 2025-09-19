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
    <hr />

    <h2>2. Secuencia aleatoria (impar, par, impar)</h2>
    <?php
       
        list($matriz, $iteracion, $numgenerado) = secuencia();

        echo '<table border="1" cellpadding="5">';
        foreach ($matriz as $fila) {
            echo "<tr><td>" . implode("</td><td>", $fila) . "</td></tr>";
        }
        echo "</table>";
        echo "<p><b>$numgenerado</b> números generados en <b>$iteracion</b> iteraciones.</p>";
    ?>

    <hr />

     <h2>3. Múltiplo aleatorio con while y do-while</h2>
    <p>Para probar, agrega en la URL: ?multiplo=número que desees buscar</p>
    <?php
    if (isset($_GET['multiplo'])) {
        $multiplo = $_GET['multiplo'];
        if (is_numeric($multiplo) && $multiplo > 0) {
            
            $resultadoWhile = multiploAleatorioWhile($multiplo);
            echo "<h3>Con ciclo while</h3>";
            echo "<p>El primer múltiplo de $multiplo encontrado es <b>$resultadoWhile</b>.</p>";

        
            $resultadoDoWhile = multiploAleatorioDoWhile($multiplo);
            echo "<h3>Con ciclo do-while</h3>";
            echo "<p>El primer múltiplo de $multiplo encontrado es <b>$resultadoDoWhile</b>.</p>";
        }
    }
    ?>

    <hr />

    <h2>4. Arreglo de letras con ASCII</h2>
    <?php
        
        $arregloLetras = arregloAcsii();
        
        echo '<table border="1" cellpadding="5">';
        echo '<tr><th>Código ASCII</th><th>Letra</th></tr>';
        foreach ($arregloLetras as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo '</table>';
    ?>

    <hr />

</body>
</html>