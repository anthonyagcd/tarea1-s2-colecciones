<?php
// Menú principal de la Tarea 1 - Semana 2: datos informativos y enlaces a los 10 ejercicios

$numeroEjercicio = 0;                       // 0 indica que estamos en el menú principal
$tituloPagina = 'Inicio';                   // título que se muestra en la pestaña del navegador
require __DIR__ . '/comun/cabecera.php';    // incluye la cabecera común (barra superior y menú lateral)
?>
<div class="titulo-pagina">
    <span class="etiqueta">Tarea 1 · Semana 2 · Colecciones</span>
    <h1>Arreglos, matrices y registros en PHP</h1>
</div>

<!-- Datos informativos del trabajo -->
<section class="tarjeta">
    <h2>Datos informativos</h2>
    <dl class="datos">
        <dt>Autores</dt>    <dd>Estudiante 1 · Estudiante 2</dd>
        <dt>Carrera</dt>    <dd>Nombre de la carrera</dd>
        <dt>Asignatura</dt> <dd>Nombre de la asignatura</dd>
        <dt>Arquitectura</dt><dd>Modelo – Vista – Controlador (un paquete por ejercicio)</dd>
    </dl>
</section>

<!-- Tarjetas con el enlace a cada ejercicio -->
<section class="menu">
    <?php foreach ($listaEjercicios as $numero => $ejercicio): // recorre la lista de ejercicios ?>
        <a class="tarjeta-menu" href="<?= rutaEjercicio($numero) ?>">
            <span class="numero">EJERCICIO <?= sprintf('%02d', $numero) ?></span>
            <span class="titulo"><?= e($ejercicio['titulo']) ?></span>
            <span class="tema"><?= e($ejercicio['tema']) ?></span>
        </a>
    <?php endforeach; ?>
</section>

<?php require __DIR__ . '/comun/pie.php'; // incluye el pie común ?>
