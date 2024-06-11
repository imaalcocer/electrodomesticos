<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

include 'functions.php';
include 'header.php';
$users = load_users();


?>


<body>
    <div class="container">
        <div class="crud-container mt-5">
            <h1 class="text-center">Gestión de Usuarios</h1>
            
            <a href="register.php" class="btn btn-dark mb-3">Añadir Usuario</a>
           
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Avatar</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><img src="assets/images/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="user-avatar"></td>
                            <td>
                                <a href="view_user.php?id=<?php echo $user['id']; ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" >Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="logout.php" class="btn btn-secondary">Cerrar Sesión</a>
                <a href="index2.php" class="btn btn-primary">Regresar</a>
            </div>
        </div>
    </div>
   
</body>
</html>
<?php
include 'footer.php' ?>
