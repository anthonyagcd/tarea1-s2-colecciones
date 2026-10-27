<?php
// Registro Empleado: agrupa en un solo tipo de dato el código y el nombre de un empleado

class Empleado // declara el tipo de dato definido por el usuario
{
    public function __construct(
        public string $codigo, // código del empleado
        public string $nombre  // nombre del empleado
    ) {
    }
}
