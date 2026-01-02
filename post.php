<?php 
include('includes/header.php'); 
include('db/db_config.php'); 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM publicaciones WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$post = $resultado->fetch_assoc();

if (!$post) {
    die("Publicación no encontrada.");
}
?>

<main class="container">
    <article class="full-post">
        <span class="tag"><?php echo $post['categoria']; ?></span>
        <h1><?php echo $post['titulo']; ?></h1>
        <p class="date">Publicado el <?php echo date("d/m/Y", strtotime($post['fecha_publicacion'])); ?></p>
        
        <?php if($post['imagen_url']): ?>
            <img src="<?php echo $post['imagen_url']; ?>" style="width:100%; border-radius:10px; margin: 2rem 0; border: 1px solid var(--border-color);">
        <?php endif; ?>

        <div class="content" style="white-space: pre-wrap; font-size: 1.1rem;">
            <?php echo $post['contenido']; ?>
        </div>
        
        <br><br>
        <a href="index.php" style="color: var(--accent-color);">&larr; Volver al listado</a>
    </article>
</main>

<?php include('includes/footer.php'); ?>
