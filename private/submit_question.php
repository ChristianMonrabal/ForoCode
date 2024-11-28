<?php
session_start();
require '../db/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = htmlspecialchars(trim($_POST['titulo']));
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));
    $usuario_id = $_SESSION['usuario_id'];

    try {
        $sql = "INSERT INTO preguntas (usuario_id, titulo, descripcion) VALUES (:usuario_id, :titulo, :descripcion)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: ../index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al publicar la pregunta: " . htmlspecialchars($e->getMessage());
    }
}
?>
