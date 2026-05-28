<?php
session_start();
require_once __DIR__ . '/../modelo/publicacion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../vista/login.php");
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (empty($mensaje)) {
        $errores[] = "El mensaje no puede estar vacío.";
    } elseif (strlen($mensaje) > 500) {
        $errores[] = "El mensaje no puede superar los 500 caracteres.";
    }

    if (empty($errores)) {
        Publicacion::crear($_SESSION['usuario_id'], $mensaje);
    }
}

header("Location: ../vista/perfil.php" . (!empty($errores) ? '?error=' . urlencode($errores[0]) : ''));
exit;
?>