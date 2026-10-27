<?php
// Vista del Ejercicio 5: tablas de precios, cantidades y ventas con sus totales
if (!isset($paso)) { header('Location: Ejercicio05Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 5;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 5';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 5 · Matrices</span>
    <h1>Ventas por artículo y por sucursal</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Una fábrica produce N artículos diferentes y los distribuye a través de M sucursales. El precio de venta de cada
        artículo puede variar dependiendo de la sucursal donde se comercializa. Para ello, la fábrica dispone de una tabla
        donde se registra el precio de cada artículo en cada sucursal.</p>
    <p>Al finalizar cada periodo, cada sucursal reporta a la fábrica la cantidad vendida de cada artículo, generándose así
        una segunda tabla con esta información. Se solicita elaborar un programa que permita calcular:</p>
    <ul>
        <li>El total de ventas por cada artículo.</li>
        <li>El total de ventas por cada sucursal.</li>
    </ul>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($paso === 1): // paso 1: pedir N, M y el modo de llenado ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">1</span> Tamaño de las tablas</h2>
        <div class="campos">
            <div class="campo">
                <label for="n">Artículos (N)</label>
                <input type="number" id="n" name="n" min="1" max="10" required value="<?= $n ?>">
            </div>
            <div class="campo">
                <label for="m">Sucursales (M)</label>
                <input type="number" id="m" name="m" min="1" max="10" required value="<?= $m ?>">
            </div>
            <div class="campo">
                <label for="modo">Llenado de las tablas</label>
                <select id="modo" name="modo">
                    <option value="aleatorio" <?= $modo === 'aleatorio' ? 'selected' : '' ?>>Valores aleatorios</option>
                    <option value="manual" <?= $modo === 'manual' ? 'selected' : '' ?>>Ingresar manualmente</option>
                </select>
            </div>
        </div>
        <button type="submit">Continuar</button>
    </form>

<?php elseif ($paso === 2): // paso 2: ingresar las dos tablas a mano ?>
    <form method="post">
        <input type="hidden" name="n" value="<?= $n ?>">
        <input type="hidden" name="m" value="<?= $m ?>">
        <input type="hidden" name="modo" value="manual">
        <?php
        $tablas = [ // define las dos tablas que se deben ingresar
            'precios' => [
                'titulo' => 'Tabla 1 · Precio de cada artículo por sucursal',
                'ayuda' => 'Escriba cuánto cuesta cada artículo en cada sucursal (en dólares).',
                'marcador' => 'Precio $',
                'paso' => '0.01',
                'datos' => $precios,
            ],
            'cantidades' => [
                'titulo' => 'Tabla 2 · Cantidad vendida de cada artículo por sucursal',
                'ayuda' => 'Escriba cuántas unidades de cada artículo vendió cada sucursal.',
                'marcador' => 'Unidades',
                'paso' => '1',
                'datos' => $cantidades,
            ],
        ];
        ?>
        <?php foreach ($tablas as $nombre => $tabla): // recorre las dos tablas ?>
            <section class="tarjeta">
                <h2><span class="paso">2</span> <?= $tabla['titulo'] ?></h2>
                <p class="texto-suave"><?= $tabla['ayuda'] ?></p>
                <div class="tabla-contenedor">
                    <table class="entrada">
                        <thead>
                        <tr>
                            <th></th>
                            <?php for ($j = 0; $j < $m; $j++): // encabezado de cada sucursal ?>
                                <th>Sucursal <?= $j + 1 ?></th>
                            <?php endfor; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i = 0; $i < $n; $i++): // una fila por artículo ?>
                            <tr>
                                <th>Artículo <?= $i + 1 ?></th>
                                <?php for ($j = 0; $j < $m; $j++): // una casilla por sucursal ?>
                                    <td><input type="number" name="<?= $nombre ?>[<?= $i ?>][<?= $j ?>]" min="0"
                                               step="<?= $tabla['paso'] ?>" required placeholder="<?= $tabla['marcador'] ?>"
                                               value="<?= e($tabla['datos'][$i][$j] ?? '') ?>"></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php endforeach; ?>
        <button type="submit">Calcular totales</button>
    </form>

<?php else: // paso 3: mostrar las tablas y los totales ?>
    <div class="rejilla">
        <section class="tarjeta">
            <h2>Tabla 1 · Precios</h2>
            <div class="tabla-contenedor">
                <table>
                    <thead><tr><th></th><?php for ($j = 0; $j < $m; $j++): ?><th>Suc. <?= $j + 1 ?></th><?php endfor; ?></tr></thead>
                    <tbody>
                    <?php foreach ($precios as $i => $fila): // recorre cada artículo ?>
                        <tr><th>Art. <?= $i + 1 ?></th><?php foreach ($fila as $precio): ?><td class="der"><?= dinero($precio) ?></td><?php endforeach; ?></tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="tarjeta">
            <h2>Tabla 2 · Cantidades vendidas</h2>
            <div class="tabla-contenedor">
                <table>
                    <thead><tr><th></th><?php for ($j = 0; $j < $m; $j++): ?><th>Suc. <?= $j + 1 ?></th><?php endfor; ?></tr></thead>
                    <tbody>
                    <?php foreach ($cantidades as $i => $fila): // recorre cada artículo ?>
                        <tr><th>Art. <?= $i + 1 ?></th><?php foreach ($fila as $cantidad): ?><td><?= $cantidad ?></td><?php endforeach; ?></tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <section class="tarjeta">
        <h2>Ventas (precio × cantidad) y totales</h2>
        <div class="tabla-contenedor">
            <table>
                <thead>
                <tr>
                    <th></th>
                    <?php for ($j = 0; $j < $m; $j++): // encabezado de cada sucursal ?>
                        <th>Sucursal <?= $j + 1 ?></th>
                    <?php endfor; ?>
                    <th class="total">Total por artículo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($ventas as $i => $fila): // recorre cada artículo ?>
                    <tr>
                        <th>Artículo <?= $i + 1 ?></th>
                        <?php foreach ($fila as $venta): // imprime la venta en cada sucursal ?>
                            <td class="der"><?= dinero($venta) ?></td>
                        <?php endforeach; ?>
                        <td class="der total"><?= dinero($totalArticulos[$i]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Total por sucursal</th>
                    <?php foreach ($totalSucursales as $total): // imprime el total de cada sucursal ?>
                        <td class="der"><?= dinero($total) ?></td>
                    <?php endforeach; ?>
                    <td class="der"><?= dinero($totalGeneral) ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="espacio"></div>
        <div class="datos-resumen">
            <div class="dato principal"><span>Total vendido por la fábrica</span><strong><?= dinero($totalGeneral) ?></strong></div>
            <div class="dato"><span>Artículos</span><strong><?= $n ?></strong></div>
            <div class="dato"><span>Sucursales</span><strong><?= $m ?></strong></div>
        </div>
    </section>

    <a class="boton boton-secundario" href="Ejercicio05Controller.php">Nuevo cálculo</a>
<?php endif; ?>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
