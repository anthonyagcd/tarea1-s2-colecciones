<?php
// Controlador del Ejercicio 5: obtiene las tablas de precios y cantidades y calcula los totales

require_once __DIR__ . '/Ejercicio05Model.php'; // incluye el archivo del modelo

$modelo = new Ejercicio05Model(); // crea un objeto del modelo para usar sus funciones

$paso = 1;              // paso actual: 1 = pedir N y M, 2 = ingresar tablas, 3 = mostrar resultados
$n = 3;                 // número de artículos (filas)
$m = 3;                 // número de sucursales (columnas)
$modo = 'aleatorio';    // forma de llenar las tablas: 'aleatorio' o 'manual'
$precios = [];          // tabla 1: precio de cada artículo en cada sucursal
$cantidades = [];       // tabla 2: cantidad vendida de cada artículo en cada sucursal
$error = '';            // mensaje de error que se mostrará en la vista

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si el formulario fue enviado
    $n = (int) ($_POST['n'] ?? 0); // lee N (artículos)
    $m = (int) ($_POST['m'] ?? 0); // lee M (sucursales)
    $modo = ($_POST['modo'] ?? '') === 'manual' ? 'manual' : 'aleatorio'; // lee el modo de llenado

    if ($n < 1 || $n > 10 || $m < 1 || $m > 10) { // valida N y M
        $error = 'N y M deben estar entre 1 y 10.'; // guarda el mensaje de error
    } elseif (isset($_POST['precios'], $_POST['cantidades'])) { // si llegaron las tablas ingresadas a mano
        $precios = $modelo->leerMatriz((array) $_POST['precios'], $n, $m, false); // convierte la tabla de precios
        $cantidades = $modelo->leerMatriz((array) $_POST['cantidades'], $n, $m, true); // convierte la tabla de cantidades
        if ($modelo->tieneNegativos($precios) || $modelo->tieneNegativos($cantidades)) { // valida que no haya negativos
            $error = 'Los precios y las cantidades no pueden ser negativos.'; // guarda el mensaje de error
            $paso = 2; // vuelve a mostrar las tablas
        } else { // si los datos son correctos
            $paso = 3; // pasa a mostrar los resultados
        }
    } elseif ($modo === 'aleatorio') { // si eligió llenar las tablas al azar
        $precios = $modelo->generarPrecios($n, $m); // genera la tabla de precios
        $cantidades = $modelo->generarCantidades($n, $m); // genera la tabla de cantidades
        $paso = 3; // pasa a mostrar los resultados
    } else { // si eligió ingresar las tablas a mano
        $paso = 2; // pasa a mostrar las tablas vacías
    }
}

if ($paso === 3) { // si hay datos para calcular
    $ventas = $modelo->calcularVentas($precios, $cantidades); // tabla de ventas: precio x cantidad
    $totalArticulos = $modelo->totalPorArticulo($ventas); // total de ventas por cada artículo
    $totalSucursales = $modelo->totalPorSucursal($ventas); // total de ventas por cada sucursal
    $totalGeneral = array_sum($totalArticulos); // total vendido por la fábrica
}

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
