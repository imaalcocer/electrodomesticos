<?php
include 'header.php';
include 'BaseDatos.php';
include 'functions.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Obtener datos de la tabla 'Productos'
global $pdo;
$stmt = $pdo->prepare('SELECT * FROM Productos ORDER BY id ASC');
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestionar Productos</h2>
        <div class="col-md-4 offset-md-4 mb-3">
            <a href="formulario_producto.php" class="btn btn-dark">Añadir Producto</a>
        </div>
        <div class="table-responsive">
            <table id="productosTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Color</th>
                        <th>Modelo</th>
                        <th>Componentes</th>
                        <th>Precio</th>
                        <th>Marca ID</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['id']; ?></td>
                            <td><?php echo $producto['color']; ?></td>
                            <td><?php echo $producto['modelo']; ?></td>
                            <td><?php echo $producto['componentes']; ?></td>
                            <td><?php echo $producto['precio']; ?></td>
                            <td><?php echo $producto['marca_id']; ?></td>
                            <td><img src="assets/images/<?php echo $producto['imagen']; ?>" alt="Imagen del producto" style="width:50px;height:50px;"></td>
                            <td>
                                <a href="view_producto_detalle.php?id=<?php echo $producto['id']; ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="edit_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="delete_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-danger btn-sm delete-button">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <form id="pdfFormProductos" method="post" action="generate_pdf.php" target="_blank">
            <input type="hidden" name="data" id="pdfDataProductos">
            <input type="hidden" name="type" value="productos">
            <button type="submit" id="generatePdfBtnProductos" class="btn btn-info mt-3">Generar PDF</button>
        </form>
        <a href="index2.php" class="btn btn-secondary mt-3">Regresar</a>
    </div>

    <!-- Integración de DataTables y botones de exportación -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#productosTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'print'
                ]
            });

            $('#generatePdfBtnProductos').on('click', function () {
                var data = JSON.stringify(table.rows().data().toArray());
                $('#pdfDataProductos').val(data);
            });

            $('.delete-button').on('click', function(e) {
                var confirmed = confirm('¿Está seguro de que desea eliminar este producto?');
                if (!confirmed) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
<?php
include 'footer.php';
?>
