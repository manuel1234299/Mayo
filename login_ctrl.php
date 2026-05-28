<?php
session_start();
require_once __DIR__ . '/../modelo/usuario.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['pass'] ?? '';

    // --- Validaciones del servidor ---
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Ingresá un email válido.";
    }
    if (empty($pass)) {
        $errores[] = "La contraseña es obligatoria.";
    }

    if (empty($errores)) {
        $usuario = Usuario::login($email, $pass);
        if ($usuario) {
            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_name'] = $usuario['usr_name'];
            $_SESSION['usuario_img']  = $usuario['imagen'];
            header("Location: ../vista/perfil.php");
            exit;
        } else {
            $errores[] = "Email o contraseña incorrectos.";
        }
    }
}

require_once __DIR__ . '/../vista/login.php';
?>