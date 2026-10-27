<?php
// Vista del Ejercicio 1: muestra los formularios y los tres vectores resultantes
if (!isset($paso)) { header('Location: Ejercicio01Controller.php'); exit; } // si se abre la vista directamente, redirige al controlador

$numeroEjercicio = 1;                               // número del ejercicio para marcarlo en el menú lateral
$tituloPagina = 'Ejercicio 1';                      // título de la pestaña del navegador
require __DIR__ . '/../comun/cabecera.php';         // incluye la cabecera común
?>
<div class="titulo-pagina">
    <span class="etiqueta">Ejercicio 1 · Arreglos</span>
    <h1>Estudiantes que reprobaron Matemática e Inglés</h1>
</div>

<details class="enunciado" open>
    <summary>Enunciado</summary>
    <p>Elabore un programa que forme dos arreglos de N dimensiones (N se ingresa por teclado). El primero contiene
        los números de cédula de estudiantes que reprobaron la asignatura de "MATEMATICA" y el segundo contiene los
        números de cédula de estudiantes que reprobaron la asignatura de "INGLES". Partiendo de los dos vectores, se
        debe formar un tercero que contenga el código de estudiantes que reprobaron las dos materias. Al finalizar se
        debe imprimir los tres vectores.</p>
</details>

<?php if ($error !== ''): // si hay un error, lo muestra ?>
    <p class="mensaje error"><?= e($error) ?></p>
<?php endif; ?>

<?php if ($paso === 1): // paso 1: pedir N ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">1</span> Tamaño de los arreglos</h2>
        <div class="campos">
            <div class="campo">
                <label for="n">Estudiantes por materia (N)</label>
                <input type="number" id="n" name="n" min="1" max="50" required autofocus>
            </div>
        </div>
        <button type="submit">Continuar</button>
    </form>

<?php elseif ($paso === 2): // paso 2: pedir las N cédulas de cada materia ?>
    <form method="post" class="tarjeta">
        <h2><span class="paso">2</span> Ingrese las <?= $n ?> cédulas de cada materia</h2>
        <input type="hidden" name="n" value="<?= $n ?>">
        <div class="columnas">
            <fieldset>
                <legend>Reprobados en MATEMÁTICA</legend>
                <div class="lista-campos">
                    <?php for ($i = 0; $i < $n; $i++): // crea N casillas para Matemática ?>
                        <input type="text" name="matematica[]" placeholder="Cédula <?= $i + 1 ?>"
                               pattern="\d{10}" maxlength="10" title="10 dígitos" required>
                    <?php endfor; ?>
                </div>
            </fieldset>
            <fieldset>
                <legend>Reprobados en INGLÉS</legend>
                <div class="lista-campos">
                    <?php for ($i = 0; $i < $n; $i++): // crea N casillas para Inglés ?>
                        <input type="text" name="ingles[]" placeholder="Cédula <?= $i + 1 ?>"
                               pattern="\d{10}" maxlength="10" title="10 dígitos" required>
                    <?php endfor; ?>
                </div>
            </fieldset>
        </div>
        <button type="submit">Formar arreglos</button>
    </form>

<?php else: // paso 3: imprimir los tres vectores ?>
    <?php
    $vectores = [ // agrupa los tres vectores con su título para imprimirlos con un solo ciclo
        'Vector 1 · Reprobados en MATEMÁTICA' => $matematica,
        'Vector 2 · Reprobados en INGLÉS' => $ingles,
        'Vector 3 · Reprobados en LAS DOS materias' => $ambas,
    ];
    ?>
    <?php foreach ($vectores as $titulo => $vector): // recorre cada vector ?>
        <section class="tarjeta">
            <h2><?= $titulo ?> <small>(<?= count($vector) ?> <?= count($vector) === 1 ? 'elemento' : 'elementos' ?>)</small></h2>
            <?php if (count($vector) === 0): // si el vector está vacío, lo indica ?>
                <p class="mensaje aviso">Ningún estudiante reprobó las dos materias.</p>
            <?php else: ?>
                <?php imprimirVector($vector); // imprime el vector con sus índices ?>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>

    <a class="boton" href="Ejercicio01Controller.php">Nuevo ingreso</a>
<?php endif; ?>

<?php require __DIR__ . '/../comun/pie.php'; // incluye el pie común ?>
