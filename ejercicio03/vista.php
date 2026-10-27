<?php
// Vista del Ejercicio 3: formularios para registrar empleados y buscar uno por su código
if (!isset($paso)) { header('Location: Ejercicio03Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 3;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 3';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 3 · Registros</span>
    <h1>Búsqueda de empleados por código</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Una empresa requiere un programa que permita ingresar los códigos y nombres de N empleados (N se ingresa por
        teclado). Al finalizar, debe solicitar ingresar un código y se debe imprimir el nombre del empleado que corresponda.</p>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($paso === 1): // paso 1: pedir N ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">1</span> Cantidad de empleados</h2>
        <div class="campos">
            <div class="campo">
                <label for="n">Número de empleados (N)</label>
                <input type="number" id="n" name="n" min="1" max="50" required autofocus>
            </div>
        </div>
        <button type="submit">Continuar</button>
    </form>

<?php elseif ($paso === 2): // paso 2: pedir código y nombre de cada empleado ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">2</span> Datos de los <?= $n ?> empleados</h2>
        <input type="hidden" name="n" value="<?= $n ?>">
        <div class="tabla-contenedor">
            <table class="entrada">
                <thead><tr><th>#</th><th class="izq">Código</th><th class="izq">Nombre</th></tr></thead>
                <tbody>
                <?php for ($i = 0; $i < $n; $i++): // crea una fila por cada empleado ?>
                    <tr>
                        <th><?= $i + 1 ?></th>
                        <td><input type="text" name="codigos[]" maxlength="15" required placeholder="EMP<?= sprintf('%03d', $i + 1) ?>"
                                   value="<?= e($empleados[$i]->codigo ?? '') ?>"></td>
                        <td><input type="text" name="nombres[]" maxlength="80" required placeholder="Nombre completo"
                                   value="<?= e($empleados[$i]->nombre ?? '') ?>"></td>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <div class="espacio"></div>
        <button type="submit">Registrar empleados</button>
    </form>

<?php else: // paso 3: mostrar los empleados y buscar por código ?>
    <div class="rejilla">
        <section class="tarjeta">
            <h2>Empleados registrados <small>(<?= count($empleados) ?>)</small></h2>
            <div class="tabla-contenedor">
                <table>
                    <thead><tr><th>Posición</th><th class="izq">Código</th><th class="izq">Nombre</th></tr></thead>
                    <tbody>
                    <?php foreach ($empleados as $indice => $empleado): // recorre el arreglo de registros ?>
                        <tr class="<?= $encontrado === $empleado ? 'destacado' : '' ?>">
                            <th><?= $indice ?></th>
                            <td class="izq"><?= e($empleado->codigo) ?></td>
                            <td class="izq"><?= e($empleado->nombre) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <form method="post" class="tarjeta">
            <h2><span class="paso">3</span> Buscar empleado por código</h2>
            <input type="hidden" name="n" value="<?= $n ?>">
            <?php foreach ($empleados as $empleado): // reenvía los empleados para no perderlos entre búsquedas ?>
                <input type="hidden" name="codigos[]" value="<?= e($empleado->codigo) ?>">
                <input type="hidden" name="nombres[]" value="<?= e($empleado->nombre) ?>">
            <?php endforeach; ?>
            <div class="campo">
                <label for="buscar">Código del empleado</label>
                <input type="text" id="buscar" name="buscar" required autofocus value="<?= e($codigoBuscado) ?>">
            </div>
            <div class="espacio"></div>
            <button type="submit">Buscar</button>

            <?php if ($codigoBuscado !== null): // si ya se hizo una búsqueda, muestra el resultado ?>
                <?php if ($encontrado !== null): // si se encontró el empleado ?>
                    <p class="mensaje exito arriba">Empleado: <strong><?= e($encontrado->nombre) ?></strong></p>
                <?php else: // si no se encontró ?>
                    <p class="mensaje aviso arriba">No existe un empleado con el código <strong><?= e($codigoBuscado) ?></strong>.</p>
                <?php endif; ?>
            <?php endif; ?>
        </form>
    </div>

    <a class="boton boton-secundario" href="Ejercicio03Controller.php">Nuevo registro</a>
<?php endif; ?>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
