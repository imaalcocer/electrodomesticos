<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include 'functions.php';
include 'BaseDatos.php';

if (!isset($_GET['id'])) {
    header('Location: crud.php');
    exit();
}

// Eliminar usuario
delete_user($_GET['id']);
save_users_to_json();

// Reasignar IDs
global $pdo;
$stmt = $pdo->query('SET @count = 0;');
$stmt = $pdo->query('UPDATE users SET id = @count := @count + 1;');
$stmt = $pdo->query('ALTER TABLE users AUTO_INCREMENT = 1;');

header('Location: crud.php');
exit();
?>
