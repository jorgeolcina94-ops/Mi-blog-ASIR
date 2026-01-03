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
            <pre>ls -lah              # Listar archivos con detalles y tamaños legibles
mkdir -p ruta/nueva  # Crear carpetas anidadas
rm -rf carpeta/      # Borrado recursivo y forzado (¡Cuidado!)
cp -r origen destino # Copiar carpetas recursivamente
chmod 755 archivo    # Cambiar permisos (rwxr-xr-x)</pre>

            <h2>🌐 Redes y Conectividad</h2>
            <pre>ip a                 # Ver direcciones IP de las interfaces
ip route             # Ver la tabla de enrutamiento
ping -c 4 google.com # Probar conectividad básica
netstat -tunlp       # Ver puertos abiertos y procesos
ssh usuario@ip       # Conexión segura remota</pre>

            <h2>⚙️ Gestión del Sistema</h2>
            <pre>sudo apt update && sudo apt upgrade -y  # Actualizar el sistema
systemctl status apache2                # Estado de un servicio
htop                                    # Monitor de procesos interactivo
df -h                                   # Ver espacio libre en disco
uname -a                                # Información del kernel y sistema</pre>

            <h2>🐍 Bases de Datos (MariaDB)</h2>
            <pre>sudo mariadb -u root -p                 # Entrar a la consola
SHOW DATABASES;                         # Listar bases de datos
USE nombre_db;                          # Seleccionar una base de datos
SELECT * FROM publicaciones;            # Ver datos de una tabla</pre>
        </div>

        <footer style="margin-top: 3rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
            <a href="index.php" class="btn" style="text-decoration: none;">&larr; Volver al Inicio</a>
        </footer>
    </article>
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
