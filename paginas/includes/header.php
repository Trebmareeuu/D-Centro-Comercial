<?php
// Iniciar la sesión si no está iniciada para poder acceder a $_SESSION
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>

    <meta name="description" content="Encuentra las mejores tiendas y servicios locales en un solo lugar.">

    <!-- Google Fonts y Estilos CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap">

    <link rel="stylesheet" href="almacen/css/style.css">

    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<header class="hero-header">
    <nav class="header-nav">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="welcome-message">¡Hola, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?>!</span>
            <a href="logout.php" class="btn-nav">Cerrar Sesión</a>
        <?php else: ?>
            <a href="paginas/login.php" class="btn-nav">Iniciar Sesión</a>
            <a href="paginas/registro.php" class="btn-nav">Registrarse</a>
        <?php endif; ?>
    </nav>
    <div class="container">
        <h1><?php echo SITE_NAME; ?></h1>
        <p>Tu centro comercial digital. Conectando comercios locales con la comunidad.</p>
    </div>
</header>

<main>
    <div class="container">
        <!-- El contenido principal de cada página se cargará aquí -->
