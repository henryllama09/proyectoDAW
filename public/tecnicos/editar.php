<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/TecnicoDAO.php';
Auth::requireLogin();

$id = (int) ($_GET['id'] ?? 0);
$tecnico = TecnicoDAO::leer($id);
if (!$tecnico) { http_response_code(404); exit('Técnico no encontrado'); }

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tecnico->nombre       = trim($_POST['nombre']       ?? '');
    $tecnico->apellido     = trim($_POST['apellido']     ?? '');
    $tecnico->especialidad = trim($_POST['especialidad'] ?? '');
    $tecnico->telefono     = trim($_POST['telefono']     ?? '');

    if ($tecnico->nombre   === '') $errores[] = 'El nombre es obligatorio.';
    if ($tecnico->apellido === '') $errores[] = 'El apellido es obligatorio.';

    if (empty($errores)) {
        TecnicoDAO::actualizar($tecnico);
        header('Location: index.php?msg=Técnico+actualizado');
        exit;
    }
}
$titulo = 'Editar técnico';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Editar técnico #<?= $tecnico->id_tecnico ?></h1>
<?php foreach ($errores as $e): ?>
  <div class="flash error"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<form method="post">
  <label>Nombre       <input type="text" name="nombre"       required value="<?= htmlspecialchars($tecnico->nombre) ?>"></label>
  <label>Apellido     <input type="text" name="apellido"     required value="<?= htmlspecialchars($tecnico->apellido) ?>"></label>
  <label>Especialidad <input type="text" name="especialidad" value="<?= htmlspecialchars($tecnico->especialidad) ?>"></label>
  <label>Teléfono     <input type="text" name="telefono"     value="<?= htmlspecialchars($tecnico->telefono) ?>"></label>
  <button class="btn">Actualizar</button>
  <a href="index.php">Cancelar</a>
</form>
<?php include __DIR__ . '/../../includes/footer.php'; ?>