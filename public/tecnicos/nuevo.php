<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/TecnicoDAO.php';
require_once __DIR__ . '/../../src/models/Tecnico.php';
Auth::requireLogin();

$errores = [];
$datos = ['nombre'=>'','apellido'=>'','especialidad'=>'','telefono'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($datos as $k => $_) {
        $datos[$k] = trim($_POST[$k] ?? '');
    }
    if ($datos['nombre']   === '') $errores[] = 'El nombre es obligatorio.';
    if ($datos['apellido'] === '') $errores[] = 'El apellido es obligatorio.';

    if (empty($errores)) {
        $t = new Tecnico();
        $t->nombre       = $datos['nombre'];
        $t->apellido     = $datos['apellido'];
        $t->especialidad = $datos['especialidad'];
        $t->telefono     = $datos['telefono'];
        TecnicoDAO::crear($t);
        header('Location: index.php?msg=Técnico+creado+correctamente');
        exit;
    }
}
$titulo = 'Nuevo técnico';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Nuevo técnico</h1>
<?php foreach ($errores as $e): ?>
  <div class="flash error"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<form method="post">
  <label>Nombre       <input type="text" name="nombre" required value="<?= htmlspecialchars($datos['nombre']) ?>"></label>
  <label>Apellido     <input type="text" name="apellido" required value="<?= htmlspecialchars($datos['apellido']) ?>"></label>
  <label>Especialidad <input type="text" name="especialidad" value="<?= htmlspecialchars($datos['especialidad']) ?>"></label>
  <label>Teléfono     <input type="text" name="telefono" value="<?= htmlspecialchars($datos['telefono']) ?>"></label>
  <button class="btn">Guardar</button>
  <a href="index.php">Cancelar</a>
</form>
<?php include __DIR__ . '/../../includes/footer.php'; ?>