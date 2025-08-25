<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; // Usamos la constante del config.php ?></title>

    <!-- Descripción para SEO -->
    <meta name="description" content="Encuentra las mejores tiendas y servicios locales en un solo lugar.">

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/style.css">

    <!-- FontAwesome para iconos (lo usaremos mucho) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* Estilos básicos para empezar */
        body {
            font-family: sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
        }
    </style>
</head>
<body>

<header>
    <!-- El header principal irá aquí: logo, buscador, botones de login/registro -->
    <!-- Por ahora, un simple placeholder -->
    <div class="container">
        <h1><?php echo SITE_NAME; ?></h1>
        <p>Tu centro comercial digital.</p>
    </div>
</header>

<main class="container">
    <!-- El contenido principal de cada página se cargará aquí -->
