<?php
// Registro Operario: agrupa en un solo tipo de dato la información de un trabajador

class Operario // declara el tipo de dato definido por el usuario
{
    public int $grado = 0; // grado de eficiencia, se calcula después con el modelo

    public function __construct(
        public string $codigo,       // código del trabajador
        public float $horasAusencia, // horas de ausencia en el periodo
        public int $defectuosos,     // pupitres defectuosos
        public int $producidos       // pupitres producidos
    ) {
    }
}
