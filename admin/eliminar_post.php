<?php
session_start();
// 1. Verificación de seguridad: ¿Está logueado?
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include('../db/db_config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 2. Primero buscamos si tiene una imagen para borrarla del disco
    $stmt_img = $conn->prepare("SELECT imagen_url FROM publicaciones WHERE id = ?");
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $res_img = $stmt_img->get_result()->fetch_assoc();

    if ($res_img && !empty($res_img['imagen_url'])) {
        // Borra el archivo físico en la carpeta uploads/
        if (file_exists($res_img['imagen_url'])) {
            unlink($res_img['imagen_url']);
        }
    }

    // 3. Borramos el registro de la base de datos
    $stmt_del = $conn->prepare("DELETE FROM publicaciones WHERE id = ?");
    $stmt_del->bind_param("i", $id);
    
    if ($stmt_del->execute()) {
        header("Location: admin.php?msg=eliminado");
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
    
    $stmt_del->close();
}
$conn->close();
?>
