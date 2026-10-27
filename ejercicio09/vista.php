<?php
// Vista del Ejercicio 9: formularios de registro y venta, y reporte general del inventario
if (!isset($medicamentos)) { header('Location: Ejercicio09Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 9;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 9';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 9 · Registros</span>
    <h1>Inventario de farmacia</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Una farmacia necesita controlar el inventario de sus medicamentos. Por cada medicamento se debe registrar el
        nombre, stock actual, stock mínimo y precio unitario. Elabore un programa que permita:</p>
    <ol type="a">
        <li>Registrar varios medicamentos en una lista.</li>
        <li>Mostrar los medicamentos cuyo stock esté por debajo del mínimo.</li>
        <li>Calcular el valor económico total del inventario.</li>
        <li>Actualizar el stock después de una venta.</li>
        <li>Mostrar un reporte general del inventario.</li>
    </ol>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php elseif ($mensaje !== ''): // si hay un mensaje de confirmación, lo muestra ?>
    <p class="mensaje exito"><?= e($mensaje) ?></p>
<?php endif; ?>

<div class="rejilla">
    <form method="post" class="tarjeta">
        <h2><span class="paso">a</span> Registrar medicamento</h2>
        <input type="hidden" name="accion" value="registrar">
        <div class="campos">
            <div class="campo ancho">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" maxlength="60" required value="<?= e($formulario['nombre']) ?>">
            </div>
            <div class="campo">
                <label for="stockActual">Stock actual</label>
                <input type="number" id="stockActual" name="stockActual" min="0" required value="<?= e($formulario['stockActual']) ?>">
            </div>
            <div class="campo">
                <label for="stockMinimo">Stock mínimo</label>
                <input type="number" id="stockMinimo" name="stockMinimo" min="0" required value="<?= e($formulario['stockMinimo']) ?>">
            </div>
            <div class="campo">
                <label for="precio">Precio unitario</label>
                <input type="number" id="precio" name="precio" min="0.01" step="0.01" required value="<?= e($formulario['precio']) ?>">
            </div>
        </div>
        <button type="submit">Registrar</button>
    </form>

    <form method="post" class="tarjeta">
        <h2><span class="paso">d</span> Registrar una venta</h2>
        <input type="hidden" name="accion" value="vender">
        <?php if (count($medicamentos) === 0): // si no hay medicamentos, no se puede vender ?>
            <p class="mensaje aviso">Primero registre al menos un medicamento.</p>
        <?php else: ?>
            <div class="campos">
                <div class="campo ancho">
                    <label for="indice">Medicamento</label>
                    <select id="indice" name="indice">
                        <?php foreach ($medicamentos as $indice => $medicamento): // una opción por medicamento ?>
                            <option value="<?= $indice ?>"><?= e($medicamento->nombre) ?> (stock: <?= $medicamento->stockActual ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="campo">
                    <label for="cantidad">Cantidad vendida</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" required>
                </div>
            </div>
            <button type="submit">Actualizar stock</button>
        <?php endif; ?>
    </form>
</div>

<section class="tarjeta">
    <h2><span class="paso">e</span> Reporte general del inventario</h2>
    <div class="datos-resumen">
        <div class="dato"><span>Medicamentos</span><strong><?= count($medicamentos) ?></strong></div>
        <div class="dato"><span>b) Bajo el mínimo</span><strong><?= count($bajoMinimo) ?></strong></div>
        <div class="dato principal"><span>c) Valor total del inventario</span><strong><?= dinero($valorTotal) ?></strong></div>
    </div>
    <div class="espacio"></div>

    <?php if (count($medicamentos) === 0): // si la lista está vacía, lo indica ?>
        <p class="mensaje info">El inventario está vacío. Registre medicamentos o cargue los datos de ejemplo.</p>
    <?php else: ?>
        <div class="tabla-contenedor">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th class="izq">Nombre</th>
                    <th>Stock actual</th>
                    <th>Stock mínimo</th>
                    <th class="der">Precio unitario</th>
                    <th class="der">Valor</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($medicamentos as $indice => $medicamento): // recorre la lista de medicamentos ?>
                    <?php $bajo = $modelo->estaBajoMinimo($medicamento); // indica si está bajo el mínimo ?>
                    <tr>
                        <th><?= $indice + 1 ?></th>
                        <td class="izq"><?= e($medicamento->nombre) ?></td>
                        <td><?= $medicamento->stockActual ?></td>
                        <td><?= $medicamento->stockMinimo ?></td>
                        <td class="der"><?= dinero($medicamento->precioUnitario) ?></td>
                        <td class="der"><?= dinero($modelo->valorMedicamento($medicamento)) ?></td>
                        <td><span class="pill <?= $bajo ? 'no' : 'si' ?>"><?= $bajo ? 'Bajo mínimo' : 'Suficiente' ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr><th colspan="5" class="der">Valor total del inventario</th><td class="der"><?= dinero($valorTotal) ?></td><td></td></tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>
</section>

<section class="tarjeta">
    <h2><span class="paso">b</span> Medicamentos por debajo del stock mínimo</h2>
    <?php if (count($bajoMinimo) === 0): // si no hay medicamentos con stock bajo ?>
        <p class="mensaje exito">Todos los medicamentos tienen stock suficiente.</p>
    <?php else: ?>
        <div class="tabla-contenedor">
            <table>
                <thead><tr><th class="izq">Nombre</th><th>Stock actual</th><th>Stock mínimo</th><th>Unidades faltantes</th></tr></thead>
                <tbody>
                <?php foreach ($bajoMinimo as $medicamento): // recorre los medicamentos con stock bajo ?>
                    <tr>
                        <td class="izq"><?= e($medicamento->nombre) ?></td>
                        <td class="nota-baja"><?= $medicamento->stockActual ?></td>
                        <td><?= $medicamento->stockMinimo ?></td>
                        <td><?= $modelo->unidadesFaltantes($medicamento) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<div class="acciones">
    <form method="post"><input type="hidden" name="accion" value="ejemplo"><button type="submit" class="boton-secundario">Cargar datos de ejemplo</button></form>
    <form method="post"><input type="hidden" name="accion" value="vaciar"><button type="submit" class="boton-secundario">Vaciar inventario</button></form>
</div>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
