<?php
/**
 * Script de Actualización de la Base de Datos (1)
 *
 * Este script añade la tabla 'usuarios' a la base de datos.
 * Es seguro ejecutarlo múltiples veces gracias a "CREATE TABLE IF NOT EXISTS".
 */

require_once 'config.php';

try {
    // Conexión a la Base de Datos
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    // Definición de la tabla 'usuarios'
    $sql = "
    CREATE TABLE IF NOT EXISTS `usuarios` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `nombre` VARCHAR(100) NOT NULL,
        `email` VARCHAR(100) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL COMMENT 'Contraseña hasheada',
        `tipo_usuario` ENUM('comprador', 'vendedor') NOT NULL,
        `token_verificacion` VARCHAR(255) NULL,
        `email_verificado` BOOLEAN NOT NULL DEFAULT FALSE,
        `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    // Ejecutar la consulta
    $pdo->exec($sql);

    echo "¡Éxito! La tabla 'usuarios' ha sido creada o ya existía en la base de datos.";

} catch (PDOException $e) {
    die('ERROR: No se pudo actualizar la base de datos. ' . $e->getMessage());
}
