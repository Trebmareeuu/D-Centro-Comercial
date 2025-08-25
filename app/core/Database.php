<?php
/**
 * Clase Database
 *
 * Se encarga de la conexión a la base de datos usando PDO.
 * Sigue un patrón Singleton para asegurar que solo exista una instancia
 * de la conexión a la base de datos en toda la aplicación.
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; // Database Handler
    private $stmt; // Statement
    private $error;

    private static $instance = null;

    private function __construct() {
        // Configurar el DSN (Data Source Name)
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true, // Conexiones persistentes
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones en errores
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Obtener resultados como objetos
            PDO::ATTR_EMULATE_PREPARES => false, // Usar preparaciones nativas
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
        ];

        // Crear la instancia de PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            // En un entorno real, aquí se registraría el error en un archivo de log.
            die('Error de conexión con la base de datos: ' . $this->error);
        }
    }

    /**
     * Método estático para obtener la instancia de la base de datos.
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Prepara la consulta SQL.
     */
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Vincula los valores a los placeholders de la consulta.
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Ejecuta la consulta preparada.
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * Obtiene un conjunto de resultados como un array de objetos.
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Obtiene un único resultado como un objeto.
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Obtiene el número de filas afectadas por la última consulta.
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}
