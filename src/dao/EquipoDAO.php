<?php
require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../models/Equipo.php';

class EquipoDAO
{
    public static function crear(Equipo $e): int
    {
        $stmt = Database::get()->prepare(
            'INSERT INTO EQUIPO (modelo, color, numero_serie, descripcion_condiciones,
                                 id_cliente, id_tipo_equipo, id_marca)
             VALUES (?,?,?,?,?,?,?)'
        );
        $stmt->execute([
            $e->modelo, $e->color, $e->numero_serie, $e->descripcion_condiciones,
            $e->id_cliente, $e->id_tipo_equipo, $e->id_marca,
        ]);
        return (int) Database::get()->lastInsertId();
    }

    public static function leer(int $id): ?Equipo
    {
        $stmt = Database::get()->prepare('SELECT * FROM EQUIPO WHERE id_equipo = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::mapear($row) : null;
    }

    public static function listarConDetalle(): array
    {
        $sql = 'SELECT e.*,
                       CONCAT(c.nombre, " ", c.apellido) AS cliente,
                       m.nombre_marca                    AS marca,
                       t.nombre_tipo                     AS tipo
                FROM EQUIPO e
                INNER JOIN CLIENTE     c ON e.id_cliente     = c.id_cliente
                INNER JOIN MARCA       m ON e.id_marca       = m.id_marca
                INNER JOIN TIPO_EQUIPO t ON e.id_tipo_equipo = t.id_tipo_equipo
                ORDER BY e.id_equipo';
        return Database::get()->query($sql)->fetchAll();
    }

    public static function actualizar(Equipo $e): bool
    {
        $stmt = Database::get()->prepare(
            'UPDATE EQUIPO SET modelo=?, color=?, numero_serie=?, descripcion_condiciones=?,
                               id_cliente=?, id_tipo_equipo=?, id_marca=?
             WHERE id_equipo=?'
        );
        return $stmt->execute([
            $e->modelo, $e->color, $e->numero_serie, $e->descripcion_condiciones,
            $e->id_cliente, $e->id_tipo_equipo, $e->id_marca, $e->id_equipo,
        ]);
    }

    public static function eliminar(int $id): bool
    {
        $stmt = Database::get()->prepare('DELETE FROM EQUIPO WHERE id_equipo = ?');
        return $stmt->execute([$id]);
    }

    public static function listarMarcas(): array
    {
        return Database::get()->query('SELECT * FROM MARCA ORDER BY nombre_marca')->fetchAll();
    }

    public static function listarTipos(): array
    {
        return Database::get()->query('SELECT * FROM TIPO_EQUIPO ORDER BY nombre_tipo')->fetchAll();
    }

    private static function mapear(array $row): Equipo
    {
        $e = new Equipo();
        $e->id_equipo               = (int) $row['id_equipo'];
        $e->modelo                  = $row['modelo'];
        $e->color                   = $row['color']                   ?? '';
        $e->numero_serie            = $row['numero_serie'];
        $e->descripcion_condiciones = $row['descripcion_condiciones'] ?? '';
        $e->id_cliente              = (int) $row['id_cliente'];
        $e->id_tipo_equipo          = (int) $row['id_tipo_equipo'];
        $e->id_marca                = (int) $row['id_marca'];
        return $e;
    }
}