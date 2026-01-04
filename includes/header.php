<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIR Tech Blog | Explorando el Sistema | Jorge Olcina</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Inter:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css?v=Final">
    <link rel="icon" href="/uploads/faviconweb.png">
</head>
<body>
<nav class="navbar">
    <div class="nav-container">
        <a href="/index.php" class="logo">~/asir-student/jorge</a>

        <button class="menu-toggle" id="mobile-menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <ul class="nav-links" id="nav-list">
            <li><a href="/index.php">Inicio</a></li>
            <li><a href="/index.php#labs">Laboratorios</a></li>
            <li><a href="/recursos.php">Recursos</a></li>
            
            <?php 
            // Verificamos sesión, aunque header se incluya antes de session_start en algunos casos,
            // funcionará si la sesión ya está iniciada en el archivo padre.
            if(isset($_SESSION['usuario_id'])): ?>
                <li><a href="/admin/admin.php" style="color: #e3b341;">Admin</a></li>
                <li><a href="/logout.php">Salir</a></li>
            <?php else: ?>
                <li><a href="/login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
