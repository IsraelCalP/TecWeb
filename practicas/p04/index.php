<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4 Variables php</title>
</head>
<body>
    <h2>Manejo de variables en php</h2>

    <?php
        echo "<h3>Inciso 1. Variables válidas</h3>";
        echo "<p>";
        echo '$_myvar: es válida, porque comienza con un guion bajo, sigue la nomenclatura de PHP.<br />';
        echo '$_7var: es válida, porque comienza con un guion bajo, sigue la nomenclatura de PHP.<br />';
        echo 'myvar: no es válida, porque no comienza con el signo de $, no sigue la nomenclatura de PHP.<br />';
        echo '$myvar: es válida, porque comienza con el signo $, sigue la nomenclatura de PHP.<br />';
        echo '$var7: es válida, porque comienza con el signo $, sigue la nomenclatura de PHP.<br />';
        echo '$_element1: es válida, porque comienza con un guion bajo, sigue la nomenclatura de PHP.<br />';
        echo '$house*5: no es válida, porque tiene un signo *, no sigue la nomenclatura de PHP.';
        echo "</p>";
    ?>

    <?php
        echo "<h3>Inciso 2. Proporcionar valores</h3>";
        echo "<h4>a)</h4>";
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;
        echo "<p>Variable \$a: $a <br />Variable \$b: $b <br />Variable \$c: $c</p>";

        echo "<h4>b) y c)</h4>";
        $a = "PHP server";
        $b = &$a;
        echo "<p>Variable \$a: $a <br />Variable \$b: $b <br />Variable \$c: $c</p>";

        echo "<h4>d)</h4>";
        echo "<p>La variable \$a cambia su valor a 'PHP server' y como las variables \$b y \$c son referencias de \$a, toman el mismo valor.</p>";
    ?>

    <?php
        echo "<h3>Inciso 3. Mostrar contenido de variables después de la asignación.</h3>";
        $a = "PHP5";
        echo "<p>Variable \$a: $a</p>";

        $z[] = &$a;
        echo "<p>Arreglo \$z después de agregar \$a:</p><pre>";
        print_r($z);
        echo "</pre>";

        $b = "5a version de PHP";
        @$c = $b * 10;
        $a .= $b;
        @$b *= $c;
        echo "<p>Variable \$b: 5a version de PHP <br />Variable \$c: 50 <br />Variable \$a después de concatenar \$b: 5050 <br />Variable \$b después de multiplicar por \$c: 25502500</p>";

        $z[0] = "MySQL";
        echo "<p>Arreglo \$z después de cambiar \$z[0]:</p><pre>";
        print_r($z);
        echo "</pre>";

        unset($a, $b, $c, $z);
    ?>

    <?php
        echo "<h3>Inciso 4. Mostrar contenido de variables después de la asignación con \$GLOBALS</h3>";
        $GLOBALS['a'] = "PHP5";
        echo "<p>Variable \$a: " . $GLOBALS['a'] . "</p>";

        $GLOBALS['z'][] = &$GLOBALS['a'];
        echo "<p>Arreglo \$z:</p><pre>";
        print_r($GLOBALS['z']);
        echo "</pre>";

        $GLOBALS['b'] = "5a version de PHP";
        @$GLOBALS['c'] = $GLOBALS['b'] * 10;
        $GLOBALS['a'] .= $GLOBALS['b'];
        @$GLOBALS['b'] *= $GLOBALS['c'];

        echo "<p>Variable \$b: 5a version de PHP<br />Variable \$c: 50<br />Variable \$a después de concatenar \$b: PHP55a version de PHP<br />Variable \$b después de multiplicar por \$c: 250</p>";

        $GLOBALS['z'][0] = "MySQL";
        echo "<p>Arreglo \$z después de cambiar \$z[0]:</p><pre>";
        print_r($GLOBALS['z']);
        echo "</pre>";

        unset($GLOBALS['a'], $GLOBALS['b'], $GLOBALS['c'], $GLOBALS['z']);
    ?>

    <?php
        echo "<h3>Inciso 5. Dar valor a variables \$a, \$b, \$c</h3>";
        $a = "7 personas";
        $b = (int) $a;
        $a = "9e3";
        $c = (float) $a;
        echo "<p>Variable \$a: $a <br />Variable \$b: $b <br />Variable \$c: $c</p>";
    ?>

    <?php
        echo "<h3>Inciso 6. Comprobar valor booleano de variables</h3>";
        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a OR $b);
        $e = ($a AND $c);
        $f = ($a XOR $b);

        echo "<p>Variable \$a:</p><pre>"; var_dump($a); echo "</pre>";
        echo "<p>Variable \$b:</p><pre>"; var_dump($b); echo "</pre>";
        echo "<p>Variable \$c:</p><pre>"; var_dump($c); echo "</pre>";
        echo "<p>Variable \$d:</p><pre>"; var_dump($d); echo "</pre>";
        echo "<p>Variable \$e:</p><pre>"; var_dump($e); echo "</pre>";
        echo "<p>Variable \$f:</p><pre>"; var_dump($f); echo "</pre>";
    ?>

    <?php
        echo "<h4>Transformación de valor booleano de la variable</h4>";
        echo "<p>Variable \$c: " . (int)$c . "<br />Variable \$e: " . (int)$e . "</p>";
    ?>

    <?php
        echo "<h3>Inciso 7: Uso de variable \$_SERVER</h3>";
        echo "<p>Versión de apache: " . $_SERVER['SERVER_SOFTWARE'] . "<br />";
        echo "Versión de php: " . phpversion() . "<br />";
        echo "Nombre del sistema operativo: " . PHP_OS . "<br />";
        echo "Idioma de navegador: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "</p>";
    ?>

    <p>
        <a href="https://validator.w3.org/check?uri=referer">
            <img src="https://www.w3.org/Icons/valid-xhtml11"
                 alt="Valid XHTML 1.1" height="31" width="88" />
        </a>
    </p>
</body>
</html>
