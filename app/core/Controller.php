<?php
/**
 * Clase Controlador Base
 *
 * Esta es la clase de la que heredarán todos los demás controladores.
 * Proporciona métodos comunes como cargar modelos y vistas.
 */
class Controller {

    /**
     * Carga y retorna una instancia de un modelo.
     *
     * @param string $model El nombre del modelo a cargar (ej. 'Tienda').
     * @return object La instancia del modelo.
     */
    public function model($model) {
        $modelPath = APPROOT . '/models/' . $model . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        } else {
            die('El modelo "' . $model . '" no fue encontrado.');
        }
    }

    /**
     * Carga una vista.
     *
     * @param string $view La ruta de la vista a cargar (ej. 'pages/inicio').
     * @param array $data Un array de datos para pasar a la vista.
     */
    public function view($view, $data = []) {
        // Las vistas están en la carpeta /views, que está en la raíz del proyecto.
        $viewPath = ROOT . '/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            // Extrae el array de datos en variables individuales.
            extract($data);

            // Cargar la vista
            require $viewPath;
        } else {
            die('La vista "' . $view . '" no fue encontrada en la ruta: ' . $viewPath);
        }
    }
}
