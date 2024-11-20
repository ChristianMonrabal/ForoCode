<?php
session_start();

unset($_SESSION['loggedin']);
unset($_SESSION['usuario_id']);
unset($_SESSION['username']);

session_destroy();

header("Location: ../public/login.php");
exit();
