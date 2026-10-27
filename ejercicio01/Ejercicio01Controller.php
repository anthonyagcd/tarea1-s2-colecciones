<?php
// Controlador del Ejercicio 1: recibe los datos del formulario, usa el modelo y muestra la vista

require_once __DIR__ . '/Ejercicio01Model.php'; // incluye el archivo del modelo

$modelo = new Ejercicio01Model(); // crea un objeto del modelo para usar sus funciones

$paso = 1;        // paso actual: 1 = pedir N, 2 = pedir cédulas, 3 = mostrar resultados
$n = 0;           // cantidad de estudiantes de cada arreglo
$matematica = []; // arreglo 1: cédulas que reprobaron Matemática
$ingles = [];     // arreglo 2: cédulas que reprobaron Inglés
$ambas = [];      // arreglo 3: cédulas que reprobaron las dos materias
$error = '';      // mensaje de error que se mostrará en la vista

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si el formulario fue enviado
    $n = (int) ($_POST['n'] ?? 0); // lee N del formulario y lo convierte a entero

    if ($n < 1 || $n > 50) { // valida que N esté entre 1 y 50
        $error = 'N debe ser un número entre 1 y 50.'; // guarda el mensaje de error
    } elseif (isset($_POST['matematica'], $_POST['ingles'])) { // si ya llegaron las cédulas de las dos materias
        $matematica = $modelo->limpiarCedulas((array) $_POST['matematica']); // forma el arreglo de Matemática
        $ingles = $modelo->limpiarCedulas((array) $_POST['ingles']); // forma el arreglo de Inglés
        $ambas = $modelo->reprobaronAmbas($matematica, $ingles); // forma el tercer arreglo
        $paso = 3; // pasa a mostrar los resultados
    } else { // si solo llegó N
        $paso = 2; // pasa a pedir las cédulas
    }
}

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
