<?php
// Registro Medicamento: agrupa en un solo tipo de dato la información de un medicamento

class Medicamento // declara el tipo de dato definido por el usuario
{
    public function __construct(
        public string $nombre,         // nombre del medicamento
        public int $stockActual,       // unidades disponibles
        public int $stockMinimo,       // unidades mínimas que se deben tener
        public float $precioUnitario   // precio de cada unidad
    ) {
    }
}
