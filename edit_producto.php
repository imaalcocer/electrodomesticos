<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include 'functions.php';
include 'header.php';
if (!isset($_GET['id'])) {
    header('Location: crud_productos.php');
    exit();
}

$producto = load_producto_by_id($_GET['id']);
if (!$producto) {
    header('Location: crud_productos.php');
    exit();
}

$marcas = load_marcas();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $color = $_POST['color'];
    $modelo = $_POST['modelo'];
    $componentes = $_POST['componentes'];
    $precio = $_POST['precio'];
    $marca_id = $_POST['marca_id'];
    $imagen = $producto['imagen'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = 'producto' . time() . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['imagen']['tmp_name'], 'assets/images/' . $imagen);
    }

    update_producto($producto['id'], $color, $modelo, $componentes, $precio, $marca_id, $imagen);
    header('Location: crud_productos.php');
    exit();
}
?>


<body>
    <div class="container mt-5">
        <h1>Editar Producto</h1>
        <form action="edit_producto.php?id=<?php echo $producto['id']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="color">Color:</label>
                <input type="text" name="color" id="color" class="form-control" value="<?php echo htmlspecialchars($producto['color']); ?>" required>
            </div>
            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" name="modelo" id="modelo" class="form-control" value="<?php echo htmlspecialchars($producto['modelo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="componentes">Componentes:</label>
                <input type="text" name="componentes" id="componentes" class="form-control" value="<?php echo htmlspecialchars($producto['componentes']); ?>" required>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio" class="form-control" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
            </div>
            <div class="form-group">
                <label for="marca_id">Marca:</label>
                <select class="form-control" id="marca_id" name="marca_id" required>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo $marca['id']; ?>" <?php if ($marca['id'] == $producto['marca_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($marca['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" name="imagen" id="imagen" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="crud_productos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    
</body>
</html>
<?php
include 'footer.php' ?>
