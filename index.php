<?php 
// 1. Incluimos cabecera y DB
include('includes/header.php'); 
include('db/db_config.php'); 

// --- LÓGICA DE MONITORIZACIÓN (SYSADMIN DASHBOARD) ---

// A. Temperatura CPU
// Leemos el sensor térmico de la Raspberry Pi
$temp_raw = @file_get_contents('/sys/class/thermal/thermal_zone0/temp');
if ($temp_raw !== false) {
    $cpu_temp = round($temp_raw / 1000); // Convertir miligrados a grados
} else {
    $cpu_temp = "N/A"; // Por si no es una Raspberry o falla
}

// B. Uso de RAM
// Ejecutamos 'free -h' para obtener la memoria disponible en formato humano (ej: 400Mi)
$ram_free = shell_exec("free -h | awk '/Mem:/ {print $7}'");
$ram_free = trim($ram_free); // Limpiamos espacios en blanco

// C. Lógica de Colores (Semáforo)
// Verde (<55°C), Naranja (55-70°C), Rojo (>70°C)
if ($cpu_temp < 55) {
    $status_color = "#238636"; // Verde (Ok)
    $status_msg = "System Normal";
} elseif ($cpu_temp >= 55 && $cpu_temp < 70) {
    $status_color = "#e3b341"; // Naranja (Warning)
    $status_msg = "High Load";
} else {
    $status_color = "#da3633"; // Rojo (Danger)
    $status_msg = "Overheating!";
}

// 2. Consulta de artículos
$sql = "SELECT id, titulo, resumen, categoria, fecha_publicacion FROM publicaciones ORDER BY fecha_publicacion DESC LIMIT 6";
$resultado = $conn->query($sql);
?>

<main class="container">
    <header class="hero">
        <div class="status-badge" style="border-color: <?php echo $status_color; ?>; color: <?php echo $status_color; ?>;">
            <span class="status-dot" style="background-color: <?php echo $status_color; ?>;"></span>
            RPi 3A+: <?php echo $cpu_temp; ?>°C | RAM Libre: <?php echo $ram_free; ?>
        </div>

        <h1 id="type-main">Diario de un Administrador de Sistemas</h1>
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

	<div class="card">
    		<span class="status-badge" style="background: #0051ad;">DNS</span>
    		<h3>Cloudflare DDNS</h3>
    		<p>Actualización automática de la IP pública en yoryo.es para evitar pérdida de conexión.</p>
    		<div class="card-footer">
        	<code>Status: Operational</code>
        	<a href="recursos.php" class="btn-small">Ver Script</a>
    		</div>
	</div>
	
	<div class="card">
    		<span class="status-badge" style="background: #2ea043;">Security</span>
    		<h3>Smart Backup</h3>
    		<p>Sistema automatizado de copias de seguridad (DB + Archivos) con rotación mensual de backups.</p>
    		<div class="card-footer">
        	<code>Last: 04/01/2026</code>
        	<a href="recursos.php" class="btn-small">Configuración</a>
    		</div>
	</div>

	<div class="card">
    		<span class="status-badge" style="background: #f38020;">Tunnel</span>
    		<h3>Cloudflare Tunnel</h3>
   		<p>Monitor de conexión segura cloudflared. Mantiene el blog accesible saltando el CG-NAT de la red.</p>
    		<div class="card-footer">
        	<code>Status: Active (E2EE)</code>
        	<a href="recursos.php" class="btn-small">Configuración</a>
    		</div>
	</div>

    </section>
</main>

<?php 
$conn->close();
include('includes/footer.php'); 
?>
