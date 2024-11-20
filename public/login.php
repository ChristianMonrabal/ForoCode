<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: ../index.php");
    exit();
}

$section = isset($_GET['section']) ? $_GET['section'] : 'signin';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de ForoCode</title>
    <link rel="stylesheet" href="../css/form.css">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container" id="signUpContainer">
        <form action="../private/register.php" method="POST">
            <h1>Crea tu cuenta</h1>
            <br>
            <input type="text" name="username" placeholder="Introduce el nombre de tu usuario" value="<?php echo isset($_SESSION['signup_username']) ? htmlspecialchars($_SESSION['signup_username']) : ''; ?>" />
            <input type="text" name="nombre_real" placeholder="Introduce tu nombre y apellidos" value="<?php echo isset($_SESSION['nombre_real']) ? htmlspecialchars($_SESSION['nombre_real']) : ''; ?>" />
            <input type="email" name="email" placeholder="Introduce tu correo electrónico" value="<?php echo isset($_SESSION['signup_email']) ? htmlspecialchars($_SESSION['signup_email']) : ''; ?>" />
            <input type="password" name="password" placeholder="Introduce tu contraseña" />
            <input type="password" name="repeat_password" placeholder="Introduce de nuevo tu contraseña" />
            <br>
            <?php
            if (isset($_SESSION['error']) && isset($_SESSION['section']) && $_SESSION['section'] === 'signup') {
                echo "<span class='error'>{$_SESSION['error']}</span>";
                unset($_SESSION['error']);
                unset($_SESSION['section']);
            }
            ?>
            <button type="submit">Registrarse</button>
            <br>
        </form>

        </div>
        <div class="form-container sign-in-container" id="signInContainer">
            <form action="../private/access.php" method="POST">
                <h1>Iniciar sesión en ForoCode</h1>
                <br>
                <input type="email" name="email" placeholder="Introduce tu correo electrónico" value="<?php echo isset($_SESSION['signin_email']) ? htmlspecialchars($_SESSION['signin_email']) : ''; ?>" />
                <input type="password" name="password" placeholder="Introduce tu contraseña" />
                <br>
                <?php
                if (isset($_SESSION['error']) && isset($_SESSION['section']) && $_SESSION['section'] === 'signin') {
                    echo "<span class='error'>{$_SESSION['error']}</span>";
                    unset($_SESSION['error']);
                    unset($_SESSION['section']);
                }
                ?>
                <button type="submit">Iniciar sesión</button>
                <br>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bienvenid@ a ForoCode</h1>
                    <p>Regístrate para empezar o</p>
                    <button class="ghost" id="signIn" onclick="toggleForm('signin')">Inicia sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Bienvenid@ de nuevo</h1>
                    <p>Inicia sesión para acceder al foro o</p>
                    <button class="ghost" id="signUp" onclick="toggleForm('signup')">Crea tu cuenta</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/form.js"></script>
</body>
</html>