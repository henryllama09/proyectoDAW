<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/PiezaDAO.php';
require_once __DIR__ . '/../../src/models/Pieza.php';
Auth::requireLogin();

$errores = [];
$datos = ['nombre_pieza'=>'','descripcion'=>'','precio_unitario'=>'0.00'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($datos as $k => $_) {
        $datos[$k] = trim($_POST[$k] ?? '');
    }
    if ($datos['nombre_pieza'] === '') $errores[] = 'El nombre de la pieza es obligatorio.';
    if (!is_numeric($datos['precio_unitario']) || (float)$datos['precio_unitario'] < 0) {
        $errores[] = 'El precio debe ser un número ≥ 0.';
    }

    if (empty($errores)) {
        $p = new Pieza();
        $p->nombre_pieza    = $datos['nombre_pieza'];
        $p->descripcion     = $datos['descripcion'];
        $p->precio_unitario = (float) $datos['precio_unitario'];
        PiezaDAO::crear($p);
        header('Location: index.php?msg=Pieza+creada+correctamente');
        exit;
    }
}
$titulo = 'Nueva pieza';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Nueva pieza</h1>
<?php foreach ($errores as $e): ?>
  <div class="flash error"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<form method="post">
  <label>Nombre      <input type="text"   name="nombre_pieza" required value="<?= htmlspecialchars($datos['nombre_pieza']) ?>"></label>
  <label>Descripción <input type="text"   name="descripcion"  value="<?= htmlspecialchars($datos['descripcion']) ?>"></label>
  <label>Precio      <input type="number" name="precio_unitario" step="0.01" min="0" value="<?= htmlspecialchars($datos['precio_unitario']) ?>"></label>
  <button class="btn">Guardar</button>
  <a href="index.php">Cancelar</a>
</form>
<?php include __DIR__ . '/../../includes/footer.php'; ?>