<?php
// Registro Pedido: agrupa en un solo tipo de dato la información de un pedido

class Pedido // declara el tipo de dato definido por el usuario
{
    public function __construct(
        public string $cliente,        // nombre del cliente
        public string $plato,          // plato solicitado
        public int $cantidad,          // cantidad de platos
        public float $precioUnitario   // precio de cada plato
    ) {
    }
}
