<?php
session_start();
include_once "../db/conexion.php";

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : null;

// Obtener el término de búsqueda
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

$query = "SELECT p.id, p.titulo, p.descripcion, p.fecha_publicacion, u.username 
        FROM preguntas p
        JOIN usuarios u ON p.usuario_id = u.id";

// Si hay un término de búsqueda, agregar filtro a la consulta
if (!empty($searchTerm)) {
    $query .= " WHERE p.titulo LIKE :search OR p.descripcion LIKE :search";
}

$query .= " ORDER BY p.fecha_publicacion DESC";

$stmt = $pdo->prepare($query);

// Vincular parámetro de búsqueda si es necesario
if (!empty($searchTerm)) {
    $stmt->bindValue(':search', "%$searchTerm%", PDO::PARAM_STR);
}

$stmt->execute();

$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForoCode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/questions.css">
</head>
<body id="body" class="light-mode">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ForoCode</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <form class="d-flex me-auto" role="search" method="GET" action="questions.php">
                    <input class="form-control me-2 search-bar" type="search" placeholder="Buscar en ForoCode" aria-label="Search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 sidebar">
                <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='../index.php'">Inicio</button>
                <button class="btn btn-sidebar w-100 mb-3" id="selection">Preguntas</button>
                <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='users.php'">Usuarios</button>
                <button class="btn btn-sidebar w-100" onclick="window.location.href='chats.php'">Chats</button>
            </div>
            <div class="col-lg-7 col-md-6 col-12 content-right">
                <h3>
                    <?php
                    if (!empty($searchTerm)) {
                        echo "Resultados para: " . htmlspecialchars($searchTerm);
                    } else {
                        echo "Todas las preguntas";
                    }
                    ?>
                </h3>
                <?php
                if ($questions) {
                    foreach ($questions as $row) {
                        echo '<div class="question-item">';
                        echo '<div class="question-header">';
                        echo '<h5><a href="./view_question.php?id=' . $row['id'] . '">' . htmlspecialchars($row['titulo']) . '</a></h5>';
                        echo '<p><strong>' . htmlspecialchars($row['username']) . '</strong> - <small>' . date("d M Y", strtotime($row['fecha_publicacion'])) . '</small></p>';
                        echo '</div>';
                        echo '<p class="question-description">' . nl2br(htmlspecialchars($row['descripcion'])) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No se encontraron preguntas que coincidan con tu búsqueda.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>