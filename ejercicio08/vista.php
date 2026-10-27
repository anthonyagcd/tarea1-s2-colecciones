<?php
// Vista del Ejercicio 8: registros de operarios con sus condiciones y grado de eficiencia
if (!isset($paso)) { header('Location: Ejercicio08Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 8;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 8';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 8 · Registros</span>
    <h1>Grado de eficiencia de operarios</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Se desea obtener el grado de eficiencia de N operarios de una fábrica productora de pupitres, de acuerdo con las
        siguientes condiciones: <strong>(1)</strong> ausencia del trabajo &lt;= 3 horas, <strong>(2)</strong> pupitres
        defectuosos &lt; 300, <strong>(3)</strong> pupitres producidos &gt; 10000.</p>
    <p>Por cada trabajador se tiene un registro con: código, horas de ausencia, pupitres defectuosos y pupitres
        producidos. Elaborar un programa que calcule para cada trabajador su grado de eficiencia e imprima toda su información.</p>
    <div class="espacio"></div>
    <div class="tabla-contenedor">
        <table>
            <thead><tr><th>Ninguna</th><th>Solo 1</th><th>Solo 2</th><th>Solo 3</th><th>1 y 2</th><th>1 y 3</th><th>2 y 3</th><th>Las tres</th></tr></thead>
            <tbody><tr><td>5</td><td>7</td><td>8</td><td>9</td><td>12</td><td>13</td><td>15</td><td>20</td></tr></tbody>
        </table>
    </div>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($paso === 1): // paso 1: pedir N y el modo de llenado ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">1</span> Cantidad de operarios</h2>
        <div class="campos">
            <div class="campo">
                <label for="n">Operarios (N)</label>
                <input type="number" id="n" name="n" min="1" max="30" required value="<?= $n ?>">
            </div>
            <div class="campo">
                <label for="modo">Llenado de los datos</label>
                <select id="modo" name="modo">
                    <option value="aleatorio" <?= $modo === 'aleatorio' ? 'selected' : '' ?>>Valores aleatorios</option>
                    <option value="manual" <?= $modo === 'manual' ? 'selected' : '' ?>>Ingresar manualmente</option>
                </select>
            </div>
        </div>
        <button type="submit">Continuar</button>
    </form>

<?php elseif ($paso === 2): // paso 2: ingresar el registro de cada operario ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">2</span> Registro de los <?= $n ?> operarios</h2>
        <input type="hidden" name="n" value="<?= $n ?>">
        <input type="hidden" name="modo" value="manual">
        <div class="tabla-contenedor">
            <table class="entrada">
                <thead><tr><th>#</th><th>Código</th><th>Horas de ausencia</th><th>Pupitres defectuosos</th><th>Pupitres producidos</th></tr></thead>
                <tbody>
                <?php for ($i = 0; $i < $n; $i++): // una fila por operario ?>
                    <tr>
                        <th><?= $i + 1 ?></th>
                        <td><input type="text" name="codigos[]" required maxlength="12" value="<?= e($operarios[$i]->codigo ?? sprintf('OP%03d', $i + 1)) ?>"></td>
                        <td><input type="number" name="horas[]" min="0" step="0.5" required value="<?= e($operarios[$i]->horasAusencia ?? '') ?>"></td>
                        <td><input type="number" name="defectuosos[]" min="0" required value="<?= e($operarios[$i]->defectuosos ?? '') ?>"></td>
                        <td><input type="number" name="producidos[]" min="0" required value="<?= e($operarios[$i]->producidos ?? '') ?>"></td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <div class="espacio"></div>
        <button type="submit">Calcular grados</button>
    </form>

<?php else: // paso 3: imprimir la información de cada operario con su grado ?>
    <section class="tarjeta">
        <h2>Grado de eficiencia por operario <small>(<?= count($operarios) ?> registros)</small></h2>
        <div class="tabla-contenedor">
            <table>
                <thead>
                <tr>
                    <th class="izq">Código</th>
                    <th>Horas ausencia</th>
                    <th>Defectuosos</th>
                    <th>Producidos</th>
                    <th>(1) Ausencia ≤ 3</th>
                    <th>(2) Defectuosos &lt; 300</th>
                    <th>(3) Producidos &gt; 10000</th>
                    <th class="total">Grado</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($operarios as $operario): // recorre cada registro ?>
                    <?php
                    $condiciones = [ // evalúa las tres condiciones del operario para mostrarlas
                        $modelo->cumpleAusencia($operario),
                        $modelo->cumpleDefectuosos($operario),
                        $modelo->cumpleProduccion($operario),
                    ];
                    ?>
                    <tr>
                        <th class="izq"><?= e($operario->codigo) ?></th>
                        <td><?= e($operario->horasAusencia) ?></td>
                        <td><?= number_format($operario->defectuosos) ?></td>
                        <td><?= number_format($operario->producidos) ?></td>
                        <?php foreach ($condiciones as $cumple): // imprime si cumple o no cada condición ?>
                            <td><span class="pill <?= $cumple ? 'si' : 'no' ?>"><?= $cumple ? 'Cumple' : 'No cumple' ?></span></td>
                        <?php endforeach; ?>
                        <td class="total"><span class="pill grado"><?= $operario->grado ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <a class="boton boton-secundario" href="Ejercicio08Controller.php">Nueva evaluación</a>
<?php endif; ?>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
