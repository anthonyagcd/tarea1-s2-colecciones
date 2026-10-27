<?php
// Controlador del Ejercicio 3: pide N, registra los empleados y busca uno por su código

require_once __DIR__ . '/Ejercicio03Model.php'; // incluye el archivo del modelo

$modelo = new Ejercicio03Model(); // crea un objeto del modelo para usar sus funciones

$paso = 1;              // paso actual: 1 = pedir N, 2 = pedir empleados, 3 = buscar por código
$n = 0;                 // cantidad de empleados
$empleados = [];        // arreglo de registros Empleado
$codigoBuscado = null;  // código que el usuario desea buscar (null = todavía no ha buscado)
$encontrado = null;     // empleado encontrado en la búsqueda
$error = '';            // mensaje de error que se mostrará en la vista

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si el formulario fue enviado
    $n = (int) ($_POST['n'] ?? 0); // lee N del formulario y lo convierte a entero

    if ($n < 1 || $n > 50) { // valida que N esté entre 1 y 50
        $error = 'N debe ser un número entre 1 y 50.'; // guarda el mensaje de error
    } elseif (isset($_POST['codigos'], $_POST['nombres'])) { // si ya llegaron los datos de los empleados
        $empleados = $modelo->crearEmpleados((array) $_POST['codigos'], (array) $_POST['nombres']); // forma el arreglo de registros
        $repetido = $modelo->codigoRepetido($empleados); // revisa si hay códigos repetidos

        if ($repetido !== null) { // si hay un código repetido
            $error = "El código \"$repetido\" está repetido. Cada empleado debe tener un código único."; // guarda el error
            $paso = 2; // vuelve a pedir los empleados
        } else { // si los datos son correctos
            $paso = 3; // pasa a la búsqueda
            if (isset($_POST['buscar'])) { // si el usuario envió un código para buscar
                $codigoBuscado = trim((string) $_POST['buscar']); // limpia el código buscado
                $encontrado = $modelo->buscarPorCodigo($empleados, $codigoBuscado); // busca el empleado
            }
        }
    } else { // si solo llegó N
        $paso = 2; // pasa a pedir los empleados
    }
}

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
