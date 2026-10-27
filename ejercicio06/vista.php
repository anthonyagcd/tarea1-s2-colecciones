<?php
// Vista del Ejercicio 6: matriz de ventas por vendedor y año con sus totales
if (!isset($paso)) { header('Location: Ejercicio06Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 6;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 6';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 6 · Matrices</span>
    <h1>Ventas de vendedores por año</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Elaborar un programa que consolide una matriz de N x M elementos. Cada elemento de la matriz representa las ventas
        atribuibles a cada uno de los N vendedores de una empresa, para cada uno de los M años de operaciones que ha
        tenido la misma. Se debe calcular:</p>
    <ol type="a">
        <li>El total de ventas de cada vendedor de los M años.</li>
        <li>El total de ventas en cada año.</li>
        <li>El total de ventas de la empresa.</li>
    </ol>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($paso === 1): // paso 1: pedir N, M y el modo de llenado ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">1</span> Tamaño de la matriz</h2>
        <div class="campos">
            <div class="campo">
                <label for="n">Vendedores (N)</label>
                <input type="number" id="n" name="n" min="1" max="15" required value="<?= $n ?>">
            </div>
            <div class="campo">
                <label for="m">Años de operación (M)</label>
                <input type="number" id="m" name="m" min="1" max="10" required value="<?= $m ?>">
            </div>
            <div class="campo">
                <label for="modo">Llenado de la matriz</label>
                <select id="modo" name="modo">
                    <option value="aleatorio" <?= $modo === 'aleatorio' ? 'selected' : '' ?>>Valores aleatorios</option>
                    <option value="manual" <?= $modo === 'manual' ? 'selected' : '' ?>>Ingresar manualmente</option>
                </select>
            </div>
        </div>
        <button type="submit">Continuar</button>
    </form>

<?php elseif ($paso === 2): // paso 2: ingresar las ventas a mano ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">2</span> Ventas de cada vendedor por año</h2>
        <input type="hidden" name="n" value="<?= $n ?>">
        <input type="hidden" name="m" value="<?= $m ?>">
        <input type="hidden" name="modo" value="manual">
        <div class="tabla-contenedor">
            <table class="entrada">
                <thead>
                <tr>
                    <th></th>
                    <?php for ($j = 0; $j < $m; $j++): // encabezado de cada año ?>
                        <th>Año <?= $j + 1 ?></th>
                    <?php endfor; ?>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i < $n; $i++): // una fila por vendedor ?>
                    <tr>
                        <th>Vendedor <?= $i + 1 ?></th>
                        <?php for ($j = 0; $j < $m; $j++): // una casilla por año ?>
                            <td><input type="number" name="ventas[<?= $i ?>][<?= $j ?>]" min="0" step="0.01" required></td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <div class="espacio"></div>
        <button type="submit">Calcular totales</button>
    </form>

<?php else: // paso 3: mostrar la matriz consolidada ?>
    <section class="tarjeta">
        <h2>Matriz de ventas consolidada <small>(<?= $n ?> vendedores x <?= $m ?> años)</small></h2>
        <div class="tabla-contenedor">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <?php for ($j = 0; $j < $m; $j++): // encabezado de cada año ?>
                        <th>Año <?= $j + 1 ?></th>
                    <?php endfor; ?>
                    <th class="total">a) Total vendedor</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ventas as $i => $fila): // recorre cada vendedor ?>
                    <tr>
                        <th>Vendedor <?= $i + 1 ?></th>
                        <?php foreach ($fila as $venta): // imprime la venta de cada año ?>
                            <td class="der"><?= dinero($venta) ?></td>
                        <?php endforeach; ?>
                        <td class="der total"><?= dinero($totalVendedores[$i]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>b) Total año</th>
                    <?php foreach ($totalAnios as $total): // imprime el total de cada año ?>
                        <td class="der"><?= dinero($total) ?></td>
                    <?php endforeach; ?>
                    <td class="der"><?= dinero($totalEmpresa) ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <section class="tarjeta">
        <h2><span class="paso">c</span> Total de ventas de la empresa</h2>
        <div class="datos-resumen">
            <div class="dato principal"><span>Total empresa</span><strong><?= dinero($totalEmpresa) ?></strong></div>
            <div class="dato"><span>Vendedores</span><strong><?= $n ?></strong></div>
            <div class="dato"><span>Años</span><strong><?= $m ?></strong></div>
        </div>
    </section>

    <a class="boton boton-secundario" href="Ejercicio06Controller.php">Nuevo cálculo</a>
<?php endif; ?>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
