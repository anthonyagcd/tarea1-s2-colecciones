<?php
// Modelo del Ejercicio 9: funciones para controlar el inventario de medicamentos

require_once __DIR__ . '/Medicamento.php'; // incluye el registro Medicamento

class Ejercicio09Model // declara la clase del modelo
{
    // Verifica si ya existe un medicamento con el mismo nombre (sin importar mayúsculas)
    public function existeNombre(array $medicamentos, string $nombre): bool
    {
        foreach ($medicamentos as $medicamento) { // recorre la lista de medicamentos
            if (mb_strtolower($medicamento->nombre) === mb_strtolower($nombre)) { // compara los nombres en minúsculas
                return true; // el nombre ya existe
            }
        }
        return false; // el nombre no existe
    }

    // Indica si un medicamento tiene el stock actual por debajo del stock mínimo
    public function estaBajoMinimo(Medicamento $medicamento): bool
    {
        return $medicamento->stockActual < $medicamento->stockMinimo; // compara el stock actual con el mínimo
    }

    // Literal b: devuelve los medicamentos cuyo stock actual está por debajo del stock mínimo
    public function bajoStockMinimo(array $medicamentos): array
    {
        $bajos = []; // lista vacía de medicamentos con stock bajo
        foreach ($medicamentos as $medicamento) { // recorre la lista de medicamentos
            if ($this->estaBajoMinimo($medicamento)) { // si el stock actual es menor al mínimo
                $bajos[] = $medicamento; // lo agrega a la lista de stock bajo
            }
        }
        return $bajos; // devuelve la lista de medicamentos con stock bajo
    }

    // Unidades que faltan para llegar al stock mínimo
    public function unidadesFaltantes(Medicamento $medicamento): int
    {
        return max(0, $medicamento->stockMinimo - $medicamento->stockActual); // resta y evita valores negativos
    }

    // Valor económico de un medicamento: stock actual x precio unitario
    public function valorMedicamento(Medicamento $medicamento): float
    {
        return $medicamento->stockActual * $medicamento->precioUnitario; // multiplica unidades por precio
    }

    // Literal c: valor económico total del inventario (suma del valor de cada medicamento)
    public function valorTotalInventario(array $medicamentos): float
    {
        $total = 0; // acumulador del valor total
        foreach ($medicamentos as $medicamento) { // recorre la lista de medicamentos
            $total += $this->valorMedicamento($medicamento); // suma el valor del medicamento
        }
        return $total; // devuelve el valor total del inventario
    }

    // Literal d: descuenta del stock la cantidad vendida; devuelve false si no hay unidades suficientes
    public function registrarVenta(Medicamento $medicamento, int $cantidad): bool
    {
        if ($cantidad > $medicamento->stockActual) { // si se quiere vender más de lo que hay
            return false; // no se puede realizar la venta
        }
        $medicamento->stockActual -= $cantidad; // resta la cantidad vendida del stock
        return true; // la venta se realizó
    }

    // Lista de medicamentos de ejemplo para probar el programa rápidamente
    public function datosEjemplo(): array
    {
        return [ // devuelve un arreglo de registros Medicamento
            new Medicamento('Paracetamol 500 mg', 120, 50, 0.15),
            new Medicamento('Ibuprofeno 400 mg', 30, 40, 0.25),
            new Medicamento('Amoxicilina 500 mg', 18, 25, 0.60),
            new Medicamento('Loratadina 10 mg', 75, 20, 0.35),
            new Medicamento('Omeprazol 20 mg', 60, 30, 0.40),
        ];
    }
}
