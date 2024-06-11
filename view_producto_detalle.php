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
    echo "ID del producto no proporcionado.";
    exit();
}

$id = $_GET['id'];

global $pdo;
$stmt = $pdo->prepare('
    SELECT p.*, m.nombre as marca_nombre
    FROM Productos p
    LEFT JOIN Marcas m ON p.marca_id = m.id
    WHERE p.id = ?
');
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    echo "Producto no encontrado.";
    exit();
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Detalles del Producto</h3>
        </div>
        <div class="card-body d-flex justify-content-between align-items-center">
            <div class="flex-grow-1">
                <h5 class="card-title">Marca: <?php echo htmlspecialchars($producto['marca_nombre']); ?></h5>
                <p class="card-text">Color: <?php echo htmlspecialchars($producto['color']); ?></p>
                <p class="card-text">Modelo: <?php echo htmlspecialchars($producto['modelo']); ?></p>
                <p class="card-text">Componentes: <?php echo htmlspecialchars($producto['componentes']); ?></p>
                <p class="card-text">Precio: <?php echo htmlspecialchars($producto['precio']); ?></p>
                <a href="view_producto.php" class="btn btn-secondary mt-3">Regresar</a>
            </div>
            <div class="ml-3 text-center">
                <img src="assets/images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" style="width:300px;height:300px;" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
