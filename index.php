<?php include('includes/header.php'); ?>

<main class="container">
    <header class="hero">
        <div class="status-badge">
            <span class="status-dot"></span> System Status: Online
        </div>
        <h1>Diario de un Administrador de Sistemas</h1>
        <p>Documentando laboratorios, despliegues y soluciones técnicas en mi Raspberry Pi.</p>
    </header>

    <section id="labs">
        <h2 class="section-title">01. Laboratorios Recientes</h2>
        <div class="lab-grid">
            <article class="card">
                <span>Database</span>
                <h3>Instalación de MariaDB</h3>
                <p>Configuración inicial del motor de base de datos y securización con mysql_secure_installation.</p>
            </article>

            <article class="card">
                <span>Redes</span>
                <h3>Túnel de Cloudflare</h3>
                <p>Exponiendo mi servidor local de forma segura sin abrir puertos en el router.</p>
            </article>
        </div>
    </section>

    <section id="scripts">
        <h2 class="section-title">02. Scripts de Automatización</h2>
        <div class="card" style="width: 100%;">
            <span>Bash</span>
            <h3>Update & Upgrade Automático</h3>
            <div class="script-preview">
                <span style="color: #ff7b72;">#!/bin/bash</span><br>
                sudo apt update && sudo apt upgrade -y
            </div>
        </div>
    </section>
</main>

<?php include('includes/footer.php'); ?>
