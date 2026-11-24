<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/EquipoDAO.php';
Auth::requireLogin();

$equipos = EquipoDAO::listarConDetalle();
$msg = $_GET['msg'] ?? null;
$err = $_GET['err'] ?? null;
$titulo = 'Equipos';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Equipos</h1>
<?php if ($msg): ?><div class="flash"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="flash error"><?= htmlspecialchars($err) ?></div><?php endif; ?>
<a class="btn" href="nuevo.php">+ Nuevo equipo</a>
<table>
  <tr><th>ID</th><th>Marca / Modelo</th><th>N° Serie</th><th>Cliente</th><th>Tipo</th><th>Acciones</th></tr>
  <?php foreach ($equipos as $e): ?>
    <tr>
      <td><?= $e['id_equipo'] ?></td>
      <td><?= htmlspecialchars($e['marca'] . ' ' . $e['modelo']) ?></td>
      <td><?= htmlspecialchars($e['numero_serie']) ?></td>
      <td><?= htmlspecialchars($e['cliente']) ?></td>
      <td><?= htmlspecialchars($e['tipo']) ?></td>
      <td>
        <div class="acciones">
          <a class="btn" href="editar.php?id=<?= $e['id_equipo'] ?>">Editar</a>
          <form method="post" action="eliminar.php"
                onsubmit="return confirm('¿Eliminar equipo #<?= $e['id_equipo'] ?>?')">
            <input type="hidden" name="id" value="<?= $e['id_equipo'] ?>">
            <button class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include __DIR__ . '/../../includes/footer.php'; ?>