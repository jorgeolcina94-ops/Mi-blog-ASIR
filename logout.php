<?php
// 1. Iniciamos la sesión para poder acceder a ella
session_start();

// 2. Quitamos todas las variables de la sesión
session_unset();

// 3. Destruimos la sesión por completo
session_destroy();

// 4. Redirigimos al usuario a la página de login o al inicio
header("Location: login.php");
exit();
?>
