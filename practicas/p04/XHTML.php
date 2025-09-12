
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4 Variables php</title>
</head>
<body>
    <h2>Manejo de variables en php</h2>
    <h2>Inciso 1. Variables validas</h2>$_myvar: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php<br>$_7var: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php<br>myvar: no es valida, porque no comienza con el signo de $, no sigue la nomenclatura de php<br>$myvar: es valida, porque comienza el signo $, sigue la nomenclatura de php<br>$var7: es valida, porque comienza con el signo $, sigue la nomenclatura de php<br>$_element1: es valida, porque comienza con un guion bajo, sigue la nomenclatura de php<br>$house*5: no es valida, porque tiene un signo *, no sigue la nomenclatura de php    <h2>Inciso 2. Proporcionar valores</h2><h3>a)</h3>Variable $a: ManejadorSQL <br>Variable $b: MySQL <br>Variable $c: ManejadorSQL <br><h3>b) y c)</h3>Variable $a: PHP server <br>Variable $b: PHP server <br>Variable $c: PHP server <br><h3>d)</h3>La variable $a cambia su valor a 'PHP server' y como las variables $b y $c son referencias de $a, toman el mismo valor.    <h2>Inciso 3. Mostrar contenido de variables después de la asignación.</h2>Variable $a: PHP5 <br>Arreglo $z después de agregar $a:<br><pre>Array
(
    [0] => PHP5
)
</pre>Variable $b: 5a version de PHP <br>Variable $c: 50 <br>Variable $a después de concatenar $b: 5050 <br>Variable $b después de multiplicar por $c: 25502500 <br>Arreglo $z después de cambiar $z[0]:<br><pre>Array
(
    [0] => MySQL
)
</pre>     <h2>Inciso 4. Mostrar contenido de variables después de la asignación con $GLOBALS</h2>Variable $a: PHP5<br>Arreglo $z:<br><pre>Array
(
    [0] => PHP5
)
</pre>Variable $b: 5a version de PHP<br>Variable $c: 50<br>Variable $a después de concatenar $b: PHP55a version de PHP<br>Variable $b después de multiplicar por $c: 250<br>Arreglo $z después de cambiar $z[0]:<br><pre>Array
(
    [0] => MySQL
)
</pre> 
     <h2>Inciso 5. Dar valor a variables $a, $b, $c</h2>Variable $a: 9e3 <br>Variable $b: 7 <br>Variable $c: 9000 <br><h2>Inciso 6. Compronar valor booleano variables</h2>Variable $a: string(1) "0"
<br>Variable $b: string(4) "TRUE"
<br>Variable $c: bool(false)
<br>Variable $d: bool(true)
<br>Variable $e: bool(false)
<br>Variable $f: bool(true)

    <h2>Transformación de valor booleano de la variable 0 y 0</h2>Variable $c: 0<br>Variable $e: 0    <h2>Inciso 7: Uso de variable $_SERVER</h2>Versión de apache: Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12<br>Versión de php: 8.2.12
    Nombre del sistema operativo: WINNT    Idioma de navegador: es-419,es;q=0.9,es-ES;q=0.8,en;q=0.7,en-GB;q=0.6,en-US;q=0.5,es-MX;q=0.4
</body>
</html>