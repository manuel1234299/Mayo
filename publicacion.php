<?php
require_once __DIR__ . '/conexion.php';

class publicacion {

    public static function crear($usuario_id, $mensaje) {
        $conn = conectar();
        $stmt = $conn->prepare("INSERT INTO publicacion (usuario_id, mensaje) VALUES (?, ?)");
        $stmt->bind_param("is", $usuario_id, $mensaje);
        $resultado = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $resultado;
    }

    public static function obtenerPorUsuario($usuario_id) {
        $conn = conectar();
        $stmt = $conn->prepare("SELECT * FROM publicacion WHERE usuario_id = ? ORDER BY fecha DESC");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $publicaciones = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conn->close();
        return $publicaciones;
    }
}
?>