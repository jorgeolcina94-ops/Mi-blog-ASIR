
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
    <article class="full-post">
        <header>
            <span class="status-badge"><?php echo htmlspecialchars($post['categoria']); ?></span>
            <h1><?php echo htmlspecialchars($post['titulo']); ?></h1>
            <div class="post-meta">
                <span>📅 <?php echo date("d/m/Y", strtotime($post['fecha_publicacion'])); ?></span>
                <span>👤 Jorge Olcina</span>
            </div>
        </header>

         <?php if(!empty($post['imagen_url'])): ?>
            <div class="post-image">
                <img src="<?php echo $post['imagen_url']; ?>" alt="Captura técnica">
            </div>
        <?php endif; ?>

        <div class="post-content">
            <?php 
            // Usamos nl2br para respetar los saltos de línea del textarea, 
            // pero permitimos que las etiquetas HTML que pongas (como <pre>) funcionen.
            echo nl2br($post['contenido']); 
            ?>
        </div>
        
        <footer style="margin-top: 3rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
            <a href="index.php" class="btn" style="text-decoration: none;">&larr; Volver al Dashboard</a>
        </footer>
    </article>
</main>

<!-- Zona de Comentarios -->
<section class="comments-section" style="margin-top: 4rem; border-top: 1px solid var(--border-color); padding-top: 2rem;">
    <h3>💬 Comentarios</h3>

    <?php
    $stmt_com = $conn->prepare("SELECT nombre, comentario, fecha FROM comentarios WHERE post_id = ? ORDER BY fecha DESC");
    $stmt_com->bind_param("i", $id);
    $stmt_com->execute();
    $res_com = $stmt_com->get_result();

    if ($res_com->num_rows > 0):
        while($com = $res_com->fetch_assoc()): ?>
            <div style="background: #161b22; padding: 15px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid var(--accent-color);">
                <strong style="color: var(--accent-color);"><?php echo htmlspecialchars($com['nombre']); ?></strong>
                <small style="color: var(--text-muted); margin-left: 10px;"><?php echo date("d/m/Y H:i", strtotime($com['fecha'])); ?></small>
                <p style="margin-top: 10px;"><?php echo nl2br(htmlspecialchars($com['comentario'])); ?></p>
            </div>
        <?php endwhile;
    else: ?>
        <p style="color: var(--text-muted);">No hay comentarios aún. ¡Sé el primero!</p>
    <?php endif; $stmt_com->close(); ?>

    <div class="card" style="margin-top: 2rem;">
        <h4>Deja un comentario</h4>
        <form action="agregar_comentario.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="hidden" name="post_id" value="<?php echo $id; ?>">
            <input type="text" name="nombre" placeholder="Tu nombre" required style="padding: 10px; background: #0d1117; color: white; border: 1px solid #30363d;">
            <textarea name="comentario" placeholder="Escribe tu opinión o duda técnica..." rows="4" required style="padding: 10px; background: #0d1117; color: white; border: 1px solid #30363d;"></textarea>
            <button type="submit" class="btn">Enviar Comentario</button>
        </form>
    </div>
</section>

<?php 
$conn->close();
include('includes/footer.php'); 
?>
