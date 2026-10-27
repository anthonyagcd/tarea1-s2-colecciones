<?php
// Controlador del Ejercicio 9: registra medicamentos, registra ventas y prepara el reporte del inventario

require_once __DIR__ . '/Ejercicio09Model.php'; // incluye el modelo (y el registro Medicamento)

session_start(); // inicia la sesión para conservar la lista entre una petición y otra

$modelo = new Ejercicio09Model(); // crea un objeto del modelo para usar sus funciones

$medicamentos = $_SESSION['medicamentos'] ?? []; // recupera la lista guardada o empieza con una lista vacía
$mensaje = $_SESSION['mensaje'] ?? '';           // recupera el mensaje de la acción anterior
unset($_SESSION['mensaje']);                     // borra el mensaje para que se muestre una sola vez
$error = '';                                     // mensaje de error que se mostrará en la vista
$formulario = ['nombre' => '', 'stockActual' => '', 'stockMinimo' => '', 'precio' => '']; // valores del formulario de registro

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // verifica si se envió algún formulario
    $accion = $_POST['accion'] ?? ''; // lee qué acción pidió el usuario

    if ($accion === 'registrar') { // literal a: registrar un medicamento
        $formulario = [ // guarda lo que escribió el usuario para no perderlo si hay error
            'nombre' => trim((string) ($_POST['nombre'] ?? '')),
            'stockActual' => (string) ($_POST['stockActual'] ?? ''),
            'stockMinimo' => (string) ($_POST['stockMinimo'] ?? ''),
            'precio' => (string) ($_POST['precio'] ?? ''),
        ];

        if ($formulario['nombre'] === '') { // valida el nombre
            $error = 'Ingrese el nombre del medicamento.'; // guarda el mensaje de error
        } elseif (!is_numeric($formulario['stockActual']) || !is_numeric($formulario['stockMinimo']) || !is_numeric($formulario['precio'])) { // valida que los datos sean números
            $error = 'El stock y el precio deben ser numéricos.'; // guarda el mensaje de error
        } elseif ((int) $formulario['stockActual'] < 0 || (int) $formulario['stockMinimo'] < 0 || (float) $formulario['precio'] <= 0) { // valida los rangos
            $error = 'El stock no puede ser negativo y el precio debe ser mayor a 0.'; // guarda el mensaje de error
        } elseif ($modelo->existeNombre($medicamentos, $formulario['nombre'])) { // valida que no esté repetido
            $error = 'Ya existe un medicamento con ese nombre.'; // guarda el mensaje de error
        } else { // si los datos son correctos
            $medicamentos[] = new Medicamento( // crea el registro y lo agrega a la lista
                $formulario['nombre'],
                (int) $formulario['stockActual'],
                (int) $formulario['stockMinimo'],
                (float) $formulario['precio']
            );
            $mensaje = 'Se registró "' . $formulario['nombre'] . '" en el inventario.'; // mensaje de confirmación
        }
    } elseif ($accion === 'vender') { // literal d: actualizar el stock después de una venta
        $indice = (int) ($_POST['indice'] ?? -1); // posición del medicamento en la lista
        $cantidad = (int) ($_POST['cantidad'] ?? 0); // cantidad vendida

        if (!isset($medicamentos[$indice])) { // valida que el medicamento exista
            $error = 'Seleccione un medicamento válido.'; // guarda el mensaje de error
        } elseif ($cantidad < 1) { // valida la cantidad
            $error = 'La cantidad vendida debe ser al menos 1.'; // guarda el mensaje de error
        } elseif (!$modelo->registrarVenta($medicamentos[$indice], $cantidad)) { // intenta registrar la venta
            $error = 'Stock insuficiente: solo hay ' . $medicamentos[$indice]->stockActual . ' unidades.'; // no alcanzó el stock
        } else { // si la venta se realizó
            $mensaje = "Venta registrada: $cantidad unidades de \"{$medicamentos[$indice]->nombre}\". Stock actual: {$medicamentos[$indice]->stockActual}."; // confirmación
        }
    } elseif ($accion === 'ejemplo') { // carga datos de ejemplo
        $medicamentos = $modelo->datosEjemplo(); // reemplaza la lista por los datos de ejemplo
        $mensaje = 'Se cargaron 5 medicamentos de ejemplo.'; // mensaje de confirmación
    } elseif ($accion === 'vaciar') { // vacía el inventario
        $medicamentos = []; // deja la lista vacía
        $mensaje = 'Se vació el inventario.'; // mensaje de confirmación
    }

    if ($error === '') { // si la acción terminó sin errores
        $_SESSION['medicamentos'] = $medicamentos; // guarda la lista actualizada en la sesión
        $_SESSION['mensaje'] = $mensaje; // guarda el mensaje para mostrarlo después de recargar
        header('Location: Ejercicio09Controller.php'); // recarga la página para evitar reenviar el formulario
        exit; // termina la ejecución
    }
}

$bajoMinimo = $modelo->bajoStockMinimo($medicamentos); // literal b: medicamentos con stock bajo
$valorTotal = $modelo->valorTotalInventario($medicamentos); // literal c: valor total del inventario

require __DIR__ . '/vista.php'; // literal e: muestra la vista con el reporte general
