<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/ClienteDAO.php';
Auth::requireLogin();

$clientes = ClienteDAO::listar();
$msg = $_GET['msg'] ?? null;
$err = $_GET['err'] ?? null;
$titulo = 'Clientes';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Clientes</h1>
<?php if ($msg): ?><div class="flash"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="flash error"><?= htmlspecialchars($err) ?></div><?php endif; ?>
<a class="btn" href="nuevo.php">+ Nuevo cliente</a>
<table>
  <tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Dirección</th><th>Acciones</th></tr>
  <?php foreach ($clientes as $c): ?>
    <tr>
      <td><?= $c->id_cliente ?></td>
      <td><?= htmlspecialchars($c->nombreCompleto()) ?></td>
      <td><?= htmlspecialchars($c->telefono) ?></td>
      <td><?= htmlspecialchars($c->correo) ?></td>
      <td><?= htmlspecialchars($c->direccion) ?></td>
      <td>
        <div class="acciones">
          <a class="btn" href="editar.php?id=<?= $c->id_cliente ?>">Editar</a>
          <form method="post" action="eliminar.php"
                onsubmit="return confirm('¿Eliminar cliente #<?= $c->id_cliente ?>?')">
            <input type="hidden" name="id" value="<?= $c->id_cliente ?>">
            <button class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include __DIR__ . '/../../includes/footer.php'; ?>