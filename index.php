<?php
/**
 * Punto de Entrada Principal (Front Controller).
 *
 * Todas las peticiones a la aplicación son redirigidas aquí por el .htaccess.
 * Este archivo simplemente inicia la aplicación.
 */

// Cargar el archivo de configuración global.
require_once 'config.php';

// Cargar el enrutador principal.
// Este archivo se encargará de cargar todo lo demás.
require_once 'app/core/App.php';

// Iniciar la aplicación.
$app = new App();
