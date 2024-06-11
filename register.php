<?php
session_start();
include 'functions.php';
include 'header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $avatar = 'default.png';

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        if (!is_dir('assets/images/')) {
            mkdir('assets/images/', 0777, true);
        }
        $avatar = 'avatar' . time() . '.' . pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['avatar']['tmp_name'], 'assets/images/' . $avatar);
    }

    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $error = "El correo electrónico ya está registrado.";
    } else {
        save_user($name, $lastname, $email, $password, $avatar);
        $_SESSION['user'] = ['name' => $name, 'lastname' => $lastname, 'email' => $email, 'avatar' => $avatar];
        header('Location: index.php');
        exit();
    }
}
?>

<body>
    <div class="container">
        <div class="register-container mt-5">
            <h1 class="text-center">Registrar</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form action="register.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Apellido:</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="avatar">Avatar:</label>
                    <input type="file" name="avatar" id="avatar" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </form>
            <div class="text-center mt-3">
                <a href="index.php">¿Ya tienes una cuenta? Inicia sesión aquí.</a>
            </div>
        </div>
    </div>
  
</body>
</html>
<?php
include 'footer.php' ?>
