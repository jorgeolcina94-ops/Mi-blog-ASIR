<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
} 
include('includes/header.php'); 
include('db/db_config.php'); 

// Variable para mensajes de estado
$mensaje = "";

// Comprobamos si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $contenido = $_POST['contenido'];
    $categoria = $_POST['categoria'];

    // Uso de Sentencias Preparadas (Seguridad fundamental en ASIR)
    $stmt = $conn->prepare("INSERT INTO publicaciones (titulo, resumen, contenido, categoria) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $titulo, $resumen, $contenido, $categoria);

    if ($stmt->execute()) {
        $mensaje = "<p style='color: #238636;'>✔ Publicación creada con éxito.</p>";
    } else {
        $mensaje = "<p style='color: #da3633;'>✘ Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

<main class="container">
    <h2 class="section-title">Panel de Administración</h2>
	<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <p>Conectado como: <strong><?php echo $_SESSION['usuario_nom']; ?></strong></p>
        <a href="logout.php" class="btn" style="background: #da3633; border-color: #da3633; padding: 5px 15px; font-size: 0.8rem;">Cerrar Sesión</a>
	</div>
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h3>Nueva Publicación</h3>
        <?php echo $mensaje; ?>
        
        <form action="admin.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="text" name="titulo" placeholder="Título del artículo" required 
                   style="padding: 10px; background: #0d1117; border: 1px solid #30363d; color: white;">
            
            <input type="text" name="categoria" placeholder="Categoría (Ej: Redes, Linux, Seguridad)" required
                   style="padding: 10px; background: #0d1117; border: 1px solid #30363d; color: white;">
            
            <textarea name="resumen" placeholder="Resumen corto..." rows="3" required
                      style="padding: 10px; background: #0d1117; border: 1px solid #30363d; color: white;"></textarea>
            
            <textarea name="contenido" placeholder="Escribe aquí todo el contenido técnico..." rows="10" required
                      style="padding: 10px; background: #0d1117; border: 1px solid #30363d; color: white;"></textarea>
            
            <button type="submit" class="btn">Publicar en el Blog</button>
        </form>
        <br>
        <a href="index.php" style="color: var(--accent-color); text-decoration: none;">&larr; Volver al Inicio</a>
    </div>
</main>

<?php 
$conn->close();
include('includes/footer.php'); 
?>
