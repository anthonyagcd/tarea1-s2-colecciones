<?php
// Vista del Ejercicio 4: formulario de operación y matrices A, B y resultado
if (!isset($operaciones)) { header('Location: Ejercicio04Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 4;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 4';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 4 · Matrices</span>
    <h1>Operaciones con matrices M x N</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Implementar un programa que permita realizar operaciones sobre matrices de M x N y lleno con elementos enteros
        generados de manera aleatoria. Se debe permitir al usuario seleccionar alguna de las siguientes operaciones:
        Sumar, restar, multiplicar y trasponer matrices.</p>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<form method="post" class="tarjeta">
    <h2>Datos de la operación</h2>
    <div class="campos">
        <div class="campo">
            <label for="m">Filas (M)</label>
            <input type="number" id="m" name="m" min="1" max="8" required value="<?= $m ?>">
        </div>
        <div class="campo">
            <label for="n">Columnas (N)</label>
            <input type="number" id="n" name="n" min="1" max="8" required value="<?= $n ?>">
        </div>
        <div class="campo">
            <label for="operacion">Operación</label>
            <select id="operacion" name="operacion">
                <?php foreach ($operaciones as $clave => $nombre): // crea una opción por cada operación ?>
                    <option value="<?= $clave ?>" <?= $clave === $operacion ? 'selected' : '' ?>><?= $nombre ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button type="submit">Generar y calcular</button>
    <p class="texto-suave">Los elementos se generan al azar entre <?= Ejercicio04Model::MINIMO ?> y <?= Ejercicio04Model::MAXIMO ?>.
        Para multiplicar, B se genera de N x M para que el número de columnas de A coincida con las filas de B.</p>
</form>

<?php if ($calculado): // si ya se calculó, muestra las matrices ?>
    <div class="rejilla">
        <section class="tarjeta">
            <h2>Matriz A <small>(<?= count($a) ?> x <?= count($a[0]) ?>)</small></h2>
            <?php imprimirMatriz($a); // imprime la matriz A ?>
        </section>
        <?php if (count($b) > 0): // la matriz B solo existe en suma, resta y multiplicación ?>
            <section class="tarjeta">
                <h2>Matriz B <small>(<?= count($b) ?> x <?= count($b[0]) ?>)</small></h2>
                <?php imprimirMatriz($b); // imprime la matriz B ?>
            </section>
        <?php endif; ?>
    </div>

    <section class="tarjeta">
        <h2>Resultado: <?= $operaciones[$operacion] ?> <small>(<?= count($resultado) ?> x <?= count($resultado[0]) ?>)</small></h2>
        <?php imprimirMatriz($resultado); // imprime la matriz resultado ?>
    </section>
<?php endif; ?>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
