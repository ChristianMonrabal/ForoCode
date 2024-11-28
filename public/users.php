<?php
session_start();

include_once "../db/conexion.php";

$isLoggedIn = isset($_SESSION['loggedin']) === true;
$username = $isLoggedIn ? htmlspecialchars($_SESSION['username']) : null;

$search = $_GET['search'] ?? '';
$searchQuery = $search ? "WHERE username LIKE :search OR nombre_real LIKE :search" : '';
$sql = "SELECT username, nombre_real, DATE_FORMAT(registration_date, '%Y-%m-%d %H:%i:%s') AS registration_date FROM usuarios $searchQuery ORDER BY registration_date DESC";
$stmt = $pdo->prepare($sql);

if ($search) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - ForoCode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/users.css">
</head>
<body id="body" class="light-mode">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ForoCode</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <form class="d-flex me-auto" role="search" method="GET" action="users.php">
                    <input class="form-control me-2 search-bar" type="search" placeholder="Buscar en ForoCode" aria-label="Search" name="search" value="<?php echo htmlspecialchars($search); ?>">
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
        <div class="col-lg-2 col-md-3 col-12 sidebar">
            <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='../index.php'">Inicio</button>
            <button class="btn btn-sidebar w-100 mb-3" onclick="window.location.href='./questions.php'">Preguntas</button>
            <button class="btn btn-sidebar w-100 mb-3" id="selection">Usuarios</button>
            <button class="btn btn-sidebar w-100" onclick="window.location.href='./chats.php'">Chats</button>
        </div>
        <div class="col-lg-7 col-md-6 col-12 content-right">
        <h1 class="mt-4 mb-4">Usuarios</h1>
                <div class="content d-flex">
                    <div class="w-75 pe-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre de usuario</th>
                                    <th>Fecha de registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                                            <td><?php echo htmlspecialchars($user['registration_date']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No se encontraron usuarios.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
