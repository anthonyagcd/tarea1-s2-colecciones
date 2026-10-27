<?php
// Modelo del Ejercicio 8: funciones para evaluar las condiciones y el grado de eficiencia de los operarios

require_once __DIR__ . '/Operario.php'; // incluye el registro Operario

class Ejercicio08Model // declara la clase del modelo
{
    public const MAX_AUSENCIA = 3;        // condición 1: ausencia <= 3 horas
    public const MAX_DEFECTUOSOS = 300;   // condición 2: defectuosos < 300
    public const MIN_PRODUCIDOS = 10000;  // condición 3: producidos > 10000

    // Crea el arreglo de operarios a partir de los arreglos que llegan del formulario
    public function crearOperarios(array $codigos, array $horas, array $defectuosos, array $producidos): array
    {
        $operarios = []; // arreglo vacío donde se guardarán los registros
        for ($i = 0; $i < count($codigos); $i++) { // recorre cada posición de los arreglos
            $operarios[] = new Operario( // crea el registro del operario i
                trim((string) $codigos[$i]),        // código del trabajador
                (float) ($horas[$i] ?? 0),          // horas de ausencia
                (int) ($defectuosos[$i] ?? 0),      // pupitres defectuosos
                (int) ($producidos[$i] ?? 0)        // pupitres producidos
            );
        }
        return $operarios; // devuelve el arreglo de operarios
    }

    // Genera N operarios con datos aleatorios para probar el programa
    public function generarOperarios(int $cantidad): array
    {
        $operarios = []; // arreglo vacío donde se guardarán los registros
        for ($i = 0; $i < $cantidad; $i++) { // repite tantas veces como operarios se pidan
            $operarios[] = new Operario( // crea el registro con datos al azar
                sprintf('OP%03d', $i + 1), // código: OP001, OP002, ...
                rand(0, 8),                 // horas de ausencia entre 0 y 8
                rand(100, 500),             // pupitres defectuosos entre 100 y 500
                rand(8000, 12000)           // pupitres producidos entre 8000 y 12000
            );
        }
        return $operarios; // devuelve el arreglo de operarios
    }

    // Verifica si algún dato del operario es negativo
    public function datosInvalidos(array $operarios): bool
    {
        foreach ($operarios as $operario) { // recorre cada operario
            if ($operario->codigo === '' || $operario->horasAusencia < 0 || $operario->defectuosos < 0 || $operario->producidos < 0) { // si hay un dato vacío o negativo
                return true; // los datos no son válidos
            }
        }
        return false; // todos los datos son válidos
    }

    // Condición 1: ausencia del trabajo <= 3 horas
    public function cumpleAusencia(Operario $operario): bool
    {
        return $operario->horasAusencia <= self::MAX_AUSENCIA; // devuelve true si cumple la condición
    }

    // Condición 2: pupitres defectuosos < 300
    public function cumpleDefectuosos(Operario $operario): bool
    {
        return $operario->defectuosos < self::MAX_DEFECTUOSOS; // devuelve true si cumple la condición
    }

    // Condición 3: pupitres producidos > 10000
    public function cumpleProduccion(Operario $operario): bool
    {
        return $operario->producidos > self::MIN_PRODUCIDOS; // devuelve true si cumple la condición
    }

    // Calcula el grado de eficiencia según la combinación de condiciones que cumple
    public function calcularGrado(Operario $operario): int
    {
        $c1 = $this->cumpleAusencia($operario);     // evalúa la condición 1
        $c2 = $this->cumpleDefectuosos($operario);  // evalúa la condición 2
        $c3 = $this->cumpleProduccion($operario);   // evalúa la condición 3

        if ($c1 && $c2 && $c3) { // cumple las tres condiciones
            return 20; // grado 20
        } elseif ($c2 && $c3) { // cumple la segunda y la tercera
            return 15; // grado 15
        } elseif ($c1 && $c3) { // cumple la primera y la tercera
            return 13; // grado 13
        } elseif ($c1 && $c2) { // cumple la primera y la segunda
            return 12; // grado 12
        } elseif ($c3) { // solo cumple la tercera
            return 9; // grado 9
        } elseif ($c2) { // solo cumple la segunda
            return 8; // grado 8
        } elseif ($c1) { // solo cumple la primera
            return 7; // grado 7
        }
        return 5; // no cumple ninguna condición: grado 5
    }

    // Calcula y guarda el grado de eficiencia de cada operario del arreglo
    public function calcularGrados(array $operarios): void
    {
        foreach ($operarios as $operario) { // recorre cada operario
            $operario->grado = $this->calcularGrado($operario); // guarda su grado en el registro
        }
    }
}
