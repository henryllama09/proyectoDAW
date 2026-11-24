<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('America/Merida');

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');     // XAMPP: 3306 · Docker: 3307
define('DB_NAME', getenv('DB_NAME') ?: 'taller');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : ''); // XAMPP root: vacío

if (!defined('BASE_URL')) {
    $env = getenv('BASE_URL');
    if ($env !== false && $env !== '') {
        define('BASE_URL', rtrim($env, '/'));
    } else {
        $sn  = $_SERVER['SCRIPT_NAME'] ?? '';
        $pos = strpos($sn, '/public/');
        define('BASE_URL', $pos !== false ? substr($sn, 0, $pos + 7) : '');
    }
}