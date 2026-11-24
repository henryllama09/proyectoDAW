<?php
require_once __DIR__ . '/Database.php';

class Auth
{
    public static function login(string $username, string $password): bool
    {
        $stmt = Database::get()->prepare(
            'SELECT * FROM USUARIO WHERE username = ? AND activo = 1'
        );
        $stmt->execute([$username]);
        $u = $stmt->fetch();
        if (!$u || !password_verify($password, $u['password_hash'])) {
            return false;
        }
        session_regenerate_id(true);
        $_SESSION['usuario'] = [
            'id'       => (int) $u['id_usuario'],
            'username' => $u['username'],
            'nombre'   => $u['nombre_completo'],
            'rol'      => $u['rol'],
        ];
        return true;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    public static function user(): ?array
    {
        return $_SESSION['usuario'] ?? null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['usuario']);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/login.php');
            exit;
        }
    }
}