<?php
// Vista del Ejercicio 10: formulario de pedidos, lista con totales y pedido de mayor valor
if (!isset($pedidos)) { header('Location: Ejercicio10Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 10;                              // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 10';                     // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 10 · Registros</span>
    <h1>Pedidos del restaurante</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Un restaurante registra los pedidos realizados por sus clientes. Por cada pedido se debe ingresar el nombre del
        cliente, plato solicitado, cantidad y precio unitario. Elabore un programa que permita:</p>
    <ol type="a">
        <li>Registrar pedidos en una lista.</li>
        <li>Calcular el total a pagar por cada pedido.</li>
        <li>Aplicar un descuento del 10% si el pedido supera los 50 USD.</li>
        <li>Calcular el ingreso total del restaurante.</li>
        <li>Mostrar el pedido de mayor valor.</li>
    </ol>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php elseif ($mensaje !== ''): // si hay un mensaje de confirmación, lo muestra ?>
    <p class="mensaje exito"><?= e($mensaje) ?></p>
<?php endif; ?>

<div class="rejilla">
    <form method="post" class="tarjeta">
        <h2><span class="paso">a</span> Registrar pedido</h2>
        <input type="hidden" name="accion" value="registrar">
        <div class="campos">
            <div class="campo">
                <label for="cliente">Cliente</label>
                <input type="text" id="cliente" name="cliente" maxlength="60" required value="<?= e($formulario['cliente']) ?>">
            </div>
            <div class="campo">
                <label for="plato">Plato</label>
                <input type="text" id="plato" name="plato" maxlength="60" required value="<?= e($formulario['plato']) ?>">
            </div>
            <div class="campo">
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" min="1" required value="<?= e($formulario['cantidad']) ?>">
            </div>
            <div class="campo">
                <label for="precio">Precio unitario</label>
                <input type="number" id="precio" name="precio" min="0.01" step="0.01" required value="<?= e($formulario['precio']) ?>">
            </div>
        </div>
        <button type="submit">Registrar</button>
        <p class="texto-suave">Se aplica un 10 % de descuento a los pedidos que superan <?= dinero(Ejercicio10Model::LIMITE_DESCUENTO) ?>.</p>
    </form>

    <section class="tarjeta">
        <h2>Resumen</h2>
        <div class="datos-resumen">
            <div class="dato"><span>Pedidos</span><strong><?= count($pedidos) ?></strong></div>
            <div class="dato principal"><span>d) Ingreso total</span><strong><?= dinero($ingresoTotal) ?></strong></div>
        </div>
        <div class="espacio"></div>
        <h2><span class="paso">e</span> Pedido de mayor valor</h2>
        <?php if ($mayor === -1): // si no hay pedidos ?>
            <p class="mensaje info">Todavía no hay pedidos registrados.</p>
        <?php else: // muestra los datos del pedido mayor ?>
            <dl class="datos">
                <dt>Cliente</dt><dd><?= e($pedidos[$mayor]->cliente) ?></dd>
                <dt>Plato</dt><dd><?= e($pedidos[$mayor]->plato) ?></dd>
                <dt>Cantidad</dt><dd><?= $pedidos[$mayor]->cantidad ?></dd>
                <dt>Total a pagar</dt><dd><strong><?= dinero($modelo->totalAPagar($pedidos[$mayor])) ?></strong></dd>
            </dl>
        <?php endif; ?>
    </section>
</div>

<section class="tarjeta">
    <h2><span class="paso">b</span> Lista de pedidos y total a pagar</h2>
    <?php if (count($pedidos) === 0): // si la lista está vacía, lo indica ?>
        <p class="mensaje info">No hay pedidos. Registre uno o cargue los datos de ejemplo.</p>
    <?php else: ?>
        <div class="tabla-contenedor">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th class="izq">Cliente</th>
                    <th class="izq">Plato</th>
                    <th>Cantidad</th>
                    <th class="der">Precio unitario</th>
                    <th class="der">Subtotal</th>
                    <th class="der">c) Descuento 10 %</th>
                    <th class="der total">Total a pagar</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($pedidos as $indice => $pedido): // recorre la lista de pedidos ?>
                    <tr class="<?= $indice === $mayor ? 'destacado' : '' ?>">
                        <th><?= $indice + 1 ?></th>
                        <td class="izq"><?= e($pedido->cliente) ?></td>
                        <td class="izq"><?= e($pedido->plato) ?></td>
                        <td><?= $pedido->cantidad ?></td>
                        <td class="der"><?= dinero($pedido->precioUnitario) ?></td>
                        <td class="der"><?= dinero($modelo->subtotal($pedido)) ?></td>
                        <td class="der"><?= $modelo->descuento($pedido) > 0 ? '− ' . dinero($modelo->descuento($pedido)) : '—' ?></td>
                        <td class="der total"><?= dinero($modelo->totalAPagar($pedido)) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr><th colspan="7" class="der">d) Ingreso total del restaurante</th><td class="der"><?= dinero($ingresoTotal) ?></td></tr>
                </tfoot>
            </table>
        </div>
        <p class="texto-suave">La fila resaltada es el pedido de mayor valor.</p>
    <?php endif; ?>
</section>

<div class="acciones">
    <form method="post"><input type="hidden" name="accion" value="ejemplo"><button type="submit" class="boton-secundario">Cargar datos de ejemplo</button></form>
    <form method="post"><input type="hidden" name="accion" value="vaciar"><button type="submit" class="boton-secundario">Eliminar todos los pedidos</button></form>
</div>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
