<?php 
// 1. Incluimos la cabecera y la conexión a la base de datos
include('includes/header.php'); 
include('db/db_config.php'); 

// 2. Preparamos la consulta SQL para traer los artículos más recientes
$sql = "SELECT titulo, resumen, categoria, fecha_publicacion FROM publicaciones ORDER BY fecha_publicacion DESC";
$resultado = $conn->query($sql);
?>

<main class="container">
    <header class="hero">
        <div class="status-badge">
            <span class="status-dot"></span> System Status: Online
        </div>
        <h1>Diario de un Administrador de Sistemas</h1>
        <p>Documentando laboratorios y despliegues en mi Raspberry Pi 3A+.</p>
    </header>

    <section id="labs">
        <h2 class="section-title">01. Laboratorios Recientes</h2>
        <div class="lab-grid">
            
            <?php
            // 3. Verificamos si hay resultados y los mostramos
            if ($resultado->num_rows > 0) {
                while($row = $resultado->fetch_assoc()) {
                    ?>
                    <article class="card">
                        <span><?php echo htmlspecialchars($row['categoria']); ?></span>
                        <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($row['resumen']); ?></p>
			<a href="post.php?id=<?php echo $row['id']; ?>" class="read-more">Leer más &rarr;</a>
                        <small style="color: var(--text-muted); font-size: 0.7rem;">
                            Publicado el: <?php echo date("d/m/Y", strtotime($row['fecha_publicacion'])); ?>
                        </small>
                    </article>
                    <?php
                }
            } else {
                echo "<p>No hay publicaciones todavía. ¡Abre la terminal de MariaDB e inserta una!</p>";
            }
            ?>

        </div>
    </section>

    <section id="scripts">
        <h2 class="section-title">02. Scripts de Automatización</h2>
        <div class="card" style="width: 100%;">
            <span>Bash</span>
            <h3>Sync GitHub</h3>
            <p>Automatizando el despliegue de mi blog.</p>
        </div>
    </section>
</main>

<?php 
// 4. Cerramos la conexión para liberar recursos y cargamos el footer
$conn->close();
include('includes/footer.php'); 
?>
