<?php
// Controlador del Ejercicio 2: genera o recupera el vector, busca el número y arma el segundo vector

require_once __DIR__ . '/Ejercicio02Model.php'; // incluye el archivo del modelo

$modelo = new Ejercicio02Model(); // crea un objeto del modelo para usar sus funciones

$error = '';        // mensaje de error que se mostrará en la vista
$numero = null;     // número que el usuario desea buscar (null = todavía no ha buscado)
$posiciones = [];   // posiciones donde se encontró el número

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vector'])) { // si el formulario trae el vector anterior
    $vector = $modelo->textoAVector($_POST['vector']); // reconstruye el vector para buscar sobre los mismos datos
} else { // si es la primera vez que se abre la página
    $vector = $modelo->generarVector(Ejercicio02Model::TAMANO, Ejercicio02Model::MINIMO, Ejercicio02Model::MAXIMO); // genera 20 números aleatorios
}

if (count($vector) !== Ejercicio02Model::TAMANO) { // valida que el vector tenga exactamente 20 elementos
    $vector = $modelo->generarVector(Ejercicio02Model::TAMANO, Ejercicio02Model::MINIMO, Ejercicio02Model::MAXIMO); // si no, genera uno nuevo
}

if (isset($_POST['numero'])) { // si el usuario envió un número para buscar
    if (!is_numeric($_POST['numero'])) { // valida que sea un número
        $error = 'Ingrese un número entero válido.'; // guarda el mensaje de error
    } else { // si el dato es válido
        $numero = (int) $_POST['numero']; // convierte el dato a entero
        $posiciones = $modelo->buscarPosiciones($vector, $numero); // literal a: busca las posiciones
    }
}

$vectorImpar = $modelo->elementosIndiceImpar($vector); // literal b: forma el segundo vector con los índices impares
$mayores = $modelo->contarMayoresA($vectorImpar, Ejercicio02Model::LIMITE); // literal c: cuenta los mayores a 20
$posicionesMayores = $modelo->posicionesMayoresA($vectorImpar, Ejercicio02Model::LIMITE); // posiciones a resaltar en la vista

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
