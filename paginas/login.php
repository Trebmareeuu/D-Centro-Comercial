<?php
/**
 * Página de Inicio de Sesión
 */

session_start();
// Usamos __DIR__ para obtener una ruta robusta al archivo de configuración.
require_once __DIR__ . '/../config.php';

$errors = [];

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];
    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        $errors[] = 'Error de conexión a la base de datos.';
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
    if (empty($password)) $errors[] = 'La contraseña es obligatoria.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_nombre'] = $user->nombre;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_tipo'] = $user->tipo_usuario;
            header('Location: ../index.php');
            exit();
        } else {
            $errors[] = 'El correo electrónico o la contraseña son incorrectos.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="form-container">
    <h2>Iniciar Sesión</h2>
    <p>Accede a tu cuenta para continuar.</p>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="tienda-card-contacto form-button">Acceder</button>
    </form>
    <a href="registro.php" class="form-link">¿No tienes una cuenta? Regístrate aquí</a>
</div>

<?php
require_once 'includes/footer.php';
?>
