<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/TecnicoDAO.php';
Auth::requireLogin();

$tecnicos = TecnicoDAO::listar();
$msg = $_GET['msg'] ?? null;
$err = $_GET['err'] ?? null;
$titulo = 'Técnicos';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Técnicos</h1>
<?php if ($msg): ?><div class="flash"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="flash error"><?= htmlspecialchars($err) ?></div><?php endif; ?>
<a class="btn" href="nuevo.php">+ Nuevo técnico</a>
<table>
  <tr><th>ID</th><th>Nombre</th><th>Especialidad</th><th>Teléfono</th><th>Acciones</th></tr>
  <?php foreach ($tecnicos as $t): ?>
    <tr>
      <td><?= $t->id_tecnico ?></td>
      <td><?= htmlspecialchars($t->nombreCompleto()) ?></td>
      <td><?= htmlspecialchars($t->especialidad) ?></td>
      <td><?= htmlspecialchars($t->telefono) ?></td>
      <td>
        <div class="acciones">
          <a class="btn" href="editar.php?id=<?= $t->id_tecnico ?>">Editar</a>
          <form method="post" action="eliminar.php"
                onsubmit="return confirm('¿Eliminar técnico #<?= $t->id_tecnico ?>?')">
            <input type="hidden" name="id" value="<?= $t->id_tecnico ?>">
            <button class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include __DIR__ . '/../../includes/footer.php'; ?>