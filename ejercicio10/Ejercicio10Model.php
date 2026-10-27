<?php
// Modelo del Ejercicio 10: funciones para calcular totales, descuentos e ingresos de los pedidos

require_once __DIR__ . '/Pedido.php'; // incluye el registro Pedido

class Ejercicio10Model // declara la clase del modelo
{
    public const LIMITE_DESCUENTO = 50;  // el descuento aplica si el pedido supera los 50 USD
    public const PORCENTAJE = 0.10;      // porcentaje de descuento: 10 %

    // Calcula el valor del pedido antes del descuento: cantidad x precio unitario
    public function subtotal(Pedido $pedido): float
    {
        return $pedido->cantidad * $pedido->precioUnitario; // multiplica la cantidad por el precio
    }

    // Literal c: calcula el descuento del 10 % si el subtotal supera los 50 USD
    public function descuento(Pedido $pedido): float
    {
        $subtotal = $this->subtotal($pedido); // obtiene el subtotal del pedido
        if ($subtotal > self::LIMITE_DESCUENTO) { // si el pedido supera los 50 USD
            return $subtotal * self::PORCENTAJE; // devuelve el 10 % del subtotal
        }
        return 0; // si no supera el límite, no hay descuento
    }

    // Literal b: total a pagar por el pedido (subtotal menos descuento)
    public function totalAPagar(Pedido $pedido): float
    {
        return $this->subtotal($pedido) - $this->descuento($pedido); // resta el descuento al subtotal
    }

    // Literal d: ingreso total del restaurante (suma del total a pagar de cada pedido)
    public function ingresoTotal(array $pedidos): float
    {
        $total = 0; // acumulador del ingreso
        foreach ($pedidos as $pedido) { // recorre la lista de pedidos
            $total += $this->totalAPagar($pedido); // suma el total a pagar del pedido
        }
        return $total; // devuelve el ingreso total
    }

    // Literal e: posición del pedido de mayor valor; devuelve -1 si la lista está vacía
    public function indicePedidoMayor(array $pedidos): int
    {
        $indiceMayor = -1; // todavía no hay un pedido mayor
        $valorMayor = -1;  // valor del pedido mayor encontrado hasta ahora
        foreach ($pedidos as $indice => $pedido) { // recorre la lista de pedidos
            $total = $this->totalAPagar($pedido); // calcula el total del pedido actual
            if ($total > $valorMayor) { // si es mayor que el mayor encontrado
                $valorMayor = $total; // actualiza el valor mayor
                $indiceMayor = $indice; // guarda la posición del pedido
            }
        }
        return $indiceMayor; // devuelve la posición del pedido de mayor valor
    }

    // Lista de pedidos de ejemplo para probar el programa rápidamente
    public function datosEjemplo(): array
    {
        return [ // devuelve un arreglo de registros Pedido
            new Pedido('Ana Torres', 'Encebollado', 3, 6.50),
            new Pedido('Luis Mena', 'Seco de pollo', 5, 12.00),
            new Pedido('María Ruiz', 'Ceviche de camarón', 2, 9.75),
            new Pedido('Carlos Vega', 'Parrillada familiar', 2, 32.00),
            new Pedido('Sofía León', 'Jugo natural', 4, 2.25),
        ];
    }
}
