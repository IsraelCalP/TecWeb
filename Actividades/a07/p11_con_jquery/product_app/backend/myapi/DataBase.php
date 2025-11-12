<?php
namespace TECWEB\MYAPI;

abstract class DataBase {
    protected $conexion;

    public function __construct($user, $pass, $db) {
        $host = 'localhost'; // Host es usualmente localhost
        $this->conexion = @mysqli_connect(
            $host,
            $user, 
            $pass, 
            $db
        );

        if (!$this->conexion) {
            die('Base de datos NO encontrada: ' . mysqli_connect_error());
        }

        $this->conexion->set_charset('utf8');
    }

    // Destructor para cerrar la conexión automáticamente al final del script
    public function __destruct() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>