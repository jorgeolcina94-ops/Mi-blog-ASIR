<?php 
include('includes/header.php'); 
include('db/db_config.php'); 

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM publicaciones WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$post = $resultado->fetch_assoc();

if (!$post) { die("Publicación no encontrada."); }
?>

<main class="container">
    <article style="max-width: 800px; margin: 0 auto;">
        <span class="status-badge"><?php echo $post['categoria']; ?></span>
        <h1 style="font-size: 2.5rem; margin: 1rem 0;"><?php echo $post['titulo']; ?></h1>
        
        <?php if($post['imagen_url']): ?>
            <img src="<?php echo $post['imagen_url']; ?>" style="width:100%; border-radius:10px; margin-bottom: 2rem;">
        <?php endif; ?>

        <div style="font-size: 1.2rem; line-height: 1.8; color: #c9d1d9;">
            <?php echo nl2br($post['contenido']); ?>
        </div>
        
        <br><a href="index.php" style="color: var(--accent-color); text-decoration: none;">&larr; Volver</a>
    </article>
</main>

<?php include('includes/footer.php'); ?>
