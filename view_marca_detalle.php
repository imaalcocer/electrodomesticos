<?php
include 'header.php';
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
$stmt = $pdo->prepare('SELECT * FROM Marcas WHERE id = ?');
$stmt->execute([$id]);
$marca = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$marca) {
    echo "Marca no encontrada.";
    exit();
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Detalles de la Marca</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title">ID: <?php echo htmlspecialchars($marca['id']); ?></h5>
            <p class="card-text">Nombre: <?php echo htmlspecialchars($marca['nombre']); ?></p>
            <a href="view_marca.php" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
