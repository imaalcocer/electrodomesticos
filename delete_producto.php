<?php
include 'BaseDatos.php';
include 'functions.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID del producto no proporcionado.";
    exit();
}

$id = $_GET['id'];

global $pdo;
$stmt = $pdo->prepare('DELETE FROM Productos WHERE id = ?');
$stmt->execute([$id]);

// Reasignar IDs
$stmt = $pdo->query('SET @count = 0;');
$stmt = $pdo->query('UPDATE Productos SET id = @count:= @count + 1;');
$stmt = $pdo->query('ALTER TABLE Productos AUTO_INCREMENT = 1;');

header('Location: view_producto.php');
exit();
?>
