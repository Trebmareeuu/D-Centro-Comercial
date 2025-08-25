<?php
/**
 * Página de Inicio Principal.
 *
 * Este script se encarga de todo el proceso para la página de inicio:
 * 1. Carga la configuración.
 * 2. Se conecta a la base de datos.
 * 3. Obtiene los datos de las tiendas.
 * 4. Muestra la página completa con el header, contenido y footer.
 */

// 1. Cargar configuración
require_once 'config.php';

// 2. Conexión a la Base de Datos
$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // En un caso real, aquí se registraría el error y se mostraría una página de error amigable.
    die('Error de conexión a la base de datos: ' . $e->getMessage());
}

// 3. Obtener los datos de las tiendas
$stmt = $pdo->query("
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
$tiendas = $stmt->fetchAll();

// 4. Mostrar la página

// Incluir cabecera
// La ruta ahora es relativa a la nueva carpeta 'paginas'
require_once 'paginas/includes/header.php';

?>

<!-- El div.container ahora es abierto en header.php y cerrado en footer.php -->

<h2>Catálogo de Tiendas</h2>
<p>Explora nuestro catálogo de tiendas locales.</p>

<div class="tiendas-grid">
    <?php if (!empty($tiendas)) : ?>
        <?php foreach ($tiendas as $tienda) : ?>
            <div class="tienda-card">
                <div class="tienda-card-logo">
                    <!-- Usaremos un placeholder si no hay logo específico -->
                    <i class="fas fa-store fa-3x" style="color: #ccc;"></i>
                </div>
                <div class="tienda-card-contenido">
                    <h3 class="tienda-card-titulo">
                        <?php echo htmlspecialchars($tienda->nombre); ?>
                        <?php if ($tienda->verificada) : ?>
                            <i class="fas fa-check-circle tienda-card-verificada" title="Tienda Verificada"></i>
                        <?php endif; ?>
                    </h3>
                    <p class="tienda-card-categoria"><?php echo htmlspecialchars($tienda->categoria_nombre); ?></p>
                    <a href="#" class="tienda-card-contacto">
                        <i class="fas fa-comment-dots"></i> Contactar
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No hay tiendas para mostrar en este momento. ¡Vuelve pronto!</p>
    <?php endif; ?>
</div>

<?php
// Incluir pie de página
require_once 'paginas/includes/footer.php';
?>
