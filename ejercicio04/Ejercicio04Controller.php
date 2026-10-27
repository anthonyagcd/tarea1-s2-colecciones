<?php
// Controlador del Ejercicio 4: lee M, N y la operación, genera las matrices y llama al modelo

require_once __DIR__ . '/Ejercicio04Model.php'; // incluye el archivo del modelo

$modelo = new Ejercicio04Model(); // crea un objeto del modelo para usar sus funciones

$operaciones = [ // operaciones disponibles: clave => nombre que se muestra
    'sumar' => 'Sumar (A + B)',
    'restar' => 'Restar (A − B)',
    'multiplicar' => 'Multiplicar (A × B)',
    'trasponer' => 'Trasponer (Aᵀ)',
];

$m = 3;                 // filas de la matriz A (valor por defecto)
$n = 3;                 // columnas de la matriz A (valor por defecto)
$operacion = 'sumar';   // operación seleccionada (valor por defecto)
$a = [];                // matriz A
$b = [];                // matriz B (no se usa al trasponer)
$resultado = [];        // matriz resultado
$calculado = false;     // indica si ya se realizó una operación
$error = '';            // mensaje de error que se mostrará en la vista

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si el formulario fue enviado
    $m = (int) ($_POST['m'] ?? 0); // lee M y lo convierte a entero
    $n = (int) ($_POST['n'] ?? 0); // lee N y lo convierte a entero
    $operacion = (string) ($_POST['operacion'] ?? ''); // lee la operación seleccionada

    if ($m < 1 || $m > 8 || $n < 1 || $n > 8) { // valida el tamaño de la matriz
        $error = 'M y N deben estar entre 1 y 8.'; // guarda el mensaje de error
    } elseif (!array_key_exists($operacion, $operaciones)) { // valida que la operación exista
        $error = 'Seleccione una operación válida.'; // guarda el mensaje de error
    } else { // si los datos son correctos
        $a = $modelo->generarMatriz($m, $n, Ejercicio04Model::MINIMO, Ejercicio04Model::MAXIMO); // genera la matriz A de M x N

        switch ($operacion) { // ejecuta la operación seleccionada
            case 'sumar': // suma
                $b = $modelo->generarMatriz($m, $n, Ejercicio04Model::MINIMO, Ejercicio04Model::MAXIMO); // B del mismo tamaño que A
                $resultado = $modelo->sumar($a, $b); // calcula A + B
                break; // termina el caso
            case 'restar': // resta
                $b = $modelo->generarMatriz($m, $n, Ejercicio04Model::MINIMO, Ejercicio04Model::MAXIMO); // B del mismo tamaño que A
                $resultado = $modelo->restar($a, $b); // calcula A - B
                break; // termina el caso
            case 'multiplicar': // multiplicación
                $b = $modelo->generarMatriz($n, $m, Ejercicio04Model::MINIMO, Ejercicio04Model::MAXIMO); // B de N x M para que el producto sea posible
                $resultado = $modelo->multiplicar($a, $b); // calcula A x B
                break; // termina el caso
            case 'trasponer': // traspuesta
                $resultado = $modelo->trasponer($a); // calcula la traspuesta de A
                break; // termina el caso
        }
        $calculado = true; // marca que la operación se realizó
    }
}

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
