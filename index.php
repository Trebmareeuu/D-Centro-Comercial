<?php
/**
 * Punto de Entrada Principal (Front Controller).
 *
 * Todas las peticiones a la aplicación son redirigidas aquí por el .htaccess.
 * Este archivo se encarga de inicializar la aplicación, cargar el controlador
 * adecuado y renderizar la vista correspondiente.
 */

// Cargar el archivo de configuración.
require_once 'config.php';

// Cargar archivos base del sistema (en el futuro aquí irá el autoloader).
// require_once 'app/core/App.php';
// require_once 'app/core/Controller.php';

// Por ahora, para esta fase inicial, simplemente cargamos las partes de la vista.

// Incluir el encabezado de la página.
require_once 'views/includes/header.php';

// Incluir la vista de la página de inicio.
// Más adelante, aquí habrá una lógica para cargar diferentes páginas.
require_once 'views/pages/inicio.php';

// Incluir el pie de página.
require_once 'views/includes/footer.php';
