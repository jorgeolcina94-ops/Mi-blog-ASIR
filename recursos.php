<?php 
include('includes/header.php'); 
?>

<main class="container">
    <article class="full-post">
        <header>
            <span class="status-badge">Cheat Sheet</span>
            <h1 id="type-recursos">Recursos: Comandos Esenciales Linux</h1>
            <p class="post-meta">Una guía rápida de referencia para administración de sistemas.</p>
        </header>

        <div class="post-content">
            <p>Aquí tienes una recopilación de los comandos que más usamos en el día a día de ASIR. Puedes copiarlos directamente usando el botón de la derecha.</p>

            <h2>📁 Gestión de Archivos y Directorios</h2>
            <pre>
ls -lah              # Listar archivos con detalles y tamaños legibles
mkdir -p ruta/nueva  # Crear carpetas anidadas
rm -rf carpeta/      # Borrado recursivo y forzado (¡Cuidado!)
cp -r origen destino # Copiar carpetas recursivamente
chmod 755 archivo    # Cambiar permisos (rwxr-xr-x)
</pre>

            <h2>🌐 Redes y Conectividad</h2>
            <pre>
ip a                 # Ver direcciones IP de las interfaces
ip route             # Ver la tabla de enrutamiento
ping -c 4 google.com # Probar conectividad básica
netstat -tunlp       # Ver puertos abiertos y procesos
ssh usuario@ip       # Conexión segura remota
</pre>

            <h2>⚙️ Gestión del Sistema</h2>
            <pre>
sudo apt update && sudo apt upgrade -y  # Actualizar el sistema
systemctl status apache2                # Estado de un servicio
htop                                    # Monitor de procesos interactivo
df -h                                   # Ver espacio libre en disco
uname -a                                # Información del kernel y sistema
</pre>

            <h2>🐍 Bases de Datos (MariaDB)</h2>
            <pre>
sudo mariadb -u root -p                 # Entrar a la consola
SHOW DATABASES;                         # Listar bases de datos
USE nombre_db;                          # Seleccionar una base de datos
SELECT * FROM publicaciones;            # Ver datos de una tabla
</pre>
          </div>

        <footer style="margin-top: 3rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
            <a href="index.php" class="btn" style="text-decoration: none;">&larr; Volver al Inicio</a>
        </footer>
    </article>
<h2 style="margin-top: 3rem; color: var(--accent-color);">📜 Scripts de Automatización</h2>
<p>Herramientas listas para ejecutar. Úsalas bajo tu propia responsabilidad en entornos de pruebas.</p>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
    
    <div class="card" style="border: 1px solid #30363d; background: #0d1117;">
        <h4 style="margin-top: 0;">💾 Auto-Backup LAMP</h4>
        <p style="font-size: 0.85rem; color: var(--text-muted);">Respalda base de datos y archivos web en un .tar.gz con rotación de 7 días.</p>
        <pre style="font-size: 0.75rem; padding: 10px !important;">curl -s https://tudominio.es/scripts/backup.sh | bash</pre>
        <a href="/scripts/backup.sh" download style="font-size: 0.8rem; color: var(--accent-color); text-decoration: none;">[ 📥 Descargar .sh ]</a>
    </div>

    <div class="card" style="border: 1px solid #30363d; background: #0d1117;">
        <h4 style="margin-top: 0;">🛡️ Server Hardening</h4>
        <p style="font-size: 0.85rem; color: var(--text-muted);">Configuración básica de UFW, Fail2Ban y deshabilitar login de root por SSH.</p>
        <pre style="font-size: 0.75rem; padding: 10px !important;">sudo bash scripts/secure_me.sh</pre>
        <a href="/scripts/secure_me.sh" download style="font-size: 0.8rem; color: var(--accent-color); text-decoration: none;">[ 📥 Descargar .sh ]</a>
    </div>
	
	 <div class="card" style="border: 1px solid #30363d; background: #0d1117;">
        <h4 style="margin-top: 0;">🛡️Check Tunnel</h4>
        <p style="font-size: 0.85rem; color: var(--text-muted);">Monitor de conexión segura cloudflared.</p>
        <pre style="font-size: 0.75rem; padding: 10px !important;">sudo bash scripts/check_tunnel.sh</pre>
        <a href="/scripts/check_tunnel.sh" download style="font-size: 0.8rem; color: var(--accent-color); text-decoration: none;">[ 📥 Descargar .sh ]</a>
    </div>

</div>
</main>

<script>
    // Activamos el efecto de escritura para esta página
    document.addEventListener("DOMContentLoaded", () => {
        const titulo = document.getElementById("type-recursos");
        if (titulo) {
            const texto = titulo.innerText;
            iniciarEfectoEscritura("type-recursos", texto, 50);
        }
    });
</script>

<?php include('includes/footer.php'); ?>
