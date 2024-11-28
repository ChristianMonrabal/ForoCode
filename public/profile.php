<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: ./login.php");
    exit();
}

include_once "../db/conexion.php";

$section = isset($_GET['section']) ? $_GET['section'] : 'signin';

$isLoggedIn = isset($_SESSION['loggedin']) === true;
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : null;

$usuario_id = $_SESSION['usuario_id'];

try {
    $sql = "SELECT * FROM preguntas WHERE usuario_id = ? ORDER BY fecha_publicacion DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario_id]);
    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener las preguntas: " . $e->getMessage();
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
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body id="body" class="light-mode">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">ForoCode</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                <ul class="navbar-nav ms-auto">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="./public/create_question.php">Nueva pregunta</a>
                        </li>
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
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-3 col-12 sidebar">
            <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='../index.php'">Inicio</button>
            <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='./questions.php'">Preguntas</button>
            <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='./users.php'">Usuarios</button>
            <button class="btn btn-sidebar w-100" onclick="window.location.href='./chats.php'">Chats</button>
        </div>
        <div class="col-lg-7 col-md-6 col-12 content-right">
            <h1>Perfil de Usuario</h1>
            <h2>Mis Preguntas</h2>
            <?php if (!empty($preguntas)): ?>
                <?php foreach ($preguntas as $pregunta): ?>
                    <div class="question-item">
                        <div class="question-header">
                            <h5>
                                <a href="./view_question.php?id=<?php echo $pregunta['id']; ?>">
                                    <?php echo htmlspecialchars($pregunta['titulo']); ?>
                                </a>
                            </h5>
                            <p>
                                <small>Publicado el <?php echo date("d M Y", strtotime($pregunta['fecha_publicacion'])); ?></small>
                            </p>
                        </div>
                        <p class="question-description"><?php echo nl2br(htmlspecialchars($pregunta['descripcion'])); ?></p>
                        <a href="../public/edit_question.php?id=<?php echo $pregunta['id']; ?>" class="btn btn-success btn-sm">Editar</a>
                        <a href="../private/delete_question.php?id=<?php echo $pregunta['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No has publicado ninguna pregunta todavía.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
