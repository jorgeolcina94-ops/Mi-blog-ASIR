<?php
session_start();
// Seguridad: Solo el admin logueado puede borrar
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include('../db/db_config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM comentarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: admin.php?msg=comentario_borrado");
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>
