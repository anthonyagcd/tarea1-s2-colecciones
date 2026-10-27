<?php
// Modelo del Ejercicio 5: funciones para la tabla de precios, la tabla de cantidades y sus totales

class Ejercicio05Model // declara la clase del modelo
{
    public const PRECIO_MIN = 1;     // precio mínimo de los datos aleatorios
    public const PRECIO_MAX = 50;    // precio máximo de los datos aleatorios
    public const CANTIDAD_MAX = 100; // cantidad máxima vendida en los datos aleatorios

    // Genera la tabla de precios (artículos x sucursales) con valores de dos decimales
    public function generarPrecios(int $articulos, int $sucursales): array
    {
        $precios = []; // crea la tabla vacía
        for ($i = 0; $i < $articulos; $i++) { // recorre cada artículo (fila)
            for ($j = 0; $j < $sucursales; $j++) { // recorre cada sucursal (columna)
                $precios[$i][$j] = rand(self::PRECIO_MIN * 100, self::PRECIO_MAX * 100) / 100; // precio aleatorio con centavos
            }
        }
        return $precios; // devuelve la tabla de precios
    }

    // Genera la tabla de cantidades vendidas (artículos x sucursales) con enteros
    public function generarCantidades(int $articulos, int $sucursales): array
    {
        $cantidades = []; // crea la tabla vacía
        for ($i = 0; $i < $articulos; $i++) { // recorre cada artículo (fila)
            for ($j = 0; $j < $sucursales; $j++) { // recorre cada sucursal (columna)
                $cantidades[$i][$j] = rand(0, self::CANTIDAD_MAX); // cantidad aleatoria vendida
            }
        }
        return $cantidades; // devuelve la tabla de cantidades
    }

    // Convierte los datos del formulario en una matriz numérica de $filas x $columnas
    public function leerMatriz(array $datos, int $filas, int $columnas, bool $enteros): array
    {
        $matriz = []; // crea la matriz vacía
        for ($i = 0; $i < $filas; $i++) { // recorre cada fila
            for ($j = 0; $j < $columnas; $j++) { // recorre cada columna
                $valor = $datos[$i][$j] ?? 0; // toma el dato de la celda o 0 si no existe
                $matriz[$i][$j] = $enteros ? (int) $valor : (float) $valor; // lo convierte a entero o decimal
            }
        }
        return $matriz; // devuelve la matriz convertida
    }

    // Verifica si la matriz tiene algún valor negativo
    public function tieneNegativos(array $matriz): bool
    {
        foreach ($matriz as $fila) { // recorre cada fila
            foreach ($fila as $valor) { // recorre cada valor de la fila
                if ($valor < 0) { // si el valor es negativo
                    return true; // la matriz tiene negativos
                }
            }
        }
        return false; // no encontró valores negativos
    }

    // Calcula la tabla de ventas: venta[i][j] = precio[i][j] * cantidad[i][j]
    public function calcularVentas(array $precios, array $cantidades): array
    {
        $ventas = []; // crea la tabla de ventas vacía
        for ($i = 0; $i < count($precios); $i++) { // recorre cada artículo
            for ($j = 0; $j < count($precios[0]); $j++) { // recorre cada sucursal
                $ventas[$i][$j] = $precios[$i][$j] * $cantidades[$i][$j]; // multiplica precio por cantidad
            }
        }
        return $ventas; // devuelve la tabla de ventas
    }

    // Total de ventas por cada artículo: suma de cada fila de la tabla de ventas
    public function totalPorArticulo(array $ventas): array
    {
        $totales = []; // arreglo con un total por artículo
        for ($i = 0; $i < count($ventas); $i++) { // recorre cada artículo (fila)
            $suma = 0; // acumulador de la fila
            for ($j = 0; $j < count($ventas[0]); $j++) { // recorre cada sucursal de la fila
                $suma += $ventas[$i][$j]; // acumula la venta
            }
            $totales[$i] = $suma; // guarda el total del artículo i
        }
        return $totales; // devuelve los totales por artículo
    }

    // Total de ventas por cada sucursal: suma de cada columna de la tabla de ventas
    public function totalPorSucursal(array $ventas): array
    {
        $totales = []; // arreglo con un total por sucursal
        for ($j = 0; $j < count($ventas[0]); $j++) { // recorre cada sucursal (columna)
            $suma = 0; // acumulador de la columna
            for ($i = 0; $i < count($ventas); $i++) { // recorre cada artículo de la columna
                $suma += $ventas[$i][$j]; // acumula la venta
            }
            $totales[$j] = $suma; // guarda el total de la sucursal j
        }
        return $totales; // devuelve los totales por sucursal
    }
}
