<?php
session_start();
require_once __DIR__ . '/../modelo/usuario.php';

$errores = [];
$datos = ['nombre' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $pass      = $_POST['pass'] ?? '';
    $pass_conf = $_POST['pass_conf'] ?? '';
    $imagen    = null;

    // --- Validaciones del servidor ---
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    }
    if (strlen($pass) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres.";
    }
    if ($pass !== $pass_conf) {
        $errores[] = "Las contraseñas no coinciden.";
    }
    if (Usuario::emailExiste($email)) {
        $errores[] = "El email ya está registrado.";
    }

    // --- Manejo de imagen de perfil ---
    if (!empty($_FILES['imagen']['name'])) {
        $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $ext_permitidas)) {
            $errores[] = "Solo se permiten imágenes (jpg, png, gif, webp).";
        } elseif ($_FILES['imagen']['size'] > 2 * 1024 * 1024) {
            $errores[] = "La imagen no debe superar 2 MB.";
        } else {
            $nombre_imagen = uniqid('img_') . '.' . $ext;
            $destino = __DIR__ . '/../uploads/' . $nombre_imagen;
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                $errores[] = "Error al subir la imagen.";
            } else {
                $imagen = $nombre_imagen;
            }
        }
    }

    if (empty($errores)) {
        if (Usuario::registrar($nombre, $email, $pass, $imagen)) {
            $_SESSION['registro_ok'] = "¡Registro exitoso! Ya podés iniciar sesión.";
            header("Location: ../vista/login.php");
            exit;
        } else {
            $errores[] = "Error al registrar. Intentá de nuevo.";
        }
    }

    $datos = ['nombre' => htmlspecialchars($nombre), 'email' => htmlspecialchars($email)];
}

// Pasar datos y errores a la vista
require_once __DIR__ . '/../vista/registro.php';
?>