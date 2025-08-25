<?php
/**
 * Página de Registro de Usuarios
 */

session_start();
require_once '../config.php';

$errors = [];
$success_message = '';

// Lógica de procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Conexión a la BD
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        $errors[] = 'Error de conexión a la base de datos: ' . $e->getMessage();
    }

    // 2. Recoger y validar datos
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $tipo_usuario = $_POST['tipo_usuario'] ?? '';

    if (empty($nombre)) $errors[] = 'El nombre es obligatorio.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
    if (empty($password) || strlen($password) < 8) $errors[] = 'La contraseña debe tener al menos 8 caracteres.';
    if ($password !== $password_confirm) $errors[] = 'Las contraseñas no coinciden.';
    if (empty($tipo_usuario) || !in_array($tipo_usuario, ['comprador', 'vendedor'])) $errors[] = 'Debe seleccionar un tipo de usuario.';

    // 3. Si no hay errores, proceder
    if (empty($errors)) {
        // Verificar si el email ya existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Este correo electrónico ya está registrado.';
        } else {
            // Hashear la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Generar token de verificación
            $token_verificacion = bin2hex(random_bytes(32));

            // Insertar usuario en la BD
            try {
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, tipo_usuario, token_verificacion) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nombre, $email, $hashed_password, $tipo_usuario, $token_verificacion]);
                $success_message = '¡Registro exitoso! Se ha enviado un enlace de verificación a tu correo. Por favor, revisa tu bandeja de entrada para activar tu cuenta.';
                // En un futuro, aquí iría el código para enviar el email.
            } catch (PDOException $e) {
                $errors[] = 'Error al registrar el usuario: ' . $e->getMessage();
            }
        }
    }
}

// Incluir cabecera
require_once 'includes/header.php';
?>

<div class="container" style="max-width: 600px;">
    <h2>Crear una Cuenta</h2>
    <p>Únete a nuestra comunidad de compradores y vendedores locales.</p>
    <hr style="margin: 1rem 0;">

    <?php if (!empty($errors)): ?>
        <div style="color: red; border: 1px solid red; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">
            <strong>Error:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div style="color: green; border: 1px solid green; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">
            <?php echo $success_message; ?>
        </div>
    <?php else: ?>
        <form action="registro.php" method="POST">
            <div style="margin-bottom: 1rem;">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="password">Contraseña (mín. 8 caracteres)</label>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label for="password_confirm">Confirmar Contraseña</label>
                <input type="password" id="password_confirm" name="password_confirm" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
            </div>
            <fieldset style="margin-bottom: 1rem; border: 1px solid #ccc; padding: 1rem; border-radius: 4px;">
                <legend>Quiero registrarme como:</legend>
                <div>
                    <input type="radio" id="tipo_comprador" name="tipo_usuario" value="comprador" checked>
                    <label for="tipo_comprador">Comprador (Para guardar favoritos y calificar tiendas)</label>
                </div>
                <div>
                    <input type="radio" id="tipo_vendedor" name="tipo_usuario" value="vendedor">
                    <label for="tipo_vendedor">Vendedor (Para registrar mi tienda en la plataforma)</label>
                </div>
            </fieldset>
            <button type="submit" class="tienda-card-contacto" style="width: 100%; border: none; cursor: pointer;">Crear mi Cuenta</button>
        </form>
    <?php endif; ?>
</div>

<?php
// Incluir pie de página
require_once 'includes/footer.php';
?>
