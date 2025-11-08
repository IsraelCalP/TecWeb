<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>03-Constructor y Namespace</title>
</head>
<body>
    <?php
    use Ejemplos\PHP_POO\Cabecera2 AS Cabecera;
    require_once __DIR__.'/cabecera.php';

    $cab1 = new Cabecera('El rincón del programador', 'center', 'https://www.cs.buap.mx');
    $cab1->graficar();

    ?>
    
</body>
</html>