<?php 
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

include('../db/db_config.php'); 
include('../includes/header.php'); 

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
<hr style="margin: 3rem 0; border: 0; border-top: 1px solid var(--border-color);">

<section>
    <h3>Gestionar Publicaciones Existentes</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 1rem; background: var(--bg-card); border-radius: 8px; overflow: hidden;">
        <thead>
            <tr style="background: #161b22; text-align: left;">
                <th style="padding: 12px; border-bottom: 1px solid var(--border-color);">Título</th>
                <th style="padding: 12px; border-bottom: 1px solid var(--border-color);">Categoría</th>
                <th style="padding: 12px; border-bottom: 1px solid var(--border-color);">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, titulo, categoria FROM publicaciones ORDER BY fecha_publicacion DESC";
            $res = $conn->query($sql);
            while($row = $res->fetch_assoc()):
            ?>
            <tr style="border-bottom: 1px solid #21262d;">
                <td style="padding: 12px;"><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td style="padding: 12px;"><span class="status-badge"><?php echo htmlspecialchars($row['categoria']); ?></span></td>
                <td style="padding: 12px;">
                    <a href="editar_post.php?id=<?php echo $row['id']; ?>" style="color: var(--accent-color); text-decoration: none; font-weight: bold;">[ Editar ]</a>
                    &nbsp;
   		    <a href="eliminar_post.php?id=<?php echo $row['id']; ?>" 
                    onclick="return confirm('¿Estás seguro de que quieres eliminar este post? Esta acción no se puede deshacer.');" 
                    style="color: #da3633; text-decoration: none; font-weight: bold;">[ Borrar ]</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>
<hr style="margin: 3rem 0; border: 0; border-top: 1px solid var(--border-color);">

<section>
    <h3>Moderación de Comentarios</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 1rem; background: var(--bg-card); border-radius: 8px; overflow: hidden;">
        <thead>
            <tr style="background: #161b22; text-align: left;">
                <th style="padding: 12px; border-bottom: 1px solid var(--border-color);">Usuario</th>
                <th style="padding: 12px; border-bottom: 1px solid var(--border-color);">Comentario</th>
                <th style="padding: 12px; border-bottom: 1px solid var(--border-color);">En el Post</th>
                <th style="padding: 12px; border-bottom: 1px solid var(--border-color);">Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta con JOIN para saber el título del post al que pertenece el comentario
            $sql_com = "SELECT c.id, c.nombre, c.comentario, p.titulo 
                        FROM comentarios c 
                        JOIN publicaciones p ON c.post_id = p.id 
                        ORDER BY c.fecha DESC LIMIT 10";
            $res_com = $conn->query($sql_com);

            if ($res_com->num_rows > 0) {
                while($com = $res_com->fetch_assoc()):
                ?>
                <tr style="border-bottom: 1px solid #21262d;">
                    <td style="padding: 12px; font-weight: bold; color: var(--accent-color);">
                        <?php echo htmlspecialchars($com['nombre']); ?>
                    </td>
                    <td style="padding: 12px; font-size: 0.9rem;">
                        <?php echo mb_strimwidth(htmlspecialchars($com['comentario']), 0, 50, "..."); ?>
                    </td>
                    <td style="padding: 12px; font-style: italic; color: var(--text-muted);">
                        <?php echo htmlspecialchars($com['titulo']); ?>
                    </td>
                    <td style="padding: 12px;">
                        <a href="eliminar_comentario.php?id=<?php echo $com['id']; ?>" 
                           onclick="return confirm('¿Eliminar este comentario?');" 
                           style="color: #da3633; text-decoration: none;">[ Borrar ]</a>
                    </td>
                </tr>
                <?php 
                endwhile; 
            } else {
                echo "<tr><td colspan='4' style='padding:20px; text-align:center;'>No hay comentarios pendientes.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<hr style="margin: 3rem 0; border: 0; border-top: 1px solid var(--border-color);">
<?php
// Consulta para ver cuántas IPs hay bloqueadas actualmente
$sql_bloqueadas = "SELECT COUNT(DISTINCT ip_address) as total FROM login_attempts WHERE exitoso = 0 AND intento_fecha > DATE_SUB(NOW(), INTERVAL 15 MINUTE) GROUP BY ip_address HAVING COUNT(*) >= 5";
$res_b = $conn->query($sql_bloqueadas);
$num_bloqueos = $res_b ? $res_b->num_rows : 0;
?>

<p style="background: <?php echo $num_bloqueos > 0 ? '#da3633' : '#238636'; ?>; padding: 10px; border-radius: 5px; color: white;">
    <strong>Estado de Seguridad:</strong> <?php echo $num_bloqueos; ?> IP(s) bloqueadas actualmente.
</p>
<section>
    <h3>🚨 Últimos Intentos de Acceso</h3>
    <table style="width: 100%; border-collapse: collapse; margin-top: 1rem; background: var(--bg-card); border-radius: 8px;">
        <thead>
            <tr style="background: #161b22; text-align: left;">
                <th style="padding: 12px;">IP</th>
                <th style="padding: 12px;">Fecha</th>
                <th style="padding: 12px;">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_logs = "SELECT ip_address, intento_fecha, exitoso FROM login_attempts ORDER BY intento_fecha DESC LIMIT 5";
            $res_logs = $conn->query($sql_logs);
            while($log = $res_logs->fetch_assoc()):
            ?>
            <tr style="border-bottom: 1px solid #21262d;">
                <td style="padding: 12px;"><?php echo $log['ip_address']; ?></td>
                <td style="padding: 12px;"><?php echo date("d/m H:i", strtotime($log['intento_fecha'])); ?></td>
                <td style="padding: 12px;">
                    <?php echo $log['exitoso'] ? '<span style="color: #238636;">Éxito</span>' : '<span style="color: #da3633;">FALLO</span>'; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>
<?php 
$conn->close();
include('includes/footer.php'); 
?>
