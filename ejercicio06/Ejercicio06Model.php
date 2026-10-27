<?php
// Modelo del Ejercicio 6: funciones para consolidar la matriz de ventas (vendedores x años)

class Ejercicio06Model // declara la clase del modelo
{
    public const VENTA_MIN = 1000;  // venta mínima de los datos aleatorios
    public const VENTA_MAX = 20000; // venta máxima de los datos aleatorios

    // Genera la matriz de ventas de $vendedores x $anios con valores aleatorios
    public function generarVentas(int $vendedores, int $anios): array
    {
        $ventas = []; // crea la matriz vacía
        for ($i = 0; $i < $vendedores; $i++) { // recorre cada vendedor (fila)
            for ($j = 0; $j < $anios; $j++) { // recorre cada año (columna)
                $ventas[$i][$j] = rand(self::VENTA_MIN, self::VENTA_MAX); // venta aleatoria del vendedor i en el año j
            }
        }
        return $ventas; // devuelve la matriz de ventas
    }

    // Convierte los datos del formulario en una matriz de decimales de $filas x $columnas
    public function leerMatriz(array $datos, int $filas, int $columnas): array
    {
        $matriz = []; // crea la matriz vacía
        for ($i = 0; $i < $filas; $i++) { // recorre cada fila
            for ($j = 0; $j < $columnas; $j++) { // recorre cada columna
                $matriz[$i][$j] = (float) ($datos[$i][$j] ?? 0); // toma el dato y lo convierte a decimal
            }
        }
        return $matriz; // devuelve la matriz convertida
    }

    // Literal a: total de ventas de cada vendedor en los M años (suma de cada fila)
    public function totalPorVendedor(array $ventas): array
    {
        $totales = []; // arreglo con un total por vendedor
        for ($i = 0; $i < count($ventas); $i++) { // recorre cada vendedor
            $suma = 0; // acumulador de la fila
            for ($j = 0; $j < count($ventas[0]); $j++) { // recorre cada año del vendedor
                $suma += $ventas[$i][$j]; // acumula la venta del año
            }
            $totales[$i] = $suma; // guarda el total del vendedor i
        }
        return $totales; // devuelve los totales por vendedor
    }

    // Literal b: total de ventas en cada año (suma de cada columna)
    public function totalPorAnio(array $ventas): array
    {
        $totales = []; // arreglo con un total por año
        for ($j = 0; $j < count($ventas[0]); $j++) { // recorre cada año
            $suma = 0; // acumulador de la columna
            for ($i = 0; $i < count($ventas); $i++) { // recorre cada vendedor en ese año
                $suma += $ventas[$i][$j]; // acumula la venta del vendedor
            }
            $totales[$j] = $suma; // guarda el total del año j
        }
        return $totales; // devuelve los totales por año
    }

    // Literal c: total de ventas de la empresa (suma de todos los elementos)
    public function totalEmpresa(array $ventas): float
    {
        $total = 0; // acumulador general
        foreach ($ventas as $fila) { // recorre cada fila
            foreach ($fila as $venta) { // recorre cada venta de la fila
                $total += $venta; // acumula la venta
            }
        }
        return $total; // devuelve el total de la empresa
    }
}
