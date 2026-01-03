<?php
session_start();
include('db/db_config.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];

    // Contamos fallos en los últimos 15 minutos
    $minutos = 15;
    $intentos_maximos = 5;
    
    $stmt_check = $conn->prepare("SELECT COUNT(*) as fallos FROM login_attempts WHERE ip_address = ? AND exitoso = 0 AND intento_fecha > DATE_SUB(NOW(), INTERVAL ? MINUTE)");
    $stmt_check->bind_param("si", $ip, $minutos);
    $stmt_check->execute();
    $bloqueo = $stmt_check->get_result()->fetch_assoc();

    if ($bloqueo['fallos'] >= $intentos_maximos) {
        $error = "Demasiados intentos fallidos. IP bloqueada temporalmente (15 min).";
    } else {

    $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        // Verificamos si la contraseña coincide con el hash
        if (password_verify($pass, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nom'] = $user;

            $log = $conn->prepare("INSERT INTO login_attempts (ip_address, exitoso) VALUES (?, 1)");
            $log->bind_param("s", $ip);
            $log->execute();

            header("Location: admin/admin.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";

            $log = $conn->prepare("INSERT INTO login_attempts (ip_address, exitoso) VALUES (?, 0)");
            $log->bind_param("s", $ip);
            $log->execute();
        }
    } else {
        $error = "El usuario no existe.";

        $log = $conn->prepare("INSERT INTO login_attempts (ip_address, exitoso) VALUES (?, 0)");
        $log->bind_param("s", $ip);
        $log->execute();
    }
  }
}
?>

<?php include('includes/header.php'); ?>
<main class="container">
    <div class="card" style="max-width: 400px; margin: 4rem auto;">
        <h3>Acceso Restringido</h3>
        <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required style="width:100%; padding:10px; margin-bottom:10px; background:#0d1117; color:white; border:1px solid #30363d;">
            <input type="password" name="password" placeholder="Contraseña" required style="width:100%; padding:10px; margin-bottom:10px; background:#0d1117; color:white; border:1px solid #30363d;">
            <button type="submit" class="btn" style="width:100%;">Entrar</button>
        </form>
    </div>
</main>
<?php include('includes/footer.php'); ?>
