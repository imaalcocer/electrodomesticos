<?php
include 'BaseDatos.php';
include 'functions.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID de la marca no proporcionado.";
    exit();
}

$id = $_GET['id'];

global $pdo;

// Eliminar productos que tienen la marca referenciada
$stmt = $pdo->prepare('DELETE FROM Productos WHERE marca_id = ?');
$stmt->execute([$id]);

// Eliminar la marca
$stmt = $pdo->prepare('DELETE FROM Marcas WHERE id = ?');
$stmt->execute([$id]);

// Reasignar IDs
$stmt = $pdo->query('SET @count = 0;');
$stmt = $pdo->query('UPDATE Marcas SET id = @count := @count + 1;');
$stmt = $pdo->query('ALTER TABLE Marcas AUTO_INCREMENT = 1;');

header('Location: view_marca.php');
exit();
?>
