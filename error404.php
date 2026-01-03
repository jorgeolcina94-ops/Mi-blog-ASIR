<?php include('includes/header.php'); ?>

<main class="container" style="display: flex; align-items: center; justify-content: center; min-height: 60vh;">
    <article class="card" style="border: 1px solid #da3633; max-width: 600px; width: 100%;">
        <header style="background: rgba(218, 54, 51, 0.1); padding: 10px; border-bottom: 1px solid #da3633;">
            <strong style="color: #da3633;"> [ CRITICAL ERROR: 404 ] </strong>
        </header>
        
        <div class="post-content" style="padding: 20px; font-family: 'Fira Code', monospace;">
            <p style="color: #da3633; font-weight: bold;">> STATUS: REQUESTED_URL_NOT_FOUND</p>
            <p>> El recurso que buscas ha sido movido, eliminado o nunca existió en este servidor.</p>
            
            <div style="background: #0d1117; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <code style="color: #c9d1d9;">
                    $ check_route --target <?php echo $_SERVER['REQUEST_URI']; ?><br>
                    <span style="color: #da3633;">Error: Command not found.</span>
                </code>
            </div>

            <p>¿Qué desea hacer, administrador?</p>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <a href="/index.php" class="btn" style="background: #238636; border-color: #2ea043;">cd /home/inicio</a>
                <a href="javascript:history.back()" class="btn" style="background: transparent; border: 1px solid #30363d;">cd .. (volver)</a>
            </div>
        </div>
    </article>
</main>

<?php include('includes/footer.php'); ?>
