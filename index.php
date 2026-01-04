<?php 
include('includes/header.php'); 
include('db/db_config.php'); 

$sql = "SELECT id, titulo, resumen, categoria, fecha_publicacion FROM publicaciones ORDER BY fecha_publicacion DESC LIMIT 6";
$resultado = $conn->query($sql);
?>

<main class="container">
    <header class="hero">
        <div class="status-badge">
            <span class="status-dot"></span> System Status: Online
        </div>
        <h1>Diario de un Administrador de Sistemas</h1>
        <p>Documentando laboratorios y despliegues en mi Raspberry Pi 3A+.</p>

        <div class="search-box">
            <form action="buscar.php" method="GET" class="search-form">
                <span class="prompt-sign">$ grep</span>
                <input type="text" name="q" class="search-input" placeholder="apache, error 500, linux..." required>
                <button type="submit" class="search-btn">🔍</button>
            </form>
        </div>
    </header>

    <section id="labs">
        <h2 class="section-title">01. Laboratorios Recientes</h2>
        <div class="lab-grid">
            <?php
            if ($resultado && $resultado->num_rows > 0) {
                while($row = $resultado->fetch_assoc()) {
                    ?>
                    <article class="card">
                        <span><?php echo htmlspecialchars($row['categoria']); ?></span>
                        <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($row['resumen']); ?></p>
                        <a href="post.php?id=<?php echo $row['id']; ?>" class="read-more">Leer más &rarr;</a>
                        <small style="display:block; margin-top:10px; color: var(--text-muted); font-size: 0.7rem;">
                            <?php echo date("d/m/Y", strtotime($row['fecha_publicacion'])); ?>
                        </small>
                    </article>
                    <?php
                }
            } else {
                echo "<p>No hay publicaciones. ¡Accede al panel Admin para crear una!</p>";
            }
            ?>
        </div>
    </section>

    <section id="scripts">
        <h2 class="section-title">02. Scripts de Automatización</h2>
        <div class="card" style="width: 100%;">
            <span>Bash</span>
            <h3>Sync GitHub</h3>
            <p>Automatizando el despliegue de mi blog con Webhooks.</p>
        </div>
    </section>
</main>

<?php 
$conn->close();
include('includes/footer.php'); 
?>
