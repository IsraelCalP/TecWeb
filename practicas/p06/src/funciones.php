<?php 

function multiplo($num)
{
    return ($num % 5 == 0 && $num % 7 == 0);
}

function secuencia()
{
    $matriz = [];
    $iteracion = 0;
    $numgenerado = 0;

    while (true) {
        $fila = [
            rand(1, 999),
            rand(1, 999),
            rand(1, 999)
        ];

        $numgenerado += 3;
        $iteracion++;
        $matriz[] = $fila;

        
        if ($fila[0] % 2 != 0 && $fila[1] % 2 == 0 && $fila[2] % 2 != 0) {
            break;
        }
    }

    return [$matriz, $iteracion, $numgenerado];
}

function multiploAleatorioWhile($multiplo)
{
    $num = rand(1, 1000);
    while ($num % $multiplo != 0) {
        $num = rand(1, 1000);
    }
    return $num;
}


function multiploAleatorioDoWhile($multiplo)
{
    do {
        $num = rand(1, 1000);
    } while ($num % $multiplo != 0);
    return $num;
}

function arregloAcsii()
{
    $arreglo = [];
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }
    return $arreglo;
}

function sexoEdad($edad, $sexo)
{
    
    if (strtolower($sexo) == 'femenino' && $edad >= 18 && $edad <= 35) {
        return 'Bienvenida, usted está en el rango de edad permitido.';
    } else {
        return 'Lo sentimos, no cumple con los requisitos (sexo "femenino" y edad entre 18-35).';
    }
}