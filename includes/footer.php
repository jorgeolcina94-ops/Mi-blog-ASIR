<script>
document.addEventListener('DOMContentLoaded', () => {
    // Buscamos todos los bloques <pre> en cualquier página
    document.querySelectorAll('pre').forEach((block) => {
        // Creamos el botón
        const button = document.createElement('button');
        button.className = 'copy-button';
        button.type = 'button';
        button.innerText = '📋 COPIAR';
        
        // Lo metemos dentro del bloque de código
        block.appendChild(button);

        button.addEventListener('click', () => {
            // Limpiamos el texto para no copiar la palabra "COPIAR"
            const textToCopy = block.innerText.replace('📋 COPIAR', '').trim();
            
            navigator.clipboard.writeText(textToCopy).then(() => {
                button.innerText = '✅ LISTO';
                setTimeout(() => button.innerText = '📋 COPIAR', 2000);
            });
        });
    });
});
</script>
<footer>
        <p>&copy; <?php echo date("Y"); ?> - Desplegado en Raspberry Pi 3A+ | Jorge Olcina</p>
    </footer>
<script>
function iniciarEfectoEscritura(elementoId, textoOriginal, velocidad = 100) {
    const contenedor = document.getElementById(elementoId);
    if (!contenedor) return;

    contenedor.innerHTML = ""; // Limpiamos el texto inicial
    contenedor.classList.add("typing"); // Añadimos el cursor
    
    let i = 0;
    function escribir() {
        if (i < textoOriginal.length) {
            contenedor.innerHTML += textoOriginal.charAt(i);
            i++;
            setTimeout(escribir, velocidad);
        }
    }
    escribir();
}

// Ejecutar cuando cargue el DOM
document.addEventListener("DOMContentLoaded", () => {
    // Para el título principal en index.php
    const tituloPrincipal = document.querySelector(".hero h1");
    if (tituloPrincipal) {
        const texto = tituloPrincipal.innerText;
        tituloPrincipal.id = "type-main";
        iniciarEfectoEscritura("type-main", texto, 70);
    }

    // Para el título del post en post.php
    const tituloPost = document.querySelector(".full-post h1");
    if (tituloPost) {
        const textoPost = tituloPost.innerText;
        tituloPost.id = "type-post";
        iniciarEfectoEscritura("type-post", textoPost, 50);
    }
});
</script>
</body>
</html>
