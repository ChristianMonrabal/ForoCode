<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: ./login.php");
    exit();
}

$section = isset($_GET['section']) ? $_GET['section'] : 'signin';
?>