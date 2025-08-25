<?php
/**
 * Página de Registro de Usuarios
 */

session_start();
// Usamos __DIR__ para obtener una ruta robusta al archivo de configuración.
require_once __DIR__ . '/../config.php';

$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ... (la lógica PHP de procesamiento sigue siendo la misma) ...
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        $errors[] = 'Error de conexión a la base de datos.';
    }

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

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Este correo electrónico ya está registrado.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $token_verificacion = bin2hex(random_bytes(32));
            try {
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, tipo_usuario, token_verificacion) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nombre, $email, $hashed_password, $tipo_usuario, $token_verificacion]);
                $success_message = '¡Registro exitoso! Se ha enviado un enlace de verificación a tu correo. Por favor, revisa tu bandeja de entrada para activar tu cuenta.';
            } catch (PDOException $e) {
                $errors[] = 'Error al registrar el usuario.';
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="registro-layout">

    <div class="form-container">
        <h2>Crear una Cuenta</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul><?php foreach ($errors as $error) echo "<li>$error</li>"; ?></ul>
            </div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php else: ?>
            <form action="registro.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña (mín. 8 caracteres)</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirmar Contraseña</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                </div>
                <fieldset class="form-fieldset">
                    <legend>Quiero registrarme como:</legend>
                    <div>
                        <input type="radio" id="tipo_comprador" name="tipo_usuario" value="comprador" checked>
                        <label for="tipo_comprador">Comprador</label>
                    </div>
                    <div>
                        <input type="radio" id="tipo_vendedor" name="tipo_usuario" value="vendedor">
                        <label for="tipo_vendedor">Vendedor</label>
                    </div>
                </fieldset>

                <div id="beneficios-dinamicos" class="alert alert-success" style="display: none; margin-bottom: 1.25rem;"></div>

                <button type="submit" class="tienda-card-contacto form-button">Crear mi Cuenta</button>
            </form>
            <a href="login.php" class="form-link">¿Ya tienes una cuenta? Inicia sesión</a>
        <?php endif; ?>
    </div>

    <aside class="help-section">
        <h3>¿Necesitas Ayuda?</h3>
        <div class="video-placeholder">
            <div class="icon"><i class="fas fa-store-alt"></i></div>
            <h4>Cómo Registrar tu Tienda</h4>
            <p>Una guía paso a paso para poner tu negocio en nuestra plataforma.</p>
        </div>
        <div class="video-placeholder">
            <div class="icon"><i class="fas fa-shopping-cart"></i></div>
            <h4>Beneficios como Comprador</h4>
            <p>Descubre cómo sacar el máximo provecho de tu cuenta de comprador.</p>
        </div>
    </aside>

</div>

<script src="../almacen/js/registro-dinamico.js"></script>

<?php
require_once 'includes/footer.php';
?>
