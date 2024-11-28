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
        $_SESSION['error_message'] = "El contenido de la respuesta no puede estar vacío.";
        header("Location: ../public/view_question.php?id=" . $pregunta_id);
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
        $_SESSION['error_message'] = "Error al publicar la respuesta: " . htmlspecialchars($e->getMessage());
        header("Location: ../public/view_question.php?id=" . $pregunta_id);
        exit();
    }
}
?>
