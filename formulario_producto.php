<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include 'functions.php';
include 'header.php';
$marcas = load_marcas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $color = $_POST['color'];
    $modelo = $_POST['modelo'];
    $componentes = $_POST['componentes'];
    $precio = $_POST['precio'];
    $marca_id = $_POST['marca_id'];
    $imagen = $_FILES['imagen']['name'];

    // Manejo de la subida de la imagen
    $target_dir = "assets/images/";
    $target_file = $target_dir . basename($imagen);
    move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file);

    save_producto($color, $modelo, $componentes, $precio, $marca_id, $imagen);
    header('Location: crud_productos.php');
    exit();
}
?>


<body>
    <div class="container mt-5">
        <h1>Añadir Producto</h1>
        <form action="formulario_producto.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" class="form-control" id="color" name="color" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" required>
            </div>
            <div class="form-group">
                <label for="componentes">Componentes:</label>
                <input type="text" class="form-control" id="componentes" name="componentes" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="form-group">
                <label for="marca_id">Marca:</label>
                <select class="form-control" id="marca_id" name="marca_id" required>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo $marca['id']; ?>"><?php echo htmlspecialchars($marca['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="index2.php" class="btn btn-primary">Regresar</a>
        </form>
    </div>
</body>
</html>
<?php
include 'footer.php' ?>
