<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteDAO
{
    public static function crear(Cliente $c): int
    {
        $stmt = Database::get()->prepare(
            'INSERT INTO CLIENTE (nombre, apellido, telefono, correo, direccion) VALUES (?,?,?,?,?)'
        );
        $stmt->execute([$c->nombre, $c->apellido, $c->telefono, $c->correo, $c->direccion]);
        return (int) Database::get()->lastInsertId();
    }

    public static function leer(int $id): ?Cliente
    {
        $stmt = Database::get()->prepare('SELECT * FROM CLIENTE WHERE id_cliente = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::mapear($row) : null;
    }

    public static function listar(): array
    {
        $stmt = Database::get()->query('SELECT * FROM CLIENTE ORDER BY id_cliente');
        return array_map([self::class, 'mapear'], $stmt->fetchAll());
    }

    public static function actualizar(Cliente $c): bool
    {
        $stmt = Database::get()->prepare(
            'UPDATE CLIENTE SET nombre=?, apellido=?, telefono=?, correo=?, direccion=? WHERE id_cliente=?'
        );
        return $stmt->execute([
            $c->nombre, $c->apellido, $c->telefono, $c->correo, $c->direccion, $c->id_cliente,
        ]);
    }

    public static function eliminar(int $id): bool
    {
        $stmt = Database::get()->prepare('DELETE FROM CLIENTE WHERE id_cliente = ?');
        return $stmt->execute([$id]);
    }

    private static function mapear(array $row): Cliente
    {
        $c = new Cliente();
        $c->id_cliente = (int) $row['id_cliente'];
        $c->nombre     = $row['nombre'];
        $c->apellido   = $row['apellido'];
        $c->telefono   = $row['telefono']  ?? '';
        $c->correo     = $row['correo']    ?? '';
        $c->direccion  = $row['direccion'] ?? '';
        return $c;
    }
}