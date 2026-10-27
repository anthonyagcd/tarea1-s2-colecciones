<?php
// Modelo del Ejercicio 4: funciones para generar matrices y realizar operaciones entre ellas

class Ejercicio04Model // declara la clase del modelo
{
    public const MINIMO = 1; // valor mínimo de los elementos aleatorios
    public const MAXIMO = 9; // valor máximo de los elementos aleatorios

    // Genera una matriz de $filas x $columnas con enteros aleatorios
    public function generarMatriz(int $filas, int $columnas, int $minimo, int $maximo): array
    {
        $matriz = []; // crea la matriz vacía
        for ($i = 0; $i < $filas; $i++) { // recorre cada fila
            for ($j = 0; $j < $columnas; $j++) { // recorre cada columna de la fila
                $matriz[$i][$j] = rand($minimo, $maximo); // guarda un número aleatorio en la celda [i][j]
            }
        }
        return $matriz; // devuelve la matriz llena
    }

    // Suma dos matrices del mismo tamaño: C[i][j] = A[i][j] + B[i][j]
    public function sumar(array $a, array $b): array
    {
        $resultado = []; // crea la matriz resultado vacía
        for ($i = 0; $i < count($a); $i++) { // recorre cada fila
            for ($j = 0; $j < count($a[0]); $j++) { // recorre cada columna
                $resultado[$i][$j] = $a[$i][$j] + $b[$i][$j]; // suma los elementos de la misma posición
            }
        }
        return $resultado; // devuelve la matriz suma
    }

    // Resta dos matrices del mismo tamaño: C[i][j] = A[i][j] - B[i][j]
    public function restar(array $a, array $b): array
    {
        $resultado = []; // crea la matriz resultado vacía
        for ($i = 0; $i < count($a); $i++) { // recorre cada fila
            for ($j = 0; $j < count($a[0]); $j++) { // recorre cada columna
                $resultado[$i][$j] = $a[$i][$j] - $b[$i][$j]; // resta los elementos de la misma posición
            }
        }
        return $resultado; // devuelve la matriz resta
    }

    // Multiplica A (M x N) por B (N x P): C[i][j] = suma de A[i][k] * B[k][j]
    public function multiplicar(array $a, array $b): array
    {
        $filas = count($a);       // número de filas de A (M)
        $comun = count($b);       // número de filas de B, igual a las columnas de A (N)
        $columnas = count($b[0]); // número de columnas de B (P)
        $resultado = [];          // crea la matriz resultado vacía

        for ($i = 0; $i < $filas; $i++) { // recorre cada fila de A
            for ($j = 0; $j < $columnas; $j++) { // recorre cada columna de B
                $suma = 0; // acumulador del producto fila por columna
                for ($k = 0; $k < $comun; $k++) { // recorre los elementos de la fila i de A y de la columna j de B
                    $suma += $a[$i][$k] * $b[$k][$j]; // multiplica y acumula
                }
                $resultado[$i][$j] = $suma; // guarda el resultado en la celda [i][j]
            }
        }
        return $resultado; // devuelve la matriz producto
    }

    // Devuelve la traspuesta de una matriz: las filas pasan a ser columnas
    public function trasponer(array $matriz): array
    {
        $traspuesta = []; // crea la matriz traspuesta vacía
        for ($i = 0; $i < count($matriz); $i++) { // recorre cada fila de la matriz original
            for ($j = 0; $j < count($matriz[0]); $j++) { // recorre cada columna de la matriz original
                $traspuesta[$j][$i] = $matriz[$i][$j]; // intercambia fila por columna
            }
        }
        return $traspuesta; // devuelve la matriz traspuesta
    }
}
