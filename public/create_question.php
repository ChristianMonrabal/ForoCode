<?php
session_start();
include_once "../db/conexion.php";

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

if (!$isLoggedIn) {
    header("Location: ../public/login.php");
    exit(); 
}

$username = htmlspecialchars($_SESSION['username']);
$errores = [];

$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$usuario_id = $stmt->fetchColumn(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($titulo)) {
        $errores['titulo'] = "El título es obligatorio.";
    }

    if (empty($descripcion)) {
        $errores['descripcion'] = "La descripción es obligatoria.";
    }

    if (empty($errores)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO preguntas (usuario_id, titulo, descripcion, etiquetas) VALUES (:usuario_id, :titulo, :descripcion, :etiquetas)");
            $etiquetas = '';
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':etiquetas', $etiquetas);

            if ($stmt->execute()) {
                header("Location: ../index.php");
                exit();
            } else {
                $errores['general'] = "Error al publicar la pregunta. Inténtalo de nuevo.";
            }
        } catch (PDOException $e) {
            $errores['general'] = "Error en la base de datos: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pregunta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/create_question.css">
</head>
<body id="body" class="light-mode">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">ForoCode</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <form class="d-flex me-auto" role="search">
                    <input class="form-control me-2 search-bar" type="search" placeholder="Buscar en ForoCode" aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit">Buscar</button>
                </form>
                <ul class="navbar-nav ms-auto">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $username; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="profile.php">Ver perfil</a></li>
                            <li><a class="dropdown-item" href="../private/logout.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-login" href="./login.php">Iniciar sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <form class="question-form" id="questionForm" action="" method="POST" novalidate>
    <h1 class="form-title">Publicar una nueva pregunta</h1>

    <div class="form-group">
        <input id="titulo" class="form-control <?php echo isset($errores['titulo']) ? 'is-invalid' : ''; ?>" type="text" name="titulo" placeholder="Título de la pregunta" value="<?php echo isset($titulo) ? htmlspecialchars($titulo) : ''; ?>">
        <div  id="errorTitulo">
            <?php echo isset($errores['titulo']) ? htmlspecialchars($errores['titulo']) : ''; ?>
        </div>
    </div>

    <div class="form-group">
        <textarea id="descripcion" class="form-textarea form-control <?php echo isset($errores['descripcion']) ? 'is-invalid' : ''; ?>" name="descripcion" placeholder="Descripción de la pregunta"><?php echo isset($descripcion) ? htmlspecialchars($descripcion) : ''; ?></textarea>
        <div  id="errorDescripcion">
            <?php echo isset($errores['descripcion']) ? htmlspecialchars($errores['descripcion']) : ''; ?>
        </div>
    </div>

    <?php if (isset($errores['general'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($errores['general']); ?></div>
    <?php endif; ?>

    <button class="form-submit" type="submit">Publicar</button>
</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/form.js"></script>
</body>
</html> 