<?php
session_start();
require '../db/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pregunta_id = $_POST['id'];
    $titulo = htmlspecialchars(trim($_POST['titulo']));
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));
    $usuario_id = $_SESSION['usuario_id'];

    try {
        $sql = "UPDATE preguntas SET titulo = ?, descripcion = ? WHERE id = ? AND usuario_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titulo, $descripcion,$pregunta_id, $usuario_id]);

        header("Location: ../public/profile.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar la pregunta: " . $e->getMessage();
    }
}
?> 