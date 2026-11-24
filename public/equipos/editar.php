<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/EquipoDAO.php';
require_once __DIR__ . '/../../src/dao/ClienteDAO.php';
Auth::requireLogin();

$id = (int) ($_GET['id'] ?? 0);
$equipo = EquipoDAO::leer($id);
if (!$equipo) { http_response_code(404); exit('Equipo no encontrado'); }

$clientes = ClienteDAO::listar();
$marcas   = EquipoDAO::listarMarcas();
$tipos    = EquipoDAO::listarTipos();
$errores  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipo->modelo                  = trim($_POST['modelo']                  ?? '');
    $equipo->color                   = trim($_POST['color']                   ?? '');
    $equipo->numero_serie            = trim($_POST['numero_serie']            ?? '');
    $equipo->descripcion_condiciones = trim($_POST['descripcion_condiciones'] ?? '');
    $equipo->id_cliente              = (int) ($_POST['id_cliente']     ?? 0);
    $equipo->id_tipo_equipo          = (int) ($_POST['id_tipo_equipo'] ?? 0);
    $equipo->id_marca                = (int) ($_POST['id_marca']       ?? 0);

    if ($equipo->modelo       === '') $errores[] = 'El modelo es obligatorio.';
    if ($equipo->numero_serie === '') $errores[] = 'El número de serie es obligatorio.';

    if (empty($errores)) {
        EquipoDAO::actualizar($equipo);
        header('Location: index.php?msg=Equipo+actualizado');
        exit;
    }
}
$titulo = 'Editar equipo';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Editar equipo #<?= $equipo->id_equipo ?></h1>
<?php foreach ($errores as $e): ?>
  <div class="flash error"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<form method="post">
  <label>Modelo      <input type="text" name="modelo"       required value="<?= htmlspecialchars($equipo->modelo) ?>"></label>
  <label>Color       <input type="text" name="color"                value="<?= htmlspecialchars($equipo->color) ?>"></label>
  <label>N° Serie    <input type="text" name="numero_serie" required value="<?= htmlspecialchars($equipo->numero_serie) ?>"></label>
  <label>Condiciones <input type="text" name="descripcion_condiciones" value="<?= htmlspecialchars($equipo->descripcion_condiciones) ?>"></label>
  <label>Cliente
    <select name="id_cliente" required>
      <?php foreach ($clientes as $c): ?>
        <option value="<?= $c->id_cliente ?>" <?= $c->id_cliente === $equipo->id_cliente ? 'selected' : '' ?>>
          <?= htmlspecialchars($c->nombreCompleto()) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Tipo
    <select name="id_tipo_equipo" required>
      <?php foreach ($tipos as $t): ?>
        <option value="<?= $t['id_tipo_equipo'] ?>" <?= (int)$t['id_tipo_equipo'] === $equipo->id_tipo_equipo ? 'selected' : '' ?>>
          <?= htmlspecialchars($t['nombre_tipo']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Marca
    <select name="id_marca" required>
      <?php foreach ($marcas as $m): ?>
        <option value="<?= $m['id_marca'] ?>" <?= (int)$m['id_marca'] === $equipo->id_marca ? 'selected' : '' ?>>
          <?= htmlspecialchars($m['nombre_marca']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>
  <button class="btn">Actualizar</button>
  <a href="index.php">Cancelar</a>
</form>
<?php include __DIR__ . '/../../includes/footer.php'; ?>