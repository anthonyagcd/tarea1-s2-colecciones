<?php
// Controlador del Ejercicio 7: obtiene los códigos y notas de los estudiantes y calcula los resultados

require_once __DIR__ . '/Ejercicio07Model.php'; // incluye el archivo del modelo

$modelo = new Ejercicio07Model(); // crea un objeto del modelo para usar sus funciones

$paso = 1;              // paso actual: 1 = pedir N, 2 = ingresar notas, 3 = mostrar resultados
$n = 5;                 // número de estudiantes
$modo = 'aleatorio';    // forma de llenar las notas: 'aleatorio' o 'manual'
$codigos = [];          // arreglo con el código de cada estudiante
$notas = [];            // matriz de notas: N estudiantes x 8 materias
$error = '';            // mensaje de error que se mostrará en la vista

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si el formulario fue enviado
    $n = (int) ($_POST['n'] ?? 0); // lee N (estudiantes)
    $modo = ($_POST['modo'] ?? '') === 'manual' ? 'manual' : 'aleatorio'; // lee el modo de llenado

    if ($n < 1 || $n > 30) { // valida N
        $error = 'N debe estar entre 1 y 30.'; // guarda el mensaje de error
    } elseif (isset($_POST['codigos'], $_POST['notas'])) { // si llegaron los datos ingresados a mano
        $codigos = array_map('trim', (array) $_POST['codigos']); // limpia los códigos
        $notas = $modelo->leerNotas((array) $_POST['notas'], $n); // convierte las notas a matriz
        if (!$modelo->notasValidas($notas)) { // valida que las notas estén entre 0 y 10
            $error = 'Las notas deben estar entre 0 y 10.'; // guarda el mensaje de error
            $paso = 2; // vuelve a mostrar el formulario
        } else { // si los datos son correctos
            $paso = 3; // pasa a mostrar los resultados
        }
    } elseif ($modo === 'aleatorio') { // si eligió llenar las notas al azar
        $codigos = $modelo->generarCodigos($n); // genera los códigos de los estudiantes
        $notas = $modelo->generarNotas($n); // genera la matriz de notas
        $paso = 3; // pasa a mostrar los resultados
    } else { // si eligió ingresar las notas a mano
        $paso = 2; // pasa a mostrar el formulario vacío
    }
}

if ($paso === 3) { // si hay datos para calcular
    $promediosEstudiante = $modelo->promedioPorEstudiante($notas); // literal a
    $promediosMateria = $modelo->promedioPorMateria($notas); // literal b
    $mejor = $modelo->estudianteMayorPromedio($promediosEstudiante); // literal c: posición del mejor estudiante
    $aprobados = $modelo->aprobadosPorMateria($notas); // literal d
    $reprobados = $modelo->reprobadosPorMateria($notas); // literal e
}

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
