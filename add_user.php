<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $avatar = 'default.png'; 

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar = 'avatar' . time() . '.' . pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['avatar']['tmp_name'], 'assets/images/' . $avatar);
    }

    save_user($name, $email, $password, $avatar);

    header('Location: index.php');
    exit();
}
?>