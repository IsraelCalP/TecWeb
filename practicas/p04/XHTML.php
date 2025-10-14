<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4 Variables php</title>
</head>
<body>
    <h2>Manejo de variables en php</h2>
    
    <h3>Inciso 1. Variables validas</h3>
    <p>
        $_myvar: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php<br />
        $_7var: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php<br />
        myvar: no es valida, porque no comienza con el signo de $, no sigue la nomenclatura de php<br />
        $myvar: es valida, porque comienza el signo $, sigue la nomenclatura de php<br />
        $var7: es valida, porque comienza con el signo $, sigue la nomenclatura de php<br />
        $_element1: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php<br />
        $house*5: no es valida, porque tiene un signo *, no sigue la nomenclatura de php
    </p>
    
    <h3>Inciso 2. Proporcionar valores</h3>
    <h4>a)</h4>
    <p>
        Variable $a: ManejadorSQL <br />
        Variable $b: MySQL <br />
        Variable $c: ManejadorSQL
    </p>
    
    <h4>b) y c)</h4>
    <p>
        Variable $a: PHP server <br />
        Variable $b: PHP server <br />
        Variable $c: PHP server
    </p>

    <h4>d)</h4>
    <p>La variable $a cambia su valor a 'PHP server' y como las variables $b y $c son referencias de $a, toman el mismo valor.</p>
    
    <h3>Inciso 3. Mostrar contenido de variables después de la asignación.</h3>
    <p>Variable $a: PHP5</p>
    <p>Arreglo $z después de agregar $a:</p>
    <pre>
Array
(
    [0] => PHP5
)
    </pre>
    <p>
        Variable $b: 5a version de PHP <br />
        Variable $c: 50 <br />
        Variable $a después de concatenar $b: 5050 <br />
        Variable $b después de multiplicar por $c: 25502500
    </p>
    <p>Arreglo $z después de cambiar $z[0]:</p>
    <pre>
Array
(
    [0] => MySQL
)
    </pre>
    
    <h3>Inciso 4. Mostrar contenido de variables después de la asignación con $GLOBALS</h3>
    <p>
        Variable $a: PHP5<br />
        Arreglo $z:
    </p>
    <pre>
Array
(
    [0] => PHP5
)
    </pre>
    <p>
        Variable $b: 5a version de PHP<br />
        Variable $c: 50<br />
        Variable $a después de concatenar $b: PHP55a version de PHP<br />
        Variable $b después de multiplicar por $c: 250
    </p>
    <p>Arreglo $z después de cambiar $z[0]:</p>
    <pre>
Array
(
    [0] => MySQL
)
    </pre>

    <h3>Inciso 5. Dar valor a variables $a, $b, $c</h3>
    <p>
        Variable $a: 9e3 <br />
        Variable $b: 7 <br />
        Variable $c: 9000
    </p>

    <h3>Inciso 6. Comprobar valor booleano variables</h3>
    <p>
        Variable $a: string(1) "0"<br />
        Variable $b: string(4) "TRUE"<br />
        Variable $c: bool(false)<br />
        Variable $d: bool(true)<br />
        Variable $e: bool(false)<br />
        Variable $f: bool(true)
    </p>
    <h4>Transformación de valor booleano de la variable 0 y 0</h4>
    <p>
        Variable $c: 0<br />
        Variable $e: 0
    </p>

    <h3>Inciso 7: Uso de variable $_SERVER</h3>
    <p>
        Versión de apache: Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12<br />
        Versión de php: 8.2.12<br />
        Nombre del sistema operativo: WINNT<br />
        Idioma de navegador: es-419,es;q=0.9,es-ES;q=0.8,en;q=0.7,en-GB;q=0.6,en-US;q=0.5,es-MX;q=0.4
    </p>
  <p>
    <a href="https://validator.w3.org/check?uri=referer"><img
      src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
  </p>
</body>
</html>
