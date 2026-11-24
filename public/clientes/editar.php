<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/ClienteDAO.php';
Auth::requireLogin();

$id = (int) ($_GET['id'] ?? 0);
$cliente = ClienteDAO::leer($id);
if (!$cliente) { http_response_code(404); exit('Cliente no encontrado'); }

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente->nombre    = trim($_POST['nombre']    ?? '');
    $cliente->apellido  = trim($_POST['apellido']  ?? '');
    $cliente->telefono  = trim($_POST['telefono']  ?? '');
    $cliente->correo    = trim($_POST['correo']    ?? '');
    $cliente->direccion = trim($_POST['direccion'] ?? '');

    if ($cliente->nombre   === '') $errores[] = 'El nombre es obligatorio.';
    if ($cliente->apellido === '') $errores[] = 'El apellido es obligatorio.';

    if (empty($errores)) {
        ClienteDAO::actualizar($cliente);
        header('Location: index.php?msg=Cliente+actualizado');
        exit;
    }
}
$titulo = 'Editar cliente';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Editar cliente #<?= $cliente->id_cliente ?></h1>
<?php foreach ($errores as $e): ?>
  <div class="flash error"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<form method="post">
  <label>Nombre    <input type="text"  name="nombre"    required value="<?= htmlspecialchars($cliente->nombre) ?>"></label>
  <label>Apellido  <input type="text"  name="apellido"  required value="<?= htmlspecialchars($cliente->apellido) ?>"></label>
  <label>Teléfono  <input type="text"  name="telefono"  value="<?= htmlspecialchars($cliente->telefono) ?>"></label>
  <label>Correo    <input type="email" name="correo"    value="<?= htmlspecialchars($cliente->correo) ?>"></label>
  <label>Dirección <input type="text"  name="direccion" value="<?= htmlspecialchars($cliente->direccion) ?>"></label>
  <button class="btn">Actualizar</button>
  <a href="index.php">Cancelar</a>
</form>
<?php include __DIR__ . '/../../includes/footer.php'; ?>