<?php
// Modelo del Ejercicio 3: funciones para registrar empleados y buscarlos por código

require_once __DIR__ . '/Empleado.php'; // incluye el registro Empleado

class Ejercicio03Model // declara la clase del modelo
{
    // Crea el arreglo de empleados a partir de los arreglos de códigos y nombres del formulario
    public function crearEmpleados(array $codigos, array $nombres): array
    {
        $empleados = []; // arreglo vacío donde se guardarán los registros
        for ($i = 0; $i < count($codigos); $i++) { // recorre cada posición de los arreglos
            $codigo = trim((string) $codigos[$i]); // limpia el código de la posición i
            $nombre = trim((string) ($nombres[$i] ?? '')); // limpia el nombre de la posición i
            $empleados[] = new Empleado($codigo, $nombre); // crea el registro y lo agrega al arreglo
        }
        return $empleados; // devuelve el arreglo de empleados
    }

    // Revisa si hay códigos repetidos; devuelve el primer código repetido o null si no hay
    public function codigoRepetido(array $empleados): ?string
    {
        for ($i = 0; $i < count($empleados); $i++) { // recorre cada empleado
            for ($j = $i + 1; $j < count($empleados); $j++) { // lo compara con los empleados que están después
                if ($empleados[$i]->codigo === $empleados[$j]->codigo) { // si los códigos son iguales
                    return $empleados[$i]->codigo; // devuelve el código repetido
                }
            }
        }
        return null; // si no encontró repetidos, devuelve null
    }

    // Busca en el arreglo el empleado que tenga el código indicado (búsqueda secuencial)
    public function buscarPorCodigo(array $empleados, string $codigo): ?Empleado
    {
        foreach ($empleados as $empleado) { // recorre cada registro del arreglo
            if ($empleado->codigo === $codigo) { // compara el código del registro con el buscado
                return $empleado; // si coincide, devuelve el empleado encontrado
            }
        }
        return null; // si terminó el recorrido sin encontrarlo, devuelve null
    }
}
