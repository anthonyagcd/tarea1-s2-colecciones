<?php
// Controlador del Ejercicio 8: obtiene los registros de los operarios y calcula su grado de eficiencia

require_once __DIR__ . '/Ejercicio08Model.php'; // incluye el archivo del modelo

$modelo = new Ejercicio08Model(); // crea un objeto del modelo para usar sus funciones

$paso = 1;              // paso actual: 1 = pedir N, 2 = ingresar registros, 3 = mostrar resultados
$n = 5;                 // número de operarios
$modo = 'aleatorio';    // forma de llenar los datos: 'aleatorio' o 'manual'
$operarios = [];        // arreglo de registros Operario
$error = '';            // mensaje de error que se mostrará en la vista

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si el formulario fue enviado
    $n = (int) ($_POST['n'] ?? 0); // lee N (operarios)
    $modo = ($_POST['modo'] ?? '') === 'manual' ? 'manual' : 'aleatorio'; // lee el modo de llenado

    if ($n < 1 || $n > 30) { // valida N
        $error = 'N debe estar entre 1 y 30.'; // guarda el mensaje de error
    } elseif (isset($_POST['codigos'])) { // si llegaron los registros ingresados a mano
        $operarios = $modelo->crearOperarios( // crea el arreglo de registros
            (array) $_POST['codigos'],
            (array) ($_POST['horas'] ?? []),
            (array) ($_POST['defectuosos'] ?? []),
            (array) ($_POST['producidos'] ?? [])
        );
        if ($modelo->datosInvalidos($operarios)) { // valida que no haya datos vacíos o negativos
            $error = 'Todos los datos son obligatorios y no pueden ser negativos.'; // guarda el mensaje de error
            $paso = 2; // vuelve a mostrar el formulario
        } else { // si los datos son correctos
            $paso = 3; // pasa a mostrar los resultados
        }
    } elseif ($modo === 'aleatorio') { // si eligió datos aleatorios
        $operarios = $modelo->generarOperarios($n); // genera los registros
        $paso = 3; // pasa a mostrar los resultados
    } else { // si eligió ingresar los datos a mano
        $paso = 2; // pasa a mostrar el formulario vacío
    }
}

if ($paso === 3) { // si hay registros para evaluar
    $modelo->calcularGrados($operarios); // calcula el grado de eficiencia de cada operario
}

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
