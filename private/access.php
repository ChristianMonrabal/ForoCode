<?php
session_start();

require '../db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $signin_email = isset($_POST['email']) ? trim($_POST['email']) : '';
    if (empty($signin_email)) {
        $_SESSION['error'] = "El correo electrónico es obligatorio.";
        $_SESSION['section'] = 'signin';
        header("Location: ../public/login.php?section=signin");
        exit();
    } else {
        $_SESSION['signin_email'] = htmlspecialchars($signin_email);
    }

    $signin_password = isset($_POST['password']) ? $_POST['password'] : '';
    if (empty($signin_password)) {
        $_SESSION['error'] = "La contraseña es obligatoria.";
        $_SESSION['section'] = 'signin';
        header("Location: ../public/login.php?section=signin");
        exit();
    }

    try {
        $query = "SELECT * FROM Usuarios WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $signin_email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($signin_password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nombre_real'] = $user['nombre_real'];
            $_SESSION['email'] = $user['email'];
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['error'] = "El correo electrónico o la contraseña son incorrectos.";
            $_SESSION['section'] = 'signin';
            header("Location: ../public/login.php?section=signin");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error en el sistema: " . $e->getMessage();
        $_SESSION['section'] = 'signin';
        header("Location: ../public/login.php?section=signin");
        exit();
    }
}
?>
