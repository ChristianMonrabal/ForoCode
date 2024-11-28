<?php
session_start();
require '../db/conexion.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: ./login.php");
    exit();
}

$isLoggedIn = isset($_SESSION['loggedin']) === true;
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : null;

$usuario_id = $_SESSION['usuario_id'];
$pregunta_id = $_GET['id'];
$error_message_titulo = ""; 
$error_message_descripcion = ""; 
$titulo = ""; 
$descripcion = ""; 

try {
    $sql = "SELECT * FROM preguntas WHERE id = ? AND usuario_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pregunta_id, $usuario_id]);
    $pregunta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pregunta) {
        echo "Pregunta no encontrada o no tienes permiso para editarla.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = trim($_POST['titulo']);
        $descripcion = trim($_POST['descripcion']);

        if (empty($titulo)) {
            $error_message_titulo = "El título no puede estar vacío.";
        }
        if (empty($descripcion)) {
            $error_message_descripcion = "La descripción no puede estar vacía.";
        }

        if (empty($error_message_titulo) && empty($error_message_descripcion)) {
            try {
                $sql = "UPDATE preguntas SET titulo = ?, descripcion = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$titulo, $descripcion, $pregunta_id]);
                header("Location: ./view_question.php?id=" . $pregunta_id);
                exit();
            } catch (PDOException $e) {
                $error_message_descripcion = "Error al actualizar la pregunta: " . $e->getMessage();
            }
        }
    } else {
        $titulo = $pregunta['titulo'];
        $descripcion = $pregunta['descripcion'];
    }
} catch (PDOException $e) {
    echo "Error al obtener la pregunta: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForoCode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/edit_question.css">
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
    <div class="container mt-4">
        <div class="form-container">
            <h1 class="text-center mb-4">Editar Pregunta</h1>
            <form action="./edit_question.php?id=<?php echo $pregunta_id; ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $pregunta['id']; ?>">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php if (!empty($error_message_titulo)): ?>
                        <div class="alert alert-danger mt-1"><?php echo htmlspecialchars($error_message_titulo); ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required><?php echo htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    <?php if (!empty($error_message_descripcion)): ?>
                        <div class="alert alert-danger mt-1"><?php echo htmlspecialchars($error_message_descripcion); ?></div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary w-100">Actualizar</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>