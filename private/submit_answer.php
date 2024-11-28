<?php
session_start();
require '../db/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: ../public/login.php");
        exit();
    }

    $pregunta_id = filter_input(INPUT_POST, 'pregunta_id', FILTER_VALIDATE_INT);
    $contenido = htmlspecialchars(trim($_POST['contenido']));
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($contenido)) {
        header("Location: ../public/view_question.php?id=" . $pregunta_id . "&error=empty_content");
        exit();
    }

    try {
        $sql = "INSERT INTO respuestas (pregunta_id, usuario_id, contenido) VALUES (:pregunta_id, :usuario_id, :contenido)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':contenido', $contenido, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: ../public/view_question.php?id=" . $pregunta_id);
        exit();
    } catch (PDOException $e) {
        echo "Error al publicar la respuesta: " . htmlspecialchars($e->getMessage());
    }
}
?>
