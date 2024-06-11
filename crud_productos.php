<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include 'functions.php';
include 'header.php';
$productos = load_productos();
$user = $_SESSION['user'];
?>


<body>
    <div class="container mt-5">
        <h1>Gestión de Productos</h1>
        <a href="formulario_producto.php" class="btn btn-dark mb-3">Añadir Producto</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Color</th>
                        <th>Modelo</th>
                        <th>Componentes</th>
                        <th>Precio</th>
                        <th>Marca</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id']); ?></td>
                            <td><?php echo htmlspecialchars($producto['color']); ?></td>
                            <td><?php echo htmlspecialchars($producto['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($producto['componentes']); ?></td>
                            <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                            <td><?php echo htmlspecialchars($producto['marca_id']); ?></td>
                            <td><img src="assets/images/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen" style="width: 50px; height: 50px;"></td>
                            <td>
                                <a href="view_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="edit_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="delete_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index2.php" class="btn btn-primary">Regresar</a>
        </div>
    </div>
   
</body>
</html>
<?php
include 'footer.php' ?>
