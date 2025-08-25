<?php
/**
 * Script de Instalación de la Base de Datos.
 *
 * Este script se ejecuta una sola vez para:
 * 1. Crear la base de datos.
 * 2. Crear las tablas necesarias.
 * 3. Insertar datos de ejemplo para el desarrollo inicial.
 *
 * ¡IMPORTANTE! Borrar o renombrar este archivo después de una ejecución exitosa en un entorno de producción.
 */

// Incluimos la configuración para tener las credenciales.
require_once 'config.php';

try {
    // --- PASO 1: Conexión al servidor MySQL (sin seleccionar la base de datos aún) ---
    $pdo = new PDO('mysql:host=' . DB_HOST, DB_USER, DB_PASS);

    // Configurar PDO para que lance excepciones en caso de error.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // --- PASO 2: Crear la base de datos si no existe ---
    // Usamos `backticks` en el nombre de la base de datos para evitar conflictos con palabras reservadas de SQL.
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

    echo "Base de datos '" . DB_NAME . "' creada o ya existente.<br>";

    // --- PASO 3: Conectar a la base de datos recién creada ---
    $pdo->exec("USE `" . DB_NAME . "`;");

    echo "Conexión establecida con la base de datos '" . DB_NAME . "'.<br>";

    // --- PASO 4: Crear la tabla 'categorias' ---
    $sql_categorias = "
    CREATE TABLE IF NOT EXISTS `categorias` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `nombre` VARCHAR(100) NOT NULL,
        `icono` VARCHAR(50) NOT NULL COMMENT 'Ej: fas fa-tshirt. Usaremos FontAwesome.'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $pdo->exec($sql_categorias);
    echo "Tabla 'categorias' creada o ya existente.<br>";

    // --- PASO 5: Crear la tabla 'tiendas' ---
    $sql_tiendas = "
    CREATE TABLE IF NOT EXISTS `tiendas` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `nombre` VARCHAR(150) NOT NULL,
        `id_categoria` INT NOT NULL,
        `logo` VARCHAR(255) DEFAULT 'default.png',
        `verificada` BOOLEAN NOT NULL DEFAULT FALSE,
        `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`id_categoria`) REFERENCES `categorias`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    $pdo->exec($sql_tiendas);
    echo "Tabla 'tiendas' creada o ya existente.<br>";

    // --- PASO 6: Insertar datos de ejemplo (solo si las tablas están vacías) ---

    // Categorías de ejemplo
    $stmt = $pdo->query("SELECT COUNT(*) FROM `categorias`");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("
        INSERT INTO `categorias` (`nombre`, `icono`) VALUES
        ('Tecnología', 'fas fa-laptop'),
        ('Ropa y Accesorios', 'fas fa-tshirt'),
        ('Hogar y Jardín', 'fas fa-couch'),
        ('Restaurantes', 'fas fa-utensils'),
        ('Salud y Belleza', 'fas fa-spa');
        ");
        echo "Datos de ejemplo insertados en 'categorias'.<br>";
    }

    // Tiendas de ejemplo
    $stmt = $pdo->query("SELECT COUNT(*) FROM `tiendas`");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("
        INSERT INTO `tiendas` (`nombre`, `id_categoria`, `verificada`) VALUES
        ('PC-Componentes Bolivia', 1, TRUE),
        ('Moda Urbana', 2, TRUE),
        ('El Horno de la Abuela', 4, FALSE),
        ('Casa Bonita Decoraciones', 3, TRUE),
        ('Celulares Express', 1, FALSE);
        ");
        echo "Datos de ejemplo insertados en 'tiendas'.<br>";
    }

    echo "<hr><strong>¡Instalación completada exitosamente!</strong>";

} catch (PDOException $e) {
    // Si algo sale mal, mostramos el error.
    die("ERROR: No se pudo completar la instalación. " . $e->getMessage());
}
