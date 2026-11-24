<?php
class Cliente
{
    public ?int $id_cliente = null;
    public string $nombre    = '';
    public string $apellido  = '';
    public string $telefono  = '';
    public string $correo    = '';
    public string $direccion = '';

    public function nombreCompleto(): string
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }
}