<?php
// Modelo del Ejercicio 1: agrupa las funciones que procesan los arreglos de cédulas

class Ejercicio01Model // declara la clase del modelo
{
    // Limpia los datos recibidos del formulario y devuelve un arreglo de cédulas
    public function limpiarCedulas(array $datos): array // recibe el arreglo tal como llega del formulario
    {
        $cedulas = []; // crea un arreglo vacío para guardar las cédulas limpias
        foreach ($datos as $dato) { // recorre cada valor recibido
            $cedulas[] = trim((string) $dato); // quita los espacios de los extremos y lo agrega al arreglo
        }
        return $cedulas; // devuelve el arreglo de cédulas limpias
    }

    // Busca si una cédula existe dentro de un arreglo (búsqueda secuencial)
    public function existeEnArreglo(string $cedula, array $arreglo): bool // recibe la cédula y el arreglo donde buscar
    {
        for ($i = 0; $i < count($arreglo); $i++) { // recorre el arreglo desde la posición 0 hasta la última
            if ($arreglo[$i] === $cedula) { // compara la cédula buscada con la de la posición actual
                return true; // si coinciden, la cédula sí existe en el arreglo
            }
        }
        return false; // si terminó el recorrido sin encontrarla, la cédula no existe
    }

    // Forma el tercer arreglo con las cédulas que reprobaron las dos materias
    public function reprobaronAmbas(array $matematica, array $ingles): array // recibe los dos arreglos originales
    {
        $ambas = []; // crea el tercer arreglo vacío
        foreach ($matematica as $cedula) { // recorre cada cédula del arreglo de Matemática
            $estaEnIngles = $this->existeEnArreglo($cedula, $ingles); // verifica si también reprobó Inglés
            $yaAgregada = $this->existeEnArreglo($cedula, $ambas); // verifica si ya está en el tercer arreglo
            if ($estaEnIngles && !$yaAgregada) { // si reprobó Inglés y todavía no fue agregada
                $ambas[] = $cedula; // agrega la cédula al tercer arreglo
            }
        }
        return $ambas; // devuelve el tercer arreglo
    }
}
