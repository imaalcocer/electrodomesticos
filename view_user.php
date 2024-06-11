<?php
include 'header.php';
include 'BaseDatos.php';
include 'functions.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Obtener datos de la tabla 'Users'
global $pdo;
$stmt = $pdo->prepare('SELECT * FROM users ORDER BY id ASC');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestionar Usuarios</h2>
        <table id="usersTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['lastname']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><img src="assets/images/<?php echo $user['avatar']; ?>" alt="Avatar" style="width:50px;height:50px;"></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning">Editar</a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form id="pdfFormUsers" method="post" action="generate_pdf.php" target="_blank">
            <input type="hidden" name="data" id="pdfDataUsers">
            <input type="hidden" name="type" value="users">
            <button type="submit" id="generatePdfBtnUsers" class="btn btn-info">Generar PDF</button>
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
                var table = $('#usersTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'print'
                    ]
                });

                $('#generatePdfBtnUsers').on('click', function () {
                    var data = JSON.stringify(table.rows().data().toArray());
                    $('#pdfDataUsers').val(data);
                });
            });
        </script>
    </div>
</body>
</html>
<?php
include 'footer.php';
?>
