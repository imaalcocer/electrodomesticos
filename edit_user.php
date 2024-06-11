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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    global $pdo;
    // Iniciar una transacción para asegurar la integridad de los datos
    $pdo->beginTransaction();

    // Actualizar la información básica del usuario
    $stmt = $pdo->prepare('UPDATE users SET name = ?, lastname = ?, email = ? WHERE id = ?');
    $stmt->execute([$name, $lastname, $email, $id]);

    // Manejar la carga de la nueva imagen del avatar si se proporciona
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileSize = $_FILES['avatar']['size'];
        $fileType = $_FILES['avatar']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitizar el nombre del archivo
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Verificar si el tipo de archivo es permitido
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Subir el archivo al servidor
            $uploadFileDir = './assets/images/';
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Actualizar el avatar en la base de datos
                $stmt = $pdo->prepare('UPDATE users SET avatar = ? WHERE id = ?');
                $stmt->execute([$newFileName, $id]);
            } else {
                echo 'Hubo un error moviendo el archivo subido.';
            }
        } else {
            echo 'Subida fallida. Sólo se permiten archivos con estas extensiones: ' . implode(', ', $allowedfileExtensions);
        }
    }

    // Confirmar la transacción
    $pdo->commit();

    header('Location: view_user.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "ID de usuario no proporcionado.";
    exit();
}
?>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Editar Usuario</h2>
        <form action="edit_user.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="lastname">Apellido:</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Correo:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <input type="file" name="avatar" id="avatar" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
<?php
include 'footer.php';
?>
