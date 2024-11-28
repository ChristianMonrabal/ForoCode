<?php
session_start();
require '../db/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = htmlspecialchars(trim($_POST['titulo']));
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));
    $usuario_id = $_SESSION['usuario_id'];

    try {
        $sql = "INSERT INTO preguntas (usuario_id, titulo, descripcion) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario_id, $titulo, $descripcion]);

        header("Location: ../index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al publicar la pregunta: " . $e->getMessage();
    }
}
?> 