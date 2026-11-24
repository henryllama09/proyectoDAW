<?php
// Uso: php scripts/generar_hash.php "miContraseña"
// o abre en el navegador: /proyectoDAW/scripts/generar_hash.php?p=miContraseña
$pass = $_GET['p'] ?? ($argv[1] ?? null);
if (!$pass) {
    echo "Uso: php scripts/generar_hash.php \"tu_contraseña\"\n";
    exit;
}
echo password_hash($pass, PASSWORD_BCRYPT);