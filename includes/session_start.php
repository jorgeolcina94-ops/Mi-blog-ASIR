<?php
// Configuración de cookies de sesión antes de iniciarla
ini_set('session.cookie_httponly', 1); // Evita que JS acceda a la cookie
ini_set('session.cookie_secure', 1);   // Solo se envía por HTTPS
ini_set('session.use_only_cookies', 1); // Evita ataques de fijación de sesión

session_start();

// Regenerar el ID de sesión periódicamente para evitar robos
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} else if (time() - $_SESSION['created'] > 1800) { // Cada 30 min
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}
?>
