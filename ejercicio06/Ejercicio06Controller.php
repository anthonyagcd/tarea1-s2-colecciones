<?php
// Controlador del Ejercicio 6: obtiene la matriz de ventas y calcula los totales

require_once __DIR__ . '/Ejercicio06Model.php'; // incluye el archivo del modelo

$modelo = new Ejercicio06Model(); // crea un objeto del modelo para usar sus funciones

$paso = 1;              // paso actual: 1 = pedir N y M, 2 = ingresar ventas, 3 = mostrar resultados
$n = 4;                 // número de vendedores (filas)
$m = 3;                 // número de años (columnas)
$modo = 'aleatorio';    // forma de llenar la matriz: 'aleatorio' o 'manual'
$ventas = [];           // matriz de ventas N x M
$error = '';            // mensaje de error que se mostrará en la vista

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si el formulario fue enviado
    $n = (int) ($_POST['n'] ?? 0); // lee N (vendedores)
    $m = (int) ($_POST['m'] ?? 0); // lee M (años)
    $modo = ($_POST['modo'] ?? '') === 'manual' ? 'manual' : 'aleatorio'; // lee el modo de llenado

    if ($n < 1 || $n > 15 || $m < 1 || $m > 10) { // valida N y M
        $error = 'N debe estar entre 1 y 15, y M entre 1 y 10.'; // guarda el mensaje de error
    } elseif (isset($_POST['ventas'])) { // si llegó la matriz ingresada a mano
        $ventas = $modelo->leerMatriz((array) $_POST['ventas'], $n, $m); // convierte los datos a matriz
        $paso = 3; // pasa a mostrar los resultados
    } elseif ($modo === 'aleatorio') { // si eligió llenar la matriz al azar
        $ventas = $modelo->generarVentas($n, $m); // genera la matriz de ventas
        $paso = 3; // pasa a mostrar los resultados
    } else { // si eligió ingresar las ventas a mano
        $paso = 2; // pasa a mostrar la matriz vacía
    }
}

if ($paso === 3) { // si hay datos para calcular
    $totalVendedores = $modelo->totalPorVendedor($ventas); // literal a: total de cada vendedor
    $totalAnios = $modelo->totalPorAnio($ventas); // literal b: total de cada año
    $totalEmpresa = $modelo->totalEmpresa($ventas); // literal c: total de la empresa
}

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
