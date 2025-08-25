<?php
/**
 * Modelo Tienda
 *
 * Se encarga de interactuar con la tabla `tiendas` en la base de datos.
 */
class Tienda {
    private $db;

    public function __construct() {
        // Obtenemos la instancia de la base de datos.
        // Nota: El archivo Database.php es cargado por el enrutador App.php.
        $this->db = Database::getInstance();
    }

    /**
     * Obtiene todas las tiendas de la base de datos.
     *
     * En el futuro, se podría extender para incluir paginación, filtros, etc.
     * También vamos a unir con la tabla de categorías para obtener el nombre de la categoría.
     *
     * @return array Un array de objetos, donde cada objeto es una tienda.
     */
    public function obtenerTiendas() {
        $this->db->query("
            SELECT
                tiendas.id,
                tiendas.nombre,
                tiendas.logo,
                tiendas.verificada,
                categorias.nombre as categoria_nombre
            FROM tiendas
            INNER JOIN categorias ON tiendas.id_categoria = categorias.id
            ORDER BY tiendas.fecha_registro DESC
        ");

        $results = $this->db->resultSet();

        return $results;
    }

    // Futuros métodos podrían ser:
    // public function obtenerTiendaPorId($id) { ... }
    // public function crearTienda($data) { ... }
    // etc.
}
