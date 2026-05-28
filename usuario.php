<?php
require_once __DIR__ . '/conexion.php';
 
class usuario {
 
    public static function registrar($nombre, $email, $pass, $imagen) {
        $conn = conectar();
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuario (usr_name, usr_email, usr_pass, imagen) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $pass_hash, $imagen);
        $resultado = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $resultado;
    }
 
    public static function login($email, $pass) {
        $conn = conectar();
        $stmt = $conn->prepare("SELECT * FROM usuario WHERE usr_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
 
        if ($usuario && password_verify($pass, $usuario['usr_pass'])) {
            return $usuario;
        }
        return false;
    }
 
    public static function obtenerTodos() {
        $conn = conectar();
        $result = $conn->query("SELECT id, usr_name, usr_email, imagen FROM usuario ORDER BY usr_name ASC");
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        $conn->close();
        return $usuarios;
    }
 
    public static function obtenerPorId($id) {
        $conn = conectar();
        $stmt = $conn->prepare("SELECT id, usr_name, usr_email, imagen FROM usuario WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $usuario;
    }
 
    public static function emailExiste($email) {
        $conn = conectar();
        $stmt = $conn->prepare("SELECT id FROM usuario WHERE usr_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $existe = $result->num_rows > 0;
        $stmt->close();
        $conn->close();
        return $existe;
    }
}
?>
 