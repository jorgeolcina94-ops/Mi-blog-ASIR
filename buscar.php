<?php 
include('includes/header.php'); 
include('db/db_config.php');

$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
?>

<main class="container">
    <div style="margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
        <h2 style="font-family: var(--font-mono); color: var(--accent-color);">
            > Resultados para: "<?php echo htmlspecialchars($busqueda); ?>"
        </h2>
    </div>

    <div class="lab-grid">
        <?php
        if ($busqueda != "") {
            $param = "%{$busqueda}%";
            $sql = "SELECT id, titulo, resumen, categoria, fecha_publicacion FROM publicaciones WHERE titulo LIKE ? OR resumen LIKE ? ORDER BY fecha_publicacion DESC";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $param, $param);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                while($row = $resultado->fetch_assoc()):
        ?>
            <article class="card">
                <span><?php echo htmlspecialchars($row['categoria']); ?></span>
                <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                <p><?php echo htmlspecialchars($row['resumen']); ?></p>
                <a href="post.php?id=<?php echo $row['id']; ?>" class="read-more">Leer más &rarr;</a>
            </article>
        <?php 
                endwhile;
            } else {
                echo '<div style="grid-column: 1/-1; padding: 20px; border: 1px dashed #da3633; color: #da3633; font-family: var(--font-mono);">
                        <p>> grep: Pattern not found.</p>
                        <p>Intenta con otra palabra clave.</p>
                      </div>';
            }
        } else {
            echo '<p>Introduce un término de búsqueda.</p>';
        }
        ?>
    </div>
    
    <div style="margin-top: 40px; text-align: center;">
        <a href="index.php" class="btn" style="text-decoration: none;">&larr; Volver al inicio</a>
    </div>
</main>

<?php include('includes/footer.php'); ?>
