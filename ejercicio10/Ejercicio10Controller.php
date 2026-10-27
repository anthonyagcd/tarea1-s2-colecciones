<?php
// Controlador del Ejercicio 10: registra pedidos y prepara los totales del restaurante

require_once __DIR__ . '/Ejercicio10Model.php'; // incluye el modelo (y el registro Pedido)

session_start(); // inicia la sesión para conservar la lista entre una petición y otra

$modelo = new Ejercicio10Model(); // crea un objeto del modelo para usar sus funciones

$pedidos = $_SESSION['pedidos'] ?? [];   // recupera la lista guardada o empieza con una lista vacía
$mensaje = $_SESSION['mensaje10'] ?? ''; // recupera el mensaje de la acción anterior
unset($_SESSION['mensaje10']);           // borra el mensaje para que se muestre una sola vez
$error = '';                             // mensaje de error que se mostrará en la vista
$formulario = ['cliente' => '', 'plato' => '', 'cantidad' => '', 'precio' => '']; // valores del formulario de registro

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si se envió algún formulario
    $accion = $_POST['accion'] ?? ''; // lee qué acción pidió el usuario

    if ($accion === 'registrar') { // literal a: registrar un pedido
        $formulario = [ // guarda lo que escribió el usuario para no perderlo si hay error
            'cliente' => trim((string) ($_POST['cliente'] ?? '')),
            'plato' => trim((string) ($_POST['plato'] ?? '')),
            'cantidad' => (string) ($_POST['cantidad'] ?? ''),
            'precio' => (string) ($_POST['precio'] ?? ''),
        ];

        if ($formulario['cliente'] === '' || $formulario['plato'] === '') { // valida cliente y plato
            $error = 'Ingrese el nombre del cliente y el plato.'; // guarda el mensaje de error
        } elseif (!is_numeric($formulario['cantidad']) || !is_numeric($formulario['precio'])) { // valida que sean números
            $error = 'La cantidad y el precio deben ser numéricos.'; // guarda el mensaje de error
        } elseif ((int) $formulario['cantidad'] < 1 || (float) $formulario['precio'] <= 0) { // valida los rangos
            $error = 'La cantidad debe ser al menos 1 y el precio mayor a 0.'; // guarda el mensaje de error
        } else { // si los datos son correctos
            $pedidos[] = new Pedido( // crea el registro y lo agrega a la lista
                $formulario['cliente'],
                $formulario['plato'],
                (int) $formulario['cantidad'],
                (float) $formulario['precio']
            );
            $mensaje = 'Se registró el pedido de ' . $formulario['cliente'] . '.'; // mensaje de confirmación
        }
    } elseif ($accion === 'ejemplo') { // carga datos de ejemplo
        $pedidos = $modelo->datosEjemplo(); // reemplaza la lista por los datos de ejemplo
        $mensaje = 'Se cargaron 5 pedidos de ejemplo.'; // mensaje de confirmación
    } elseif ($accion === 'vaciar') { // vacía la lista de pedidos
        $pedidos = []; // deja la lista vacía
        $mensaje = 'Se eliminaron todos los pedidos.'; // mensaje de confirmación
    }

    if ($error === '') { // si la acción terminó sin errores
        $_SESSION['pedidos'] = $pedidos; // guarda la lista actualizada en la sesión
        $_SESSION['mensaje10'] = $mensaje; // guarda el mensaje para mostrarlo después de recargar
        header('Location: Ejercicio10Controller.php'); // recarga la página para evitar reenviar el formulario
        exit; // termina la ejecución
    }
}

$ingresoTotal = $modelo->ingresoTotal($pedidos); // literal d: ingreso total del restaurante
$mayor = $modelo->indicePedidoMayor($pedidos); // literal e: posición del pedido de mayor valor

require __DIR__ . '/vista.php'; // muestra la vista con los datos preparados
