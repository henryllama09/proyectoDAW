<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../models/Tecnico.php';

class TecnicoDAO
{
    public static function crear(Tecnico $t): int
    {
        $stmt = Database::get()->prepare(
            'INSERT INTO TECNICO (nombre, apellido, especialidad, telefono) VALUES (?,?,?,?)'
        );
        $stmt->execute([$t->nombre, $t->apellido, $t->especialidad, $t->telefono]);
        return (int) Database::get()->lastInsertId();
    }

    public static function leer(int $id): ?Tecnico
    {
        $stmt = Database::get()->prepare('SELECT * FROM TECNICO WHERE id_tecnico = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::mapear($row) : null;
    }

    public static function listar(): array
    {
        $stmt = Database::get()->query('SELECT * FROM TECNICO ORDER BY id_tecnico');
        return array_map([self::class, 'mapear'], $stmt->fetchAll());
    }

    public static function actualizar(Tecnico $t): bool
    {
        $stmt = Database::get()->prepare(
            'UPDATE TECNICO SET nombre=?, apellido=?, especialidad=?, telefono=? WHERE id_tecnico=?'
        );
        return $stmt->execute([$t->nombre, $t->apellido, $t->especialidad, $t->telefono, $t->id_tecnico]);
    }

    public static function eliminar(int $id): bool
    {
        $stmt = Database::get()->prepare('DELETE FROM TECNICO WHERE id_tecnico = ?');
        return $stmt->execute([$id]);
    }

    private static function mapear(array $row): Tecnico
    {
        $t = new Tecnico();
        $t->id_tecnico   = (int) $row['id_tecnico'];
        $t->nombre       = $row['nombre'];
        $t->apellido     = $row['apellido'];
        $t->especialidad = $row['especialidad'] ?? '';
        $t->telefono     = $row['telefono']     ?? '';
        return $t;
    }
}