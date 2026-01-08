<?php
include('db/db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = intval($_POST['post_id']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $comentario = htmlspecialchars($_POST['comentario']);

    if (!empty($nombre) && !empty($comentario)) {
        $stmt = $conn->prepare("INSERT INTO comentarios (post_id, nombre, comentario) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $post_id, $nombre, $comentario);
        $stmt->execute();
        $stmt->close();
    }
    
    // Volvemos al post
    header("Location: post.php?id=" . $post_id);
    exit();
}
?>
