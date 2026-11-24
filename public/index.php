<?php
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/Database.php';
Auth::requireLogin();

$db = Database::get();
$stats = [
    'Clientes' => (int) $db->query('SELECT COUNT(*) FROM CLIENTE')->fetchColumn(),
    'Equipos'  => (int) $db->query('SELECT COUNT(*) FROM EQUIPO')->fetchColumn(),
    'Técnicos' => (int) $db->query('SELECT COUNT(*) FROM TECNICO')->fetchColumn(),
    'Piezas'   => (int) $db->query('SELECT COUNT(*) FROM PIEZA')->fetchColumn(),
];

$titulo = 'Panel';
include __DIR__ . '/../includes/header.php';
?>
<h1>Panel del Taller</h1>
<p>Bienvenido, <b><?= htmlspecialchars(Auth::user()['nombre']) ?></b></p>

<table>
  <tr><th>Entidad</th><th>Registros</th><th>Acción</th></tr>
  <?php foreach ($stats as $nombre => $total): ?>
    <tr>
      <td><?= $nombre ?></td>
      <td><?= $total ?></td>
      <td><a class="btn" href="<?= BASE_URL ?>/<?= strtolower(str_replace(['é','í'], ['e','i'], $nombre)) ?>/index.php">Gestionar</a></td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>