<?php
// Funciones de apoyo compartidas por todas las vistas

// Escapa un texto para mostrarlo de forma segura dentro del HTML
function e(string|int|float|null $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); // convierte los caracteres especiales en entidades HTML
}

// Da formato de moneda a un número: 1234.5 -> $ 1,234.50
function dinero(float $valor): string
{
    return '$ ' . number_format($valor, 2); // agrega el símbolo de dólar y dos decimales
}

// Arma la ruta al controlador de un ejercicio: 3 -> ejercicio03/Ejercicio03Controller.php
function rutaEjercicio(int $numero): string
{
    return sprintf('ejercicio%02d/Ejercicio%02dController.php', $numero, $numero); // rellena el número con un cero a la izquierda
}

// Imprime un vector como una fila de celdas con su índice; $resaltar indica las posiciones a destacar
function imprimirVector(array $vector, array $resaltar = []): void
{
    echo '<ul class="vector">'; // abre la lista que representa el vector
    foreach ($vector as $indice => $valor) { // recorre cada posición del vector
        $clase = in_array($indice, $resaltar, true) ? ' class="resaltado"' : ''; // marca la celda si debe destacarse
        echo "<li$clase>"; // abre la celda
        echo '<span class="indice">[' . $indice . ']</span>'; // imprime el índice de la posición
        echo '<span class="valor">' . e($valor) . '</span>'; // imprime el valor guardado en esa posición
        echo '</li>'; // cierra la celda
    }
    echo '</ul>'; // cierra la lista
}

// Imprime una matriz como tabla, con encabezados de fila y de columna
function imprimirMatriz(array $matriz, string $etiquetaFila = 'F', string $etiquetaColumna = 'C'): void
{
    $columnas = count($matriz[0] ?? []); // cuenta las columnas usando la primera fila
    echo '<div class="tabla-contenedor"><table class="matriz">'; // abre la tabla
    echo '<thead><tr><th></th>'; // abre la fila de encabezados con una celda vacía en la esquina
    for ($j = 0; $j < $columnas; $j++) { // recorre cada columna
        echo '<th>' . $etiquetaColumna . ($j + 1) . '</th>'; // imprime el encabezado de la columna
    }
    echo '</tr></thead><tbody>'; // cierra los encabezados y abre el cuerpo
    foreach ($matriz as $i => $fila) { // recorre cada fila de la matriz
        echo '<tr><th>' . $etiquetaFila . ($i + 1) . '</th>'; // imprime el encabezado de la fila
        foreach ($fila as $valor) { // recorre cada valor de la fila
            echo '<td>' . e($valor) . '</td>'; // imprime el valor en su celda
        }
        echo '</tr>'; // cierra la fila
    }
    echo '</tbody></table></div>'; // cierra la tabla
}
