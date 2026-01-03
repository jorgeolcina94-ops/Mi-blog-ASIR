<script>
document.addEventListener('DOMContentLoaded', () => {
    console.log("Script de copiado cargado"); // Verifica esto en F12
    
    document.querySelectorAll('pre').forEach((block) => {
        // Crear el botón manualmente
        const button = document.createElement('button');
        button.className = 'copy-button';
        button.type = 'button';
        button.innerText = '📋 Copiar';
        
        // Insertarlo en el bloque de código
        block.appendChild(button);

        button.addEventListener('click', () => {
            // Clonamos el bloque para quitar el texto del propio botón antes de copiar
            const contentToCopy = block.innerText.replace('📋 Copiar', '').trim();
            
            navigator.clipboard.writeText(contentToCopy).then(() => {
                button.innerText = '✅ ¡Copiado!';
                button.classList.add('copied'); // Añade el estilo verde brillante
                setTimeout(() => {
                    button.innerText = '📋 Copiar';
                    button.classList.remove('copied'); // Vuelve al estilo original
                }, 2000);
            }).catch(err => {
                console.error('Error al copiar: ', err);
            });
        });
    });
});
</script>


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

<?php 
$conn->close();
include('includes/footer.php'); 
?>
