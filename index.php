<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIR Portafolio | Jorge Olcina</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Inter:wght@300;400;700&display=swap" rel="stylesheet">
    </head>
<body>

    <nav>
        <div class="logo">~/Jorge Olcina</div>
        <div class="nav-links">
            <a href="#labs">Laboratorios</a>
            <a href="#scripts">Scripts</a>
            <a href="#about">Sobre mí</a>
        </div>
    </nav>

    <main class="container">
        <header class="hero">
            <div class="status-badge">
                <span class="status-dot"></span> System Status: Online
            </div>
            <h1>Documentando el despliegue de mi carrera IT.</h1>
            <p>Soy estudiante de ASIR apasionado por la automatización, la seguridad en redes y el mundo Linux. Aquí comparto mis configuraciones y soluciones a problemas reales.</p>
        </header>

        <section id="labs">
            <h2 class="section-title">01. Laboratorios Técnicos</h2>
            <div class="lab-grid">
                <article class="card">
                    <span>Networking</span>
                    <h3>VLANs en Cisco Packet Tracer</h3>
                    <p>Configuración de segmentación de red y Trunking para una oficina pequeña.</p>
                </article>

                <article class="card">
                    <span>Linux Server</span>
                    <h3>DHCP y DNS en Debian 12</h3>
                    <p>Levantando servicios críticos de red usando Bind9 e ISC-DHCP-Server.</p>
                </article>

                <article class="card">
                    <span>Virtualización</span>
                    <h3>Cluster Proxmox VE</h3>
                    <p>Guía paso a paso sobre cómo montar un cluster de alta disponibilidad.</p>
                </article>
            </div>
        </section>

        <section id="scripts">
            <h2 class="section-title">02. Automatización & Scripts</h2>
            <div class="card" style="width: 100%;">
                <span>Bash Scripting</span>
                <h3>Backup Automático de Bases de Datos</h3>
                <p>Un pequeño script que creé para automatizar copias de seguridad en un servidor remoto mediante SCP.</p>
                <div class="script-preview">
                    <span style="color: #ff7b72;">#!/bin/bash</span><br>
                    <span style="color: #79c0ff;">BACKUP_DIR</span>="/mnt/backups"<br>
                    <span style="color: #79c0ff;">DATE</span>=$(date +%Y-%m-%d)<br>
                    <span style="color: #d2a8ff;">echo</span> "Iniciando backup del sistema..."
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>Construido con HTML/CSS puro por un futuro SysAdmin. © 2025</p>
    </footer>

</body>
</html>
