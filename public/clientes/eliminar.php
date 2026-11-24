<?php
require_once __DIR__ . '/../../src/Auth.php';
require_once __DIR__ . '/../../src/dao/ClienteDAO.php';
Auth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método no permitido'); }

$id = (int) ($_POST['id'] ?? 0);
if ($id <= 0) { header('Location: index.php'); exit; }

try {
    ClienteDAO::eliminar($id);
    header('Location: index.php?msg=Cliente+eliminado');
} catch (PDOException $e) {
    header('Location: index.php?err=No+se+puede+eliminar:+cliente+tiene+equipos+asociados');
}
exit;