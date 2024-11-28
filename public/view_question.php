<?php
session_start();
require '../db/conexion.php';

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : null;

if (!$isLoggedIn) {
    header("Location: ./login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID de pregunta no proporcionado.";
    exit();
}

$pregunta_id = $_GET['id'];

try {
    $sql = "SELECT * FROM preguntas WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pregunta_id]);
    $pregunta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pregunta) {
        echo "Pregunta no encontrada.";
        exit();
    }

    $sql_respuestas = "SELECT respuestas.*, usuarios.username 
                    FROM respuestas 
                    JOIN usuarios ON respuestas.usuario_id = usuarios.id 
                    WHERE pregunta_id = ? 
                    ORDER BY fecha_publicacion DESC";
    $stmt_respuestas = $pdo->prepare($sql_respuestas);
    $stmt_respuestas->execute([$pregunta_id]);
    $respuestas = $stmt_respuestas->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener la pregunta o respuestas: " . $e->getMessage();
    exit();
}

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['contenido'])) {
        $error_message = "El contenido de la respuesta no puede estar vacío.";
    } else {
        $pregunta_id = $_POST['pregunta_id'];
        $contenido = $_POST['contenido'];

        try {
            $sql = "INSERT INTO respuestas (pregunta_id, usuario_id, contenido) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$pregunta_id, $_SESSION['user_id'], $contenido]);
        } catch (PDOException $e) {
            $error_message = "Error al enviar la respuesta: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pregunta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/view_question.css">
</head>
<body id="body" class="light-mode">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">ForoCode</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <form class="d-flex me-auto" role="search" method="GET" action="questions.php">
                    <input class="form-control me-2 search-bar" type="search" placeholder="Buscar en ForoCode" aria-label="Search" name="search">
                    <button class="btn btn-outline-dark" type="submit">Buscar</button>
                </form>
                <ul class="navbar-nav ms-auto">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo htmlspecialchars($username); ?>
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
    <div class="container mt-4 custom-container">
        <div class="question-details">
            <h1 class="question-title"><?php echo htmlspecialchars($pregunta['titulo']); ?></h1>
            <p class="question-description"><?php echo htmlspecialchars($pregunta['descripcion']); ?></p>
        </div>

        <h2>Responder</h2>
        <form action="../private/submit_answer.php" method="POST">
            <input type="hidden" name="pregunta_id" value="<?php echo htmlspecialchars($pregunta['id']); ?>">
            <div class="mb-3">
                <textarea class="form-control" name="contenido" placeholder="Escribe tu respuesta aquí..." maxlength="500"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Responder</button>
        </form>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <h2 class="mt-4">Respuestas</h2>
        <?php if (empty($respuestas)): ?>
            <p>No hay respuestas todavía. ¡Sé el primero en responder!</p>
        <?php else: ?>
            <ul class="list-group" id="respuestas-list">
                <?php foreach ($respuestas as $respuesta): ?>
                    <li class="list-group-item">
                        <p><?php echo htmlspecialchars($respuesta['contenido']); ?></p>
                        <small>Publicado por <?php echo htmlspecialchars($respuesta['username']); ?> el <?php echo htmlspecialchars($respuesta['fecha_publicacion']); ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
