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

