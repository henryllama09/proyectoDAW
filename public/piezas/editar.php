<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/PiezaDAO.php';
Auth::requireLogin();

$id = (int) ($_GET['id'] ?? 0);
$pieza = PiezaDAO::leer($id);
if (!$pieza) { http_response_code(404); exit('Pieza no encontrada'); }

$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pieza->nombre_pieza = trim($_POST['nombre_pieza'] ?? '');
    $pieza->descripcion  = trim($_POST['descripcion']  ?? '');
    $precioStr = trim($_POST['precio_unitario'] ?? '0');

    if ($pieza->nombre_pieza === '') $errores[] = 'El nombre de la pieza es obligatorio.';
    if (!is_numeric($precioStr) || (float)$precioStr < 0) {
        $errores[] = 'El precio debe ser un número ≥ 0.';
    } else {
        $pieza->precio_unitario = (float) $precioStr;
    }

    if (empty($errores)) {
        PiezaDAO::actualizar($pieza);
        header('Location: index.php?msg=Pieza+actualizada');
        exit;
    }
}
$titulo = 'Editar pieza';
include __DIR__ . '/../../includes/header.php';
?>
<h1>Editar pieza #<?= $pieza->id_pieza ?></h1>
<?php foreach ($errores as $e): ?>
  <div class="flash error"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>
<form method="post">
  <label>Nombre      <input type="text"   name="nombre_pieza" required value="<?= htmlspecialchars($pieza->nombre_pieza) ?>"></label>
  <label>Descripción <input type="text"   name="descripcion"  value="<?= htmlspecialchars($pieza->descripcion) ?>"></label>
  <label>Precio      <input type="number" name="precio_unitario" step="0.01" min="0" value="<?= htmlspecialchars(number_format($pieza->precio_unitario, 2, '.', '')) ?>"></label>
  <button class="btn">Actualizar</button>
  <a href="index.php">Cancelar</a>
</form>
<?php include __DIR__ . '/../../includes/footer.php'; ?>