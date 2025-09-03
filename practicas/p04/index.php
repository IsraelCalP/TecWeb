<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4 Variables php</title>
</head>
<body>
    <h2>Manejo de variables en php</h2>
    <?php
            echo "<h2>Inciso 1. Variables validas</h2>";
            echo '$_myvar: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php';
            echo "<br>";
            echo '$_7var: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php';
            echo "<br>";
            echo 'myvar: no es valida, porque no comienza con el signo de $, no sigue la nomenclatura de php';
            echo "<br>";
            echo '$myvar: es valida, porque comienza el signo $, sigue la nomenclatura de php';
            echo "<br>";
            echo '$var7: es valida, porque comienza con el signo $, sigue la nomenclatura de php';
            echo "<br>";
            echo '$_element1: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php';
	    echo "<br>";
            echo '$house*5: no es valida, porque tiene un signo *, no sigue la nomenclatura de php';
        ?>
    <?php
       	    echo "<h2>Inciso 2. Proporcionar valores</h2>";
            echo "<h3>a)</h3>";
            $a = "ManejadorSQL";
            $b = 'MySQL';
            $c = &$a;

            echo "Variable \$a: $a <br>";
            echo "Variable \$b: $b <br>";
            echo "Variable \$c: $c <br>";

            echo "<h3>b) y c)</h3>";
            $a = "PHP server";
            $b = &$a;

            echo "Variable \$a: $a <br>";
            echo "Variable \$b: $b <br>";
            echo "Variable \$c: $c <br>";

            echo "<h3>d)</h3>";
            echo "La variable \$a cambia su valor a 'PHP server' y como las variables \$b y \$c son referencias de \$a, toman el mismo valor.";
        ?>
</body>
</html>