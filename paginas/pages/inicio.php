<?php
/**
 * Vista para la página de Inicio (Index).
 *
 * Muestra el grid de tiendas cargado desde la base de datos.
 * La variable $data es pasada desde el controlador Pages.php.
 */

require_once ROOT . '/views/includes/header.php';
?>

<!-- El div.container ahora es abierto en header.php y cerrado en footer.php -->

<h2><?php echo isset($data['titulo']) ? htmlspecialchars($data['titulo']) : 'Bienvenido'; ?></h2>
<p>Explora nuestro catálogo de tiendas locales.</p>

<div class="tiendas-grid">
    <?php if (!empty($data['tiendas'])) : ?>
        <?php foreach ($data['tiendas'] as $tienda) : ?>
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
require_once ROOT . '/views/includes/footer.php';
?>
