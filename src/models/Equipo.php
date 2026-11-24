<?php
class Equipo
{
    public ?int $id_equipo = null;
    public string $modelo = '';
    public string $color = '';
    public string $numero_serie = '';
    public string $descripcion_condiciones = '';
    public int $id_cliente = 0;
    public int $id_tipo_equipo = 0;
    public int $id_marca = 0;
}