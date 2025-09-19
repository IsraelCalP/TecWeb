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

function inicializarParqueVehicular()
{
    $parque = array(
        'UBN6338' => array(
            'Auto' => array('marca' => 'HONDA', 'modelo' => 2020, 'tipo' => 'camioneta'),
            'Propietario' => array('nombre' => 'Alfonzo Esparza', 'ciudad' => 'Puebla, Pue.', 'direccion' => 'C.U., Jardines de San Manuel')
        ),
        'VAM1998' => array(
            'Auto' => array('marca' => 'MAZDA', 'modelo' => 2019, 'tipo' => 'sedan'),
            'Propietario' => array('nombre' => 'Ma. del Consuelo Molina', 'ciudad' => 'Puebla, Pue.', 'direccion' => '97 oriente')
        ),
        'TUA2024' => array(
            'Auto' => array('marca' => 'Nissan', 'modelo' => 2022, 'tipo' => 'sedan'),
            'Propietario' => array('nombre' => 'Juan Pérez', 'ciudad' => 'Cholula', 'direccion' => 'Av. Siempre Viva 123')
        ),
        'UAT2025' => array(
            'Auto' => array('marca' => 'Ford', 'modelo' => 2021, 'tipo' => 'hatchback'),
            'Propietario' => array('nombre' => 'Ana López', 'ciudad' => 'Atlixco', 'direccion' => 'Calle Falsa 456')
        ),
        'PBN1234' => array(
            'Auto' => array('marca' => 'Chevrolet', 'modelo' => 2023, 'tipo' => 'camioneta'),
            'Propietario' => array('nombre' => 'Carlos García', 'ciudad' => 'Puebla', 'direccion' => 'Blvd. de los Sueños 789')
        ),
        'LER5678' => array(
            'Auto' => array('marca' => 'Toyota', 'modelo' => 2020, 'tipo' => 'sedan'),
            'Propietario' => array('nombre' => 'Sofía Martínez', 'ciudad' => 'Tehuacán', 'direccion' => 'Privada del Sol 101')
        ),
        'JMR9012' => array(
            'Auto' => array('marca' => 'Volkswagen', 'modelo' => 2022, 'tipo' => 'hatchback'),
            'Propietario' => array('nombre' => 'Luis Hernández', 'ciudad' => 'Puebla', 'direccion' => 'Cerrada de la Luna 212')
        ),
        'KLP3456' => array(
            'Auto' => array('marca' => 'Kia', 'modelo' => 2024, 'tipo' => 'camioneta'),
            'Propietario' => array('nombre' => 'Laura Rodríguez', 'ciudad' => 'Cholula', 'direccion' => 'Camino Real 333')
        ),
        'NVC7890' => array(
            'Auto' => array('marca' => 'Hyundai', 'modelo' => 2021, 'tipo' => 'sedan'),
            'Propietario' => array('nombre' => 'David Gómez', 'ciudad' => 'Puebla', 'direccion' => 'Calle de la Alegría 444')
        ),
        'XYS1230' => array(
            'Auto' => array('marca' => 'Audi', 'modelo' => 2023, 'tipo' => 'sedan'),
            'Propietario' => array('nombre' => 'Valeria Torres', 'ciudad' => 'Atlixco', 'direccion' => 'Av. de los Cerezos 555')
        ),
        'ZTR4561' => array(
            'Auto' => array('marca' => 'BMW', 'modelo' => 2022, 'tipo' => 'camioneta'),
            'Propietario' => array('nombre' => 'José Sánchez', 'ciudad' => 'Puebla', 'direccion' => 'Paseo de las Flores 666')
        ),
        'FGH7892' => array(
            'Auto' => array('marca' => 'Mercedes-Benz', 'modelo' => 2024, 'tipo' => 'sedan'),
            'Propietario' => array('nombre' => 'Gabriela Morales', 'ciudad' => 'Cholula', 'direccion' => 'Calle del Encanto 777')
        ),
        'CDE0123' => array(
            'Auto' => array('marca' => 'Jeep', 'modelo' => 2023, 'tipo' => 'camioneta'),
            'Propietario' => array('nombre' => 'Fernando Ramírez', 'ciudad' => 'Puebla', 'direccion' => 'Rincón del Bosque 888')
        ),
        'BGT4567' => array(
            'Auto' => array('marca' => 'Suzuki', 'modelo' => 2020, 'tipo' => 'hatchback'),
            'Propietario' => array('nombre' => 'Patricia Castillo', 'ciudad' => 'Atlixco', 'direccion' => 'Av. de las Estrellas 999')
        ),
        'RST8901' => array(
            'Auto' => array('marca' => 'Subaru', 'modelo' => 2021, 'tipo' => 'sedan'),
            'Propietario' => array('nombre' => 'Miguel Flores', 'ciudad' => 'Puebla', 'direccion' => 'Plaza Mayor 222')
        )
    );
    return $parque;
}