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
    <?php
    	    echo "<h2>Inciso 3. Mostrar contenido de variables después de la asignación.</h2>";
	    $a = "PHP5";
    	    echo "Variable \$a: $a <br>";

    	    $z[] = &$a;
    	    echo "Arreglo \$z después de agregar \$a:<br>";
    	    echo "<pre>";
    	    print_r($z);
    	    echo "</pre>";

            $b = "5a version de PHP";
            echo "Variable \$b: $b <br>";

            @$c = $b * 10; 
            echo "Variable \$c: $c <br>";

    	    $a .= $b; 
            echo "Variable \$a después de concatenar \$b: $a <br>";

            @$b *= $c; 
            echo "Variable \$b después de multiplicar por \$c: $b <br>";

            $z[0] = "MySQL";
            echo "Arreglo \$z después de cambiar \$z[0]:<br>";
            echo "<pre>";
            print_r($z);
            echo "</pre>";

            unset($a, $b, $c, $z);
    ?>
     <?php
    	    echo "<h2>Inciso 4. Mostrar contenido de variables después de la asignación con \$GLOBALS</h2>";

    	    $GLOBALS['a'] = "PHP5";
	        echo "Variable \$a: " . $GLOBALS['a'] . "<br>";
	        $GLOBALS['z'][] = &$GLOBALS['a'];
	        echo "Arreglo \$z:<br>";
	        echo "<pre>";
	        print_r($GLOBALS['z']);
	        echo "</pre>";

	        $GLOBALS['b'] = "5a version de PHP";
	        echo "Variable \$b: " . $GLOBALS['b'] . "<br>";

	        @$GLOBALS['c'] = $GLOBALS['b'] * 10;
	        echo "Variable \$c: " . $GLOBALS['c'] . "<br>";

	        $GLOBALS['a'] .= $GLOBALS['b'];
	        echo "Variable \$a después de concatenar \$b: " . $GLOBALS['a'] . "<br>";

	        @$GLOBALS['b'] *= $GLOBALS['c'];
	        echo "Variable \$b después de multiplicar por \$c: " . $GLOBALS['b'] . "<br>";

	        $GLOBALS['z'][0] = "MySQL";
	        echo "Arreglo \$z después de cambiar \$z[0]:<br>";
	        echo "<pre>";
	        print_r($GLOBALS['z']);
	        echo "</pre>";

	        unset($GLOBALS['a'], $GLOBALS['b'], $GLOBALS['c'], $GLOBALS['z']);
    ?> 
     <?php
	        echo "<h2>Inciso 5. Dar valor a variables \$a, \$b, \$c</h2>";

	        $a = "7 personas";
	        $b = (int) $a;
	        $a = "9e3";
	        $c = (float) $a;

	        echo "Variable \$a: $a <br>";
	        echo "Variable \$b: $b <br>";
	        echo "Variable \$c: $c <br>";
    ?>
    <?php
            echo "<h2>Inciso 6. Compronar valor booleano variables</h2>";
            $a = "0";
            $b = "TRUE";
            $c = FALSE;
            $d = ($a OR $b);
            $e = ($a AND $c);
            $f = ($a XOR $b);

            echo "Variable \$a: ", var_dump($a);
            echo "<br>";
            echo "Variable \$b: ", var_dump($b);
            echo "<br>";
            echo "Variable \$c: ", var_dump($c);
            echo "<br>";
            echo "Variable \$d: ", var_dump($d);
            echo "<br>";
            echo "Variable \$e: ", var_dump($e);
            echo "<br>";
            echo "Variable \$f: ", var_dump($f);
    ?>
</body>
</html>