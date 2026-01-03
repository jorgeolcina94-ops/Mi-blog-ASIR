<?php 
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: login.php"); exit(); }

include('../db/db_config.php'); 
include('../includes/header.php'); 

$mensaje = "";
$id = intval($_GET['id']);

// 1. Cargar datos actuales
$stmt = $conn->prepare("SELECT * FROM publicaciones WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) { die("Publicación no encontrada."); }

// 2. Procesar la actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $contenido = $_POST['contenido'];
    $categoria = $_POST['categoria'];
    
    // Si se sube una imagen nueva, la cambiamos; si no, dejamos la anterior
    $imagen_url = $post['imagen_url'];
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $nombre_archivo = time() . "_" . basename($_FILES['imagen']['name']);
        $ruta_destino = "uploads/" . $nombre_archivo;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            $imagen_url = $ruta_destino;
        }
    }

    $update = $conn->prepare("UPDATE publicaciones SET titulo=?, resumen=?, contenido=?, categoria=?, imagen_url=? WHERE id=?");
    $update->bind_param("sssssi", $titulo, $resumen, $contenido, $categoria, $imagen_url, $id);

    if ($update->execute()) {
        $mensaje = "<p style='color: #238636;'>✔ Cambios guardados. <a href='post.php?id=$id' style='color:white;'>Ver post</a></p>";
        // Refrescar datos en memoria
        $post['titulo'] = $titulo; $post['resumen'] = $resumen; $post['contenido'] = $contenido; $post['categoria'] = $categoria;
    } else {
        $mensaje = "<p style='color: #da3633;'>✘ Error al actualizar.</p>";
    }
}
?>

<main class="container">
    <div class="card" style="max-width: 700px; margin: 2rem auto;">
        <h2>Editar: <?php echo htmlspecialchars($post['titulo']); ?></h2>
        <?php echo $mensaje; ?>
        
        <form action="editar_post.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($post['titulo']); ?>" required style="padding: 10px; background: #0d1117; color: white; border: 1px solid #30363d;">
            
            <input type="text" name="categoria" value="<?php echo htmlspecialchars($post['categoria']); ?>" required style="padding: 10px; background: #0d1117; color: white; border: 1px solid #30363d;">
            
            <textarea name="resumen" rows="3" required style="padding: 10px; background: #0d1117; color: white; border: 1px solid #30363d;"><?php echo htmlspecialchars($post['resumen']); ?></textarea>
            
            <textarea name="contenido" rows="10" required style="padding: 10px; background: #0d1117; color: white; border: 1px solid #30363d;"><?php echo htmlspecialchars($post['contenido']); ?></textarea>
            
            <p style="font-size: 0.8rem; color: var(--text-muted);">Imagen actual: <?php echo $post['imagen_url'] ? $post['imagen_url'] : 'Ninguna'; ?></p>
            <input type="file" name="imagen" accept="image/*" style="color: white;">
            
            <button type="submit" class="btn">Guardar Cambios</button>
            <a href="admin.php" style="text-align: center; color: var(--text-muted); text-decoration: none;">Cancelar</a>
        </form>
    </div>
</main>

<?php include('includes/footer.php'); ?>

