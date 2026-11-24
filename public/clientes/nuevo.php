<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/ClienteDAO.php';
require_once __DIR__ . '/../../src/models/Cliente.php';
Auth::requireLogin();

$errores = [];
$datos = ['nombre'=>'','apellido'=>'','telefono'=>'','correo'=>'','direccion'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($datos as $k => $_) {
        $datos[$k] = trim($_POST[$k] ?? '');
    }
    if ($datos['nombre']   === '') $errores[] = 'El nombre es obligatorio.';
    if ($datos['apellido'] === '') $errores[] = 'El apellido es obligatorio.';

    if (empty($errores)) {
        $c = new Cliente();
        $c->nombre    = $datos['nombre'];
        $c->apellido  = $datos['apellido'];
        $c->telefono  = $datos['telefono'];
        $c->correo    = $datos['correo'];
        $c->direccion = $datos['direccion'];
        ClienteDAO::crear($c);
        header('Location: index.php?msg=Cliente+creado+correctamente');
        exit;
    }
}
$titulo = 'Nuevo cliente';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Nuevo cliente</h1>
<?php foreach ($errores as $e): ?>
  <div class="flash error"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<form method="post">
  <label>Nombre    <input type="text"  name="nombre"    required value="<?= htmlspecialchars($datos['nombre']) ?>"></label>
  <label>Apellido  <input type="text"  name="apellido"  required value="<?= htmlspecialchars($datos['apellido']) ?>"></label>
  <label>Teléfono  <input type="text"  name="telefono"  value="<?= htmlspecialchars($datos['telefono']) ?>"></label>
  <label>Correo    <input type="email" name="correo"    value="<?= htmlspecialchars($datos['correo']) ?>"></label>
  <label>Dirección <input type="text"  name="direccion" value="<?= htmlspecialchars($datos['direccion']) ?>"></label>
  <button class="btn">Guardar</button>
  <a href="index.php">Cancelar</a>
</form>
<?php include __DIR__ . '/../../includes/footer.php'; ?>