<?php
session_start();
require '../db/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pregunta_id = $_POST['id'];
    $titulo = htmlspecialchars(trim($_POST['titulo']));
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));
    $usuario_id = $_SESSION['usuario_id'];

    try {
        $sql = "UPDATE preguntas SET titulo = :titulo, descripcion = :descripcion WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../public/profile.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar la pregunta: " . htmlspecialchars($e->getMessage());
    }
}
?>
