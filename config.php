<?php
/**
 * Archivo de Configuración Principal de la Aplicación.
 *
 * Aquí se definen las constantes y ajustes más importantes,
 * como las credenciales de la base de datos y otras rutas clave.
 */

// -- CONFIGURACIÓN DE LA BASE DE DATOS -- //

/**
 * El host de la base de datos. Usualmente 'localhost' o '127.0.0.1'.
 */
define('DB_HOST', '127.0.0.1');

/**
 * El nombre de usuario para la conexión a la base de datos.
 */
define('DB_USER', 'root');

/**
 * La contraseña para la conexión a la base de datos.
 * Dejar en blanco si no hay contraseña.
 */
define('DB_PASS', '');

/**
 * El nombre de la base de datos que utilizará la aplicación.
 */
define('DB_NAME', 'd_centro_comercial');


// -- OTRAS CONFIGURACIONES -- //

/**
 * La URL raíz del sitio.
 * Se usará para construir enlaces absolutos y evitar problemas de rutas.
 * Ejemplo: http://localhost/d-centro-comercial
 */
define('APP_URL', 'http://localhost');

/**
 * El nombre del sitio.
 */
define('SITE_NAME', 'D-Centro Comercial');
