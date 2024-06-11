<?php
include 'config.php';

if (!class_exists('BaseDatos')) {
    class BaseDatos {
        private $host;
        private $user;
        private $pass;
        private $port;
        private $base;
        private $conexion;

        public function __construct() {
            $this->host = DB_HOST;
            $this->user = DB_USER;
            $this->port = DB_PORT;
            $this->base = DB_NAME;
            $this->pass = DB_PASSWORD;
            $server = 'mysql:dbname=' . $this->base . ';host=' . $this->host;
            $this->conexion = new PDO($server, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        public function getConexion() {
            return $this->conexion;
        }
    }
}
?>
