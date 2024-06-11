<?php
require_once 'basedatos.php';

$bd = new BaseDatos();
$pdo = $bd->getConexion();

function load_users() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM users');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function save_user($name, $lastname, $email, $password, $avatar) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO users (name, lastname, email, password, avatar) VALUES (:name, :lastname, :email, :password, :avatar)');
    $stmt->execute(['name' => $name, 'lastname' => $lastname, 'email' => $email, 'password' => $password, 'avatar' => $avatar]);
}

function save_users_to_json() {
    $users = load_users();
    file_put_contents('data/users.json', json_encode($users, JSON_PRETTY_PRINT));
}

function load_user_by_id($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_user($id, $name, $lastname, $email, $password, $avatar) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE users SET name = :name, lastname = :lastname, email = :email, password = :password, avatar = :avatar WHERE id = :id');
    $stmt->execute(['name' => $name, 'lastname' => $lastname, 'email' => $email, 'password' => $password, 'avatar' => $avatar, 'id' => $id]);
}

function delete_user($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
    $stmt->execute(['id' => $id]);
}

function load_marcas() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM marcas');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function save_marca($nombre) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO marcas (nombre) VALUES (:nombre)');
    $stmt->execute(['nombre' => $nombre]);
}

function load_marca_by_id($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM marcas WHERE id = :id');
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_marca($id, $nombre) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE marcas SET nombre = :nombre WHERE id = :id');
    $stmt->execute(['nombre' => $nombre, 'id' => $id]);
}

function delete_marca($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM marcas WHERE id = :id');
    $stmt->execute(['id' => $id]);
}

function load_productos() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM productos');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function save_producto($color, $modelo, $componentes, $precio, $marca_id, $imagen) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO productos (color, modelo, componentes, precio, marca_id, imagen) VALUES (:color, :modelo, :componentes, :precio, :marca_id, :imagen)');
    $stmt->execute(['color' => $color, 'modelo' => $modelo, 'componentes' => $componentes, 'precio' => $precio, 'marca_id' => $marca_id, 'imagen' => $imagen]);
}

function load_producto_by_id($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM productos WHERE id = :id');
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_producto($id, $color, $modelo, $componentes, $precio, $marca_id, $imagen) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE productos SET color = :color, modelo = :modelo, componentes = :componentes, precio = :precio, marca_id = :marca_id, imagen = :imagen WHERE id = :id');
    $stmt->execute(['color' => $color, 'modelo' => $modelo, 'componentes' => $componentes, 'precio' => $precio, 'marca_id' => $marca_id, 'imagen' => $imagen, 'id' => $id]);
}

function delete_producto($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM productos WHERE id = :id');
    $stmt->execute(['id' => $id]);
}
?>
