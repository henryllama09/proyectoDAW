<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/PiezaDAO.php';
Auth::requireLogin();

$piezas = PiezaDAO::listar();
$msg = $_GET['msg'] ?? null;
$err = $_GET['err'] ?? null;
$titulo = 'Piezas';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Piezas</h1>
<?php if ($msg): ?><div class="flash"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="flash error"><?= htmlspecialchars($err) ?></div><?php endif; ?>
<a class="btn" href="nuevo.php">+ Nueva pieza</a>
<table>
  <tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Acciones</th></tr>
  <?php foreach ($piezas as $p): ?>
    <tr>
      <td><?= $p->id_pieza ?></td>
      <td><?= htmlspecialchars($p->nombre_pieza) ?></td>
      <td><?= htmlspecialchars($p->descripcion) ?></td>
      <td>$<?= number_format($p->precio_unitario, 2) ?></td>
      <td>
        <div class="acciones">
          <a class="btn" href="editar.php?id=<?= $p->id_pieza ?>">Editar</a>
          <form method="post" action="eliminar.php"
                onsubmit="return confirm('¿Eliminar pieza #<?= $p->id_pieza ?>?')">
            <input type="hidden" name="id" value="<?= $p->id_pieza ?>">
            <button class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include __DIR__ . '/../../includes/footer.php'; ?>