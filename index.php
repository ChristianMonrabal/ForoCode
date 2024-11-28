<?php
session_start();
include_once "./db/conexion.php";

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : null;

// Definir la consulta base para las preguntas
$query = "SELECT p.id, p.titulo, p.descripcion, p.fecha_publicacion, u.username 
          FROM preguntas p
          JOIN usuarios u ON p.usuario_id = u.id";

// Si se realiza una búsqueda
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($searchTerm) {
    if (strpos($searchTerm, 'user:') === 0) {
        // Buscar usuarios
        $searchTerm = substr($searchTerm, 5); // Eliminar 'user:' del término de búsqueda
        
        // Buscar usuarios que coincidan con el nombre
        $query = "SELECT id, username 
                  FROM usuarios 
                  WHERE username LIKE ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['%' . $searchTerm . '%']);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Usuarios encontrados
        
        // Si se encontraron usuarios, buscamos las preguntas de esos usuarios
        if ($users) {
            $userIds = array_map(function($user) {
                return $user['id'];
            }, $users);

            $userIdsPlaceholder = implode(',', array_fill(0, count($userIds), '?'));
            $query = "SELECT p.id, p.titulo, p.descripcion, p.fecha_publicacion, u.username 
                      FROM preguntas p
                      JOIN usuarios u ON p.usuario_id = u.id
                      WHERE p.usuario_id IN ($userIdsPlaceholder)";
            $stmt = $pdo->prepare($query);
            $stmt->execute($userIds);
            $questions = $stmt->fetchAll(PDO::FETCH_ASSOC); // Preguntas encontradas de esos usuarios
        } else {
            $questions = []; // Si no hay usuarios, no hay preguntas que mostrar
        }
    } elseif (strpos($searchTerm, 'question:') === 0) {
        // Buscar preguntas
        $searchTerm = substr($searchTerm, 9); // Eliminar 'question:' del término de búsqueda
        $query = "SELECT p.id, p.titulo, p.descripcion, p.fecha_publicacion, u.username 
                  FROM preguntas p
                  JOIN usuarios u ON p.usuario_id = u.id
                  WHERE p.titulo LIKE ? OR p.descripcion LIKE ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['%' . $searchTerm . '%', '%' . $searchTerm . '%']);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC); // Preguntas encontradas
    } else {
        // Si no hay un filtro específico, buscamos tanto por usuarios como preguntas
        $query .= " WHERE p.titulo LIKE ? OR p.descripcion LIKE ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['%' . $searchTerm . '%', '%' . $searchTerm . '%']);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC); // Preguntas encontradas
    }
} else {
    // Si no hay búsqueda, mostramos las preguntas recientes
    $query .= " ORDER BY p.fecha_publicacion DESC LIMIT 10";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="./css/index.css">
</head>
<body id="body" class="light-mode">
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ForoCode</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <form class="d-flex me-auto" role="search" method="GET">
                <input class="form-control me-2 search-bar" type="search" name="search" placeholder="Buscar en ForoCode" aria-label="Search">
                <button class="btn btn-outline-dark" type="submit">Buscar</button>
            </form>
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
                            <li><a class="dropdown-item" href="./public/profile.php">Ver perfil</a></li>
                            <li><a class="dropdown-item" href="./private/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-login" href="./public/login.php">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-3 col-12 sidebar">
            <button class="btn btn-sidebar w-100 mb-3" id="selection">Inicio</button>
            <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='public/questions.php'">Preguntas</button>
            <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='./public/users.php'">Usuarios</button>
            <button class="btn btn-sidebar w-100" onclick="window.location.href='./public/chats.php'">Chats</button>
        </div>
        <div class="col-lg-7 col-md-6 col-12 content-right">
            <h3>Resultados de la búsqueda</h3>
            <?php
            if (isset($users)) {
                if ($users) {
                    foreach ($users as $user) {
                        echo '<div class="user-item">';
                        echo '<h5>' . htmlspecialchars($user['username']) . '</h5>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay usuarios que coincidan con la búsqueda.</p>';
                }
            } elseif (isset($questions)) {
                if ($questions) {
                    foreach ($questions as $row) {
                        echo '<div class="question-item">';
                        echo '<div class="question-header">';
                        echo '<h5><a href="./public/view_question.php?id=' . $row['id'] . '">' . htmlspecialchars($row['titulo']) . '</a></h5>';
                        echo '<p><strong>' . htmlspecialchars($row['username']) . '</strong> - <small>' . date("d M Y", strtotime($row['fecha_publicacion'])) . '</small></p>';
                        echo '</div>';
                        echo '<p class="question-description">' . nl2br(htmlspecialchars($row['descripcion'])) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay resultados para la búsqueda.</p>';
                }
            }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$pdo = null;
?>
