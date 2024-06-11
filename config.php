<?php
if (!defined('DB_HOST')) {
    define('DB_HOST', '127.0.0.1');  // o 'localhost'
}

if (!defined('DB_USER')) {
    define('DB_USER', 'root');  // el usuario por defecto de MySQL en Laragon
}

if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '1234');  // la contraseña por defecto es vacía
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'electrodomesticos');
}

if (!defined('DB_PORT')) {
    define('DB_PORT', 3306);  // el puerto por defecto de MySQL
}
?>
