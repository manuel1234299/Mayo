-- Ejecutar este script en phpMyAdmin o MySQL
CREATE DATABASE IF NOT EXISTS base_usuarios;

CREATE TABLE IF NOT EXISTS base_usuarios.usuario (
    id INT(11) NOT NULL AUTO_INCREMENT,
    usr_name VARCHAR(100) NOT NULL,
    usr_email VARCHAR(100) UNIQUE NOT NULL,
    usr_pass VARCHAR(100) NOT NULL,
    imagen VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS base_usuarios.publicacion (
    id INT(11) NOT NULL AUTO_INCREMENT,
    usuario_id INT(11) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
);