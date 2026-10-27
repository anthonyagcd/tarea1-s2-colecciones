<?php
// Cabecera común: abre el HTML, dibuja la barra superior y el menú lateral
// Antes de incluirla, cada vista define $numeroEjercicio (0 = menú principal) y $tituloPagina

require_once __DIR__ . '/funciones.php'; // incluye las funciones de apoyo para las vistas
$listaEjercicios = require __DIR__ . '/ejercicios.php'; // carga la lista de ejercicios para el menú lateral
$raiz = $numeroEjercicio === 0 ? '' : '../'; // ruta hacia la raíz del proyecto según la página actual
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($tituloPagina) ?> · Tarea 1 S2</title>
    <link rel="stylesheet" href="<?= $raiz ?>css/estilos.css">
</head>
<body>
<header class="barra">
    <a class="marca" href="<?= $raiz ?>index.php">

    
    </a>
    <span class="barra-info">PHP · Patrón MVC</span>
</header>

<div class="app">
    <nav class="lateral">
        <a href="<?= $raiz ?>index.php" class="<?= $numeroEjercicio === 0 ? 'activo' : '' ?>">
            <span class="num">··</span><span>Inicio</span>
        </a>
        <p class="lateral-titulo">Ejercicios</p>
        <?php foreach ($listaEjercicios as $numeroMenu => $ejercicioMenu): // recorre la lista para crear un enlace por ejercicio (nombres propios para no pisar variables de la vista) ?>
            <a href="<?= $raiz . rutaEjercicio($numeroMenu) ?>" class="<?= $numeroMenu === $numeroEjercicio ? 'activo' : '' ?>">
                <span class="num"><?= sprintf('%02d', $numeroMenu) ?></span>
                <span><?= e($ejercicioMenu['titulo']) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <main class="contenido">
