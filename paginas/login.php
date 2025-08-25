<?php
/**
 * Página de Inicio de Sesión
 */

session_start();
require_once '../config.php';

$errors = [];

// Si el usuario ya está logueado, redirigir al index
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

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
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
    if (empty($password)) $errors[] = 'La contraseña es obligatoria.';

    // 3. Si no hay errores, intentar autenticar
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user->password)) {
            // Contraseña correcta
            // if (!$user->email_verificado) {
            //     $errors[] = 'Tu cuenta no ha sido verificada. Por favor, revisa tu correo.';
            // } else {
                // Iniciar sesión
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_nombre'] = $user->nombre;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_tipo'] = $user->tipo_usuario;

                // Redirigir al index
                header('Location: ../index.php');
                exit();
            // }
        } else {
            // Email no encontrado o contraseña incorrecta
            $errors[] = 'El correo electrónico o la contraseña son incorrectos.';
        }
    }
}

// Incluir cabecera
require_once 'includes/header.php';
?>

<div class="container" style="max-width: 500px;">
    <h2>Iniciar Sesión</h2>
    <p>Accede a tu cuenta para continuar.</p>
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

    <form action="login.php" method="POST">
        <div style="margin-bottom: 1rem;">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
        </div>
        <button type="submit" class="tienda-card-contacto" style="width: 100%; border: none; cursor: pointer;">Acceder</button>
    </form>
    <p style="text-align: center; margin-top: 1rem;">
        ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.
    </p>
</div>

<?php
// Incluir pie de página
require_once 'includes/footer.php';
?>
