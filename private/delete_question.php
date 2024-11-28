<?php
session_start();
require '../db/conexion.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: ../public/login.php");
    exit();
}

$pregunta_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

try {
    $sql = "DELETE FROM preguntas WHERE id = ? AND usuario_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pregunta_id, $usuario_id]);

    header("Location: ../public/profile.php");
    exit();
} catch (PDOException $e) {
    echo "Error al eliminar la pregunta: " . $e->getMessage();
}
?> 