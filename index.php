<?php

include 'header.php';
session_start();
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = ['name' => $user['name'], 'lastname' => $user['lastname'], 'email' => $user['email'], 'avatar' => $user['avatar']];
        header('Location: index2.php');
        exit();
    } else {
        $error = "Correo electrónico o contraseña incorrectos.";
    }
}
?> 

<body>
<div class="container">
        <div class="login-container mt-5">
            <h1 class="text-center">Iniciar Sesión</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>

            <?php endif; ?>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="email">Correo:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </form>
            <div class="text-center mt-3">
                <a href="register.php">¿No tienes una cuenta? Regístrate aquí.</a>
            </div>
            
        </div>
    </div>
</body>
</html>
<?php
include 'footer.php' ?>
