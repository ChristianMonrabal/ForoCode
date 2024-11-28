<?php
session_start();
require '../db/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pregunta_id = $_POST['pregunta_id'];
    $contenido = htmlspecialchars(trim($_POST['contenido']));
    $usuario_id = $_SESSION['usuario_id'];

    try {
        $sql = "INSERT INTO respuestas (pregunta_id, usuario_id, contenido) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pregunta_id, $usuario_id, $contenido]);

        header("Location: ../public/view_question.php?id=" . $pregunta_id);
        exit();
    } catch (PDOException $e) {
        echo "Error al publicar la respuesta: " . $e->getMessage();
    }
}
?> 