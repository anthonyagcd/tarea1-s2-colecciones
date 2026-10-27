<?php
// Vista del Ejercicio 2: muestra el vector original, la búsqueda y el vector de índices impares
if (!isset($vector)) { header('Location: Ejercicio02Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 2;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 2';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 2 · Arreglos</span>
    <h1>Vector de 20 números aleatorios</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Se tiene un vector de 20 elementos con valores numéricos enteros (aleatorios). Se debe realizar:</p>
    <ol type="a">
        <li>Leer por teclado un número y buscar en qué posición del vector se encuentra.</li>
        <li>Crear un segundo vector con los elementos de las posiciones del índice impar del vector original e imprima el vector resultante.</li>
        <li>Busque en el segundo vector cuántos elementos son mayores a 20 y muestre el resultado.</li>
    </ol>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<section class="tarjeta">
    <h2>Vector original <small>(<?= count($vector) ?> elementos entre <?= Ejercicio02Model::MINIMO ?> y <?= Ejercicio02Model::MAXIMO ?>)</small></h2>
    <?php imprimirVector($vector, $posiciones); // imprime el vector y resalta las posiciones encontradas ?>
</section>

<section class="tarjeta">
    <h2><span class="paso">a</span> Buscar un número en el vector</h2>
    <form method="post">
        <input type="hidden" name="vector" value="<?= implode(',', $vector) ?>">
        <div class="campos">
            <div class="campo">
                <label for="numero">Número a buscar</label>
                <input type="number" id="numero" name="numero" required value="<?= e($numero) ?>" autofocus>
            </div>
        </div>
        <div class="acciones">
            <button type="submit">Buscar</button>
            <a class="boton boton-secundario" href="Ejercicio02Controller.php">Generar otro vector</a>
        </div>
    </form>

    <?php if ($numero !== null): // si ya se realizó una búsqueda, muestra el resultado ?>
        <?php if (count($posiciones) > 0): // si se encontró el número ?>
            <p class="mensaje exito arriba">
                El número <strong><?= $numero ?></strong> se encuentra en
                <?= count($posiciones) === 1 ? 'la posición' : 'las posiciones' ?>
                <strong><?= implode(', ', $posiciones) ?></strong>.
            </p>
        <?php else: // si no se encontró ?>
            <p class="mensaje aviso arriba">El número <strong><?= $numero ?></strong> no se encuentra en el vector.</p>
        <?php endif; ?>
    <?php endif; ?>
</section>

<section class="tarjeta">
    <h2><span class="paso">b</span> Segundo vector: elementos de índice impar <small>(posiciones 1, 3, 5 … 19)</small></h2>
    <?php imprimirVector($vectorImpar, $posicionesMayores); // imprime el segundo vector y resalta los mayores a 20 ?>
    <p class="texto-suave">Es un vector nuevo, por eso sus posiciones empiezan otra vez en [0]: su [0] es el [1] del original,
        su [1] es el [3], su [2] es el [5], y así sucesivamente. En verde, los elementos mayores a <?= Ejercicio02Model::LIMITE ?>.</p>
</section>

<section class="tarjeta">
    <h2><span class="paso">c</span> Elementos del segundo vector mayores a <?= Ejercicio02Model::LIMITE ?></h2>
    <div class="datos-resumen">
        <div class="dato principal"><span>Mayores a <?= Ejercicio02Model::LIMITE ?></span><strong><?= $mayores ?></strong></div>
        <div class="dato"><span>Total del segundo vector</span><strong><?= count($vectorImpar) ?></strong></div>
    </div>
</section>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
