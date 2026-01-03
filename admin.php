<?php 
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include('db/db_config.php'); 
include('includes/header.php'); 

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $contenido = $_POST['contenido'];
    $categoria = $_POST['categoria'];
    
    // Gestión de la imagen
    $imagen_url = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombre_archivo = time() . "_" . basename($_FILES['imagen']['name']);
        $ruta_destino = "uploads/" . $nombre_archivo;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            $imagen_url = $ruta_destino;
        }
    }

    // Consulta preparada
    $stmt = $conn->prepare("INSERT INTO publicaciones (titulo, resumen, contenido, categoria, imagen_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $titulo, $resumen, $contenido, $categoria, $imagen_url);

    if ($stmt->execute()) {
        $mensaje = "<p style='color: #238636;'>✔ Publicación creada con éxito.</p>";
    } else {
        $mensaje = "<p style='color: #da3633;'>✘ Error en DB: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

<main class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Panel de Administración</h2>
        <a href="logout.php" class="btn" style="background: #da3633; border-color: #da3633; padding: 5px 15px; font-size: 0.8rem;">Cerrar Sesión</a>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h3>Nueva Publicación Técnica</h3>
        <?php echo $mensaje; ?>
        
        <form action="admin.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="text" name="titulo" placeholder="Título del artículo" required style="padding: 10px; background: #0d1117; border: 1px solid #30363d; color: white;">
            
            <input type="text" name="categoria" placeholder="Categoría (Ej: Redes, Linux)" required style="padding: 10px; background: #0d1117; border: 1px solid #30363d; color: white;">
            
            <textarea name="resumen" placeholder="Resumen corto para la card..." rows="3" required style="padding: 10px; background: #0d1117; border: 1px solid #30363d; color: white;"></textarea>
            
            <textarea name="contenido" placeholder="Contenido detallado..." rows="10" required style="padding: 10px; background: #0d1117; border: 1px solid #30363d; color: white;"></textarea>
            
            <label style="font-size: 0.8rem; color: var(--text-muted);">Imagen de cabecera / Captura de consola:</label>
            <input type="file" name="imagen" accept="image/*" style="color: white; margin-bottom: 10px;">
            
            <button type="submit" class="btn">Publicar entrada</button>
        </form>
    </div>
</main>

<?php 
$conn->close();
include('includes/footer.php'); 
?>
