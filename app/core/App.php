<?php
/**
 * Clase App (Enrutador Principal)
 *
 * Parsea la URL y determina qué controlador y método llamar.
 * Formato de URL: /controlador/metodo/parametros
 */
class App {
    // Propiedades para el controlador, método y parámetros por defecto.
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        // Cargar los archivos core base
        require_once APPROOT . '/core/Database.php';
        require_once APPROOT . '/core/Controller.php';

        $url = $this->getUrl();

        // 1. Buscar el controlador en app/controllers
        // El primer valor de $url es el controlador.
        if (isset($url[0])) {
            // Si el archivo del controlador existe...
            if (file_exists(APPROOT . '/controllers/' . ucwords($url[0]) . '.php')) {
                // ...lo establece como el controlador actual.
                $this->currentController = ucwords($url[0]);
                // Elimina el controlador del array de la URL.
                unset($url[0]);
            }
        }

        // Requerir el archivo del controlador.
        require_once APPROOT . '/controllers/' . $this->currentController . '.php';
        // Instanciar el controlador.
        $this->currentController = new $this->currentController();

        // 2. Buscar el método en el controlador
        // El segundo valor de $url es el método.
        if (isset($url[1])) {
            // Si el método existe en la clase del controlador...
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Elimina el método del array de la URL.
                unset($url[1]);
            }
        }

        // 3. Obtener los parámetros
        // Lo que queda en el array $url son los parámetros.
        $this->params = $url ? array_values($url) : [];

        // 4. Llamar al método del controlador con los parámetros
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * Obtiene y procesa la URL desde el parámetro 'url' del .htaccess.
     */
    public function getUrl() {
        if (isset($_GET['url'])) {
            // Elimina la barra final si existe.
            $url = rtrim($_GET['url'], '/');
            // Sanitiza la URL para que no contenga caracteres inválidos.
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Convierte la URL en un array.
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
