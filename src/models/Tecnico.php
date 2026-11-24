<?php
class Tecnico
{
    public ?int $id_tecnico = null;
    public string $nombre = '';
    public string $apellido = '';
    public string $especialidad = '';
    public string $telefono = '';

    public function nombreCompleto(): string
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }
}