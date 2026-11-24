<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/EquipoDAO.php';
require_once __DIR__ . '/../../src/dao/ClienteDAO.php';
require_once __DIR__ . '/../../src/models/Equipo.php';
Auth::requireLogin();

$errores = [];
$clientes = ClienteDAO::listar();
$marcas   = EquipoDAO::listarMarcas();
$tipos    = EquipoDAO::listarTipos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $e = new Equipo();
    $e->modelo                  = trim($_POST['modelo']                  ?? '');
    $e->color                   = trim($_POST['color']                   ?? '');
    $e->numero_serie            = trim($_POST['numero_serie']            ?? '');
    $e->descripcion_condiciones = trim($_POST['descripcion_condiciones'] ?? '');
    $e->id_cliente              = (int) ($_POST['id_cliente']     ?? 0);
    $e->id_tipo_equipo          = (int) ($_POST['id_tipo_equipo'] ?? 0);
    $e->id_marca                = (int) ($_POST['id_marca']       ?? 0);

    if ($e->modelo       === '') $errores[] = 'El modelo es obligatorio.';
    if ($e->numero_serie === '') $errores[] = 'El número de serie es obligatorio.';
    if ($e->id_cliente     === 0) $errores[] = 'Selecciona un cliente.';
    if ($e->id_tipo_equipo === 0) $errores[] = 'Selecciona un tipo.';
    if ($e->id_marca       === 0) $errores[] = 'Selecciona una marca.';

    if (empty($errores)) {
        EquipoDAO::crear($e);
        header('Location: index.php?msg=Equipo+creado+correctamente');
        exit;
    }
}
$titulo = 'Nuevo equipo';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Nuevo equipo</h1>
<?php foreach ($errores as $e): ?>
  <div class="flash error"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<form method="post">
  <label>Modelo       <input type="text" name="modelo"       required></label>
  <label>Color        <input type="text" name="color"></label>
  <label>N° Serie     <input type="text" name="numero_serie" required></label>
  <label>Condiciones  <input type="text" name="descripcion_condiciones"></label>
  <label>Cliente
    <select name="id_cliente" required>
      <option value="">— Selecciona —</option>
      <?php foreach ($clientes as $c): ?>
        <option value="<?= $c->id_cliente ?>"><?= htmlspecialchars($c->nombreCompleto()) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Tipo de equipo
    <select name="id_tipo_equipo" required>
      <option value="">— Selecciona —</option>
      <?php foreach ($tipos as $t): ?>
        <option value="<?= $t['id_tipo_equipo'] ?>"><?= htmlspecialchars($t['nombre_tipo']) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Marca
    <select name="id_marca" required>
      <option value="">— Selecciona —</option>
      <?php foreach ($marcas as $m): ?>
        <option value="<?= $m['id_marca'] ?>"><?= htmlspecialchars($m['nombre_marca']) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <button class="btn">Guardar</button>
  <a href="index.php">Cancelar</a>
</form>
<?php include __DIR__ . '/../../includes/footer.php'; ?>