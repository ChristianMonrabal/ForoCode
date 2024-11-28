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
$usuario_id = $_SESSION['usuario_id'];

try {
    $sql = "SELECT * FROM preguntas WHERE id = ? AND usuario_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pregunta_id, $usuario_id]);
    $pregunta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pregunta) {
        echo "Pregunta no encontrada o no tienes permiso para editarla.";
        exit();
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
            <a class="navbar-brand" href="#">ForoCode</a>
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
            <form action="../private/update_question.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $pregunta['id']; ?>">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="titulo" 
                        name="titulo" 
                        value="<?php echo htmlspecialchars($pregunta['titulo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea 
                        class="form-control" 
                        id="descripcion" 
                        name="descripcion" 
                        rows="5" 
                        required><?php echo htmlspecialchars($pregunta['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Actualizar</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>