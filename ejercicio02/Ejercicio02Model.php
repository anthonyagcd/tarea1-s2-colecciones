<?php
// Modelo del Ejercicio 2: funciones para generar, recorrer y filtrar un vector de 20 enteros

class Ejercicio02Model // declara la clase del modelo
{
    public const TAMANO = 20; // cantidad de elementos del vector original
    public const MINIMO = 1;  // valor mínimo de los números aleatorios
    public const MAXIMO = 50; // valor máximo de los números aleatorios
    public const LIMITE = 20; // valor de comparación del literal c (mayores a 20)

    // Genera un vector de $tamano números enteros aleatorios entre $minimo y $maximo
    public function generarVector(int $tamano, int $minimo, int $maximo): array
    {
        $vector = []; // crea el vector vacío
        for ($i = 0; $i < $tamano; $i++) { // repite tantas veces como elementos tendrá el vector
            $vector[$i] = rand($minimo, $maximo); // guarda un número aleatorio en la posición i
        }
        return $vector; // devuelve el vector lleno
    }

    // Convierte el texto "4,18,33,..." que viaja en el formulario en un vector de enteros
    public function textoAVector(string $texto): array
    {
        $vector = []; // crea el vector vacío
        foreach (explode(',', $texto) as $valor) { // separa el texto por comas y recorre cada parte
            $vector[] = (int) $valor; // convierte cada parte a entero y la agrega al vector
        }
        return $vector; // devuelve el vector reconstruido
    }

    // Literal a: devuelve todas las posiciones del vector donde se encuentra el número buscado
    public function buscarPosiciones(array $vector, int $numero): array
    {
        $posiciones = []; // arreglo donde se guardarán las posiciones encontradas
        for ($i = 0; $i < count($vector); $i++) { // recorre el vector de principio a fin
            if ($vector[$i] === $numero) { // compara el elemento actual con el número buscado
                $posiciones[] = $i; // si coincide, guarda la posición
            }
        }
        return $posiciones; // devuelve las posiciones (vacío si no se encontró)
    }

    // Literal b: crea un segundo vector con los elementos de los índices impares (1, 3, 5, ...)
    public function elementosIndiceImpar(array $vector): array
    {
        $impares = []; // crea el segundo vector vacío
        for ($i = 1; $i < count($vector); $i += 2) { // empieza en 1 y avanza de 2 en 2 para tomar solo índices impares
            $impares[] = $vector[$i]; // agrega el elemento de la posición impar al segundo vector
        }
        return $impares; // devuelve el segundo vector
    }

    // Literal c: cuenta cuántos elementos del vector son mayores al límite
    public function contarMayoresA(array $vector, int $limite): int
    {
        $contador = 0; // inicia el contador en cero
        foreach ($vector as $valor) { // recorre cada elemento del vector
            if ($valor > $limite) { // verifica si el elemento es mayor al límite
                $contador++; // si lo es, aumenta el contador en uno
            }
        }
        return $contador; // devuelve la cantidad encontrada
    }

    // Devuelve las posiciones de los elementos mayores al límite (se usan para resaltarlos en la vista)
    public function posicionesMayoresA(array $vector, int $limite): array
    {
        $posiciones = []; // arreglo donde se guardarán las posiciones
        foreach ($vector as $indice => $valor) { // recorre el vector con su índice
            if ($valor > $limite) { // verifica si el elemento es mayor al límite
                $posiciones[] = $indice; // guarda la posición
            }
        }
        return $posiciones; // devuelve las posiciones encontradas
    }
}
