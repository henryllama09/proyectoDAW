<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../models/Pieza.php';

class PiezaDAO
{
    public static function crear(Pieza $p): int
    {
        $stmt = Database::get()->prepare(
            'INSERT INTO PIEZA (nombre_pieza, descripcion, precio_unitario) VALUES (?,?,?)'
        );
        $stmt->execute([$p->nombre_pieza, $p->descripcion, $p->precio_unitario]);
        return (int) Database::get()->lastInsertId();
    }

    public static function leer(int $id): ?Pieza
    {
        $stmt = Database::get()->prepare('SELECT * FROM PIEZA WHERE id_pieza = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::mapear($row) : null;
    }

    public static function listar(): array
    {
        $stmt = Database::get()->query('SELECT * FROM PIEZA ORDER BY id_pieza');
        return array_map([self::class, 'mapear'], $stmt->fetchAll());
    }

    public static function actualizar(Pieza $p): bool
    {
        $stmt = Database::get()->prepare(
            'UPDATE PIEZA SET nombre_pieza=?, descripcion=?, precio_unitario=? WHERE id_pieza=?'
        );
        return $stmt->execute([$p->nombre_pieza, $p->descripcion, $p->precio_unitario, $p->id_pieza]);
    }

    public static function eliminar(int $id): bool
    {
        $stmt = Database::get()->prepare('DELETE FROM PIEZA WHERE id_pieza = ?');
        return $stmt->execute([$id]);
    }

    private static function mapear(array $row): Pieza
    {
        $p = new Pieza();
        $p->id_pieza        = (int) $row['id_pieza'];
        $p->nombre_pieza    = $row['nombre_pieza'];
        $p->descripcion     = $row['descripcion']     ?? '';
        $p->precio_unitario = (float) $row['precio_unitario'];
        return $p;
    }
}