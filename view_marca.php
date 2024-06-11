<?php
include 'header.php';
include 'BaseDatos.php';
include 'functions.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$marcas = load_marcas();
?>

<div class="container mt-5">
    <h2 class="text-center">Gestionar Marcas</h2>
    <div class="col-md-4 offset-md-4 mb-3">
        <a href="formulario_marca.php" class="btn btn-dark">Añadir Marca</a>
    </div>
    <div class="table-responsive">
        <table id="marcasTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($marcas as $marca): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($marca['id']); ?></td>
                        <td><?php echo htmlspecialchars($marca['nombre']); ?></td>
                        <td>
                            <a href="view_marca_detalle.php?id=<?php echo $marca['id']; ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="edit_marca.php?id=<?php echo $marca['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="delete_marca.php?id=<?php echo $marca['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta marca?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <form id="pdfFormMarcas" method="post" action="generate_pdf.php" target="_blank">
        <input type="hidden" name="data" id="pdfDataMarcas">
        <input type="hidden" name="type" value="marcas">
        <button type="submit" id="generatePdfBtnMarcas" class="btn btn-info mt-3">Generar PDF</button>
    </form>
    <a href="index2.php" class="btn btn-secondary mt-3">Regresar</a>

    <!-- Integración de DataTables y botones de exportación -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#marcasTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'print'
                ]
            });

            $('#generatePdfBtnMarcas').on('click', function () {
                var data = JSON.stringify(table.rows().data().toArray());
                $('#pdfDataMarcas').val(data);
            });
        });
    </script>
</body>
</html>
<?php
include 'footer.php';
?>
