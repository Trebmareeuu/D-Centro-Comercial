<?php
/**
 * Controlador Pages
 *
 * Se encarga de la lógica para las páginas estáticas como el inicio, acerca de, etc.
 */
class Pages extends Controller {

    private $tiendaModel;

    public function __construct() {
        // En el constructor, cargamos los modelos que este controlador va a necesitar.
        // El método model() viene de la clase Controller que extendemos.
        $this->tiendaModel = $this->model('Tienda');
    }

    /**
     * Método para la página de inicio.
     */
    public function index() {
        // Obtener las tiendas desde el modelo.
        $tiendas = $this->tiendaModel->obtenerTiendas();

        // Preparar los datos para la vista.
        $data = [
            'titulo' => 'Bienvenido al Centro Comercial Digital',
            'tiendas' => $tiendas
        ];

        // Cargar la vista de inicio y pasarle los datos.
        // El método view() también viene del Controller base.
        // Nota: El path es relativo a la carpeta /views.
        $this->view('pages/inicio', $data);
    }

    /**
     * Método para una futura página 'Acerca de'.
     */
    public function about() {
        $data = [
            'titulo' => 'Acerca de Nosotros',
            'descripcion' => 'Somos una plataforma para conectar tiendas locales con la comunidad.'
        ];
        $this->view('pages/about', $data);
    }
}
