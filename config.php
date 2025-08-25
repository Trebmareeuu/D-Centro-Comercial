<?php
/**
 * Archivo de Configuración Principal de la Aplicación.
 *
 * Aquí se definen las constantes y ajustes más importantes,
 * como las credenciales de la base de datos y otras rutas clave.
 */

// -- CONFIGURACIÓN DE LA BASE DE DATOS -- //
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'd_centro_comercial');

// -- RUTAS DE LA APLICACIÓN -- //

// Ruta raíz del proyecto.
define('ROOT', __DIR__);

// Ruta a la carpeta 'app'.
define('APPROOT', __DIR__ . '/app');

// URL Raíz del sitio. Usada para construir enlaces absolutos en el frontend.
define('APP_URL', 'http://localhost');

// Nombre del sitio.
define('SITE_NAME', 'D-Centro Comercial');
