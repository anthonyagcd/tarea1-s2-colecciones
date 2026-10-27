<?php
// Modelo del Ejercicio 7: funciones para procesar la matriz de calificaciones (estudiantes x 8 materias)

class Ejercicio07Model // declara la clase del modelo
{
    public const MATERIAS = 8;      // cada estudiante toma 8 materias
    public const NOTA_MINIMA = 0;   // nota mínima permitida
    public const NOTA_MAXIMA = 10;  // nota máxima permitida
    public const APRUEBA_CON = 7;   // nota mínima para aprobar

    // Genera N códigos de estudiante: EST001, EST002, ...
    public function generarCodigos(int $estudiantes): array
    {
        $codigos = []; // crea el arreglo vacío
        for ($i = 0; $i < $estudiantes; $i++) { // recorre cada estudiante
            $codigos[$i] = sprintf('EST%03d', $i + 1); // arma el código con tres dígitos
        }
        return $codigos; // devuelve los códigos
    }

    // Genera la matriz de notas aleatorias (N estudiantes x 8 materias) con un decimal
    public function generarNotas(int $estudiantes): array
    {
        $notas = []; // crea la matriz vacía
        for ($i = 0; $i < $estudiantes; $i++) { // recorre cada estudiante (fila)
            for ($k = 0; $k < self::MATERIAS; $k++) { // recorre cada materia (columna)
                $notas[$i][$k] = rand(40, 100) / 10; // nota aleatoria entre 4.0 y 10.0
            }
        }
        return $notas; // devuelve la matriz de notas
    }

    // Convierte los datos del formulario en la matriz de notas
    public function leerNotas(array $datos, int $estudiantes): array
    {
        $notas = []; // crea la matriz vacía
        for ($i = 0; $i < $estudiantes; $i++) { // recorre cada estudiante
            for ($k = 0; $k < self::MATERIAS; $k++) { // recorre cada materia
                $notas[$i][$k] = (float) ($datos[$i][$k] ?? 0); // toma la nota y la convierte a decimal
            }
        }
        return $notas; // devuelve la matriz de notas
    }

    // Verifica que todas las notas estén entre 0 y 10
    public function notasValidas(array $notas): bool
    {
        foreach ($notas as $fila) { // recorre cada estudiante
            foreach ($fila as $nota) { // recorre cada nota del estudiante
                if ($nota < self::NOTA_MINIMA || $nota > self::NOTA_MAXIMA) { // si la nota está fuera del rango
                    return false; // la matriz no es válida
                }
            }
        }
        return true; // todas las notas son válidas
    }

    // Literal a: promedio de las calificaciones de cada estudiante (promedio de cada fila)
    public function promedioPorEstudiante(array $notas): array
    {
        $promedios = []; // arreglo con un promedio por estudiante
        for ($i = 0; $i < count($notas); $i++) { // recorre cada estudiante
            $suma = 0; // acumulador de las notas del estudiante
            for ($k = 0; $k < self::MATERIAS; $k++) { // recorre sus 8 materias
                $suma += $notas[$i][$k]; // acumula la nota
            }
            $promedios[$i] = $suma / self::MATERIAS; // divide para obtener el promedio
        }
        return $promedios; // devuelve los promedios por estudiante
    }

    // Literal b: promedio de la calificación de cada materia (promedio de cada columna)
    public function promedioPorMateria(array $notas): array
    {
        $promedios = []; // arreglo con un promedio por materia
        for ($k = 0; $k < self::MATERIAS; $k++) { // recorre cada materia
            $suma = 0; // acumulador de las notas de la materia
            for ($i = 0; $i < count($notas); $i++) { // recorre cada estudiante en esa materia
                $suma += $notas[$i][$k]; // acumula la nota
            }
            $promedios[$k] = $suma / count($notas); // divide para obtener el promedio
        }
        return $promedios; // devuelve los promedios por materia
    }

    // Literal c: posición del estudiante con el mayor promedio
    public function estudianteMayorPromedio(array $promedios): int
    {
        $posicionMayor = 0; // supone que el primer estudiante tiene el mayor promedio
        for ($i = 1; $i < count($promedios); $i++) { // recorre el resto de estudiantes
            if ($promedios[$i] > $promedios[$posicionMayor]) { // si encuentra un promedio mayor
                $posicionMayor = $i; // actualiza la posición del mayor
            }
        }
        return $posicionMayor; // devuelve la posición del estudiante con mayor promedio
    }

    // Literal d: número de aprobados por materia (nota >= 7 y <= 10)
    public function aprobadosPorMateria(array $notas): array
    {
        $aprobados = []; // arreglo con un contador por materia
        for ($k = 0; $k < self::MATERIAS; $k++) { // recorre cada materia
            $aprobados[$k] = 0; // inicia el contador de la materia
            for ($i = 0; $i < count($notas); $i++) { // recorre cada estudiante
                if ($notas[$i][$k] >= self::APRUEBA_CON && $notas[$i][$k] <= self::NOTA_MAXIMA) { // si aprobó
                    $aprobados[$k]++; // aumenta el contador de aprobados
                }
            }
        }
        return $aprobados; // devuelve los aprobados por materia
    }

    // Literal e: número de reprobados por materia (nota < 7)
    public function reprobadosPorMateria(array $notas): array
    {
        $reprobados = []; // arreglo con un contador por materia
        for ($k = 0; $k < self::MATERIAS; $k++) { // recorre cada materia
            $reprobados[$k] = 0; // inicia el contador de la materia
            for ($i = 0; $i < count($notas); $i++) { // recorre cada estudiante
                if ($notas[$i][$k] < self::APRUEBA_CON) { // si reprobó
                    $reprobados[$k]++; // aumenta el contador de reprobados
                }
            }
        }
        return $reprobados; // devuelve los reprobados por materia
    }
}
