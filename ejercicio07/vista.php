<?php
// Vista del Ejercicio 7: matriz de calificaciones con promedios, aprobados y reprobados
if (!isset($paso)) { header('Location: Ejercicio07Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 7;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 7';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
$materias = Ejercicio07Model::MATERIAS;             // número de materias para dibujar las columnas
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 7 · Matrices</span>
    <h1>Calificaciones de estudiantes</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>En una universidad, se tiene un grupo de N estudiantes; cada uno de ellos toma 8 materias; semestralmente el
        profesor de cada materia reporta a secretaría general el código del estudiante, el número de la materia y la
        calificación final. Elaborar un algoritmo que obtenga:</p>
    <ol type="a">
        <li>El promedio de las calificaciones obtenidas por cada estudiante.</li>
        <li>El promedio de la calificación por cada materia.</li>
        <li>El estudiante con mayor promedio.</li>
        <li>El número de estudiantes aprobados (nota final &gt;= 7 y &lt;= 10) por cada materia.</li>
        <li>El número de estudiantes reprobados (nota final &lt; 7) por cada materia.</li>
    </ol>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($paso === 1): // paso 1: pedir N y el modo de llenado ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">1</span> Grupo de estudiantes</h2>
        <div class="campos">
            <div class="campo">
                <label for="n">Estudiantes (N)</label>
                <input type="number" id="n" name="n" min="1" max="30" required value="<?= $n ?>">
            </div>
            <div class="campo">
                <label for="modo">Llenado de las notas</label>
                <select id="modo" name="modo">
                    <option value="aleatorio" <?= $modo === 'aleatorio' ? 'selected' : '' ?>>Valores aleatorios</option>
                    <option value="manual" <?= $modo === 'manual' ? 'selected' : '' ?>>Ingresar manualmente</option>
                </select>
            </div>
        </div>
        <button type="submit">Continuar</button>
    </form>

<?php elseif ($paso === 2): // paso 2: ingresar código y 8 notas por estudiante ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">2</span> Reporte de calificaciones</h2>
        <p class="texto-suave">Cada fila es un estudiante (código) y cada columna es el número de la materia; la celda es la calificación final.</p>
        <input type="hidden" name="n" value="<?= $n ?>">
        <input type="hidden" name="modo" value="manual">
        <div class="tabla-contenedor">
            <table class="entrada">
                <thead>
                <tr>
                    <th class="izq">Código</th>
                    <?php for ($k = 0; $k < $materias; $k++): // encabezado de cada materia ?>
                        <th>Materia <?= $k + 1 ?></th>
                    <?php endfor; ?>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i < $n; $i++): // una fila por estudiante ?>
                    <tr>
                        <td><input type="text" name="codigos[]" required maxlength="12"
                                   value="<?= e($codigos[$i] ?? sprintf('EST%03d', $i + 1)) ?>"></td>
                        <?php for ($k = 0; $k < $materias; $k++): // una casilla por materia ?>
                            <td><input type="number" name="notas[<?= $i ?>][<?= $k ?>]" min="0" max="10" step="0.01" required
                                       value="<?= e($notas[$i][$k] ?? '') ?>"></td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <div class="espacio"></div>
        <button type="submit">Calcular resultados</button>
    </form>

<?php else: // paso 3: mostrar los resultados ?>
    <section class="tarjeta">
        <h2>Calificaciones y resultados <small>(<?= $n ?> estudiantes x <?= $materias ?> materias)</small></h2>
        <div class="tabla-contenedor">
            <table>
                <thead>
                <tr>
                    <th class="izq">Código</th>
                    <?php for ($k = 0; $k < $materias; $k++): // encabezado de cada materia ?>
                        <th>M<?= $k + 1 ?></th>
                    <?php endfor; ?>
                    <th class="total">a) Promedio</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($notas as $i => $fila): // recorre cada estudiante ?>
                    <tr class="<?= $i === $mejor ? 'destacado' : '' ?>">
                        <th class="izq"><?= e($codigos[$i]) ?></th>
                        <?php foreach ($fila as $nota): // imprime cada nota; las reprobadas en rojo ?>
                            <td class="<?= $nota < Ejercicio07Model::APRUEBA_CON ? 'nota-baja' : '' ?>"><?= number_format($nota, 2) ?></td>
                        <?php endforeach; ?>
                        <td class="total"><?= number_format($promediosEstudiante[$i], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th class="izq">b) Promedio materia</th>
                    <?php foreach ($promediosMateria as $promedio): // imprime el promedio de cada materia ?>
                        <td><?= number_format($promedio, 2) ?></td>
                    <?php endforeach; ?>
                    <td></td>
                </tr>
                <tr>
                    <th class="izq">d) Aprobados</th>
                    <?php foreach ($aprobados as $cantidad): // imprime los aprobados de cada materia ?>
                        <td><?= $cantidad ?></td>
                    <?php endforeach; ?>
                    <td></td>
                </tr>
                <tr>
                    <th class="izq">e) Reprobados</th>
                    <?php foreach ($reprobados as $cantidad): // imprime los reprobados de cada materia ?>
                        <td><?= $cantidad ?></td>
                    <?php endforeach; ?>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <p class="texto-suave">Las notas menores a 7 aparecen en rojo. La fila resaltada es el estudiante con mayor promedio.</p>
    </section>

    <section class="tarjeta">
        <h2><span class="paso">c</span> Estudiante con mayor promedio</h2>
        <div class="datos-resumen">
            <div class="dato principal"><span>Código</span><strong><?= e($codigos[$mejor]) ?></strong></div>
            <div class="dato principal"><span>Promedio</span><strong><?= number_format($promediosEstudiante[$mejor], 2) ?></strong></div>
        </div>
    </section>

    <a class="boton boton-secundario" href="Ejercicio07Controller.php">Nuevo cálculo</a>
<?php endif; ?>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
