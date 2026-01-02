<?php
session_start();
include('db/db_config.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

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
            header("Location: admin.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El usuario no existe.";
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
