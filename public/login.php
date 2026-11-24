<?php
require_once __DIR__ . '/../src/Auth.php';

if (Auth::check()) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    if (Auth::login($u, $p)) {
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
    $error = 'Usuario o contraseña incorrectos';
}
$titulo = 'Iniciar sesión';
include __DIR__ . '/../includes/header.php';
?>
<h1>Iniciar sesión</h1>
<?php if ($error): ?>
  <div class="flash error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post">
  <label>Usuario    <input type="text"     name="username" required autofocus></label>
  <label>Contraseña <input type="password" name="password" required></label>
  <button class="btn">Entrar</button>
</form>
<p><small>Demo: <b>admin</b> / <b>password</b></small></p>
<?php include __DIR__ . '/../includes/footer.php'; ?>