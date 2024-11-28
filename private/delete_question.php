<?php
session_start();
require '../db/conexion.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../public/login.php");
    exit();
}

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    echo "ID de pregunta no válido.";
    exit();
}

$pregunta_id = intval($_GET['id']); 
$usuario_id = $_SESSION['usuario_id'];

try {
    $sql = "DELETE FROM preguntas WHERE id = :id AND usuario_id = :usuario_id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("Location: ../public/profile.php?msg=success");
        exit();
    } else {
        echo "No se pudo eliminar la pregunta o no tienes permiso para hacerlo.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error al eliminar la pregunta: " . htmlspecialchars($e->getMessage());
    exit();
}
?>
