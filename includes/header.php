<?php
require_once __DIR__ . '/../src/Auth.php';
$user   = Auth::user();
$titulo = $titulo ?? 'Taller DSBD';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($titulo) ?> — Taller DSBD</title>
  <style>
    * { box-sizing: border-box; }
    body { font-family: system-ui, sans-serif; max-width: 1100px; margin: 0 auto; padding: 20px; }
    nav { background: #222; color: #fff; padding: 12px 20px; margin: -20px -20px 20px; display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
    nav a { color: #fff; text-decoration: none; }
    nav a:hover { text-decoration: underline; }
    nav .spacer { flex: 1; }
    nav .user { font-size: .9em; opacity: .9; }
    table { border-collapse: collapse; width: 100%; margin-top: 15px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #eee; }
    .btn { padding: 6px 14px; background: #0066cc; color: #fff; border: none; cursor: pointer; text-decoration: none; display: inline-block; border-radius: 3px; font-size: .9em; }
    .btn:hover { background: #0055aa; }
    .btn-danger { background: #c00; }
    .btn-danger:hover { background: #a00; }
    .flash { padding: 10px; background: #cfc; margin: 10px 0; border-radius: 3px; }
    .flash.error { background: #fcc; }
    form label { display: block; margin: 10px 0; }
    form input, form select { padding: 6px; width: 320px; max-width: 100%; border: 1px solid #ccc; border-radius: 3px; }
    h1 { margin-top: 0; }
    .acciones { display: flex; gap: 5px; align-items: center; }
  </style>
</head>
<body>
<nav>
  <a href="<?= BASE_URL ?>/index.php">Inicio</a>
  <a href="<?= BASE_URL ?>/clientes/index.php">Clientes</a>
  <a href="<?= BASE_URL ?>/equipos/index.php">Equipos</a>
  <a href="<?= BASE_URL ?>/tecnicos/index.php">Técnicos</a>
  <a href="<?= BASE_URL ?>/piezas/index.php">Piezas</a>
  <span class="spacer"></span>
  <?php if ($user): ?>
    <span class="user">
      <?= htmlspecialchars($user['nombre']) ?> (<?= htmlspecialchars($user['rol']) ?>)
    </span>
    <a href="<?= BASE_URL ?>/logout.php">Cerrar sesión</a>
  <?php endif; ?>
</nav>