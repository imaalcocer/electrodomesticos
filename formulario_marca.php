<?php
include 'header.php';
include 'BaseDatos.php';
include 'functions.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];

    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO Marcas (nombre) VALUES (?)');
    $stmt->execute([$nombre]);

    header('Location: view_marca.php');
    exit();
}
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Añadir Marca</h2>
        <form action="formulario_marca.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre de la Marca:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar</button>
        </form>
        <a href="view_marca.php" class="btn btn-secondary btn-block mt-3">Regresar</a>
    </div>
</body>
</html>
<?php
include 'footer.php';
?>
