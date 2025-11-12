<?php
namespace TECWEB\MYAPI;

use TECWEB\MYAPI\DataBase as DataBase;

require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = [];

    public function __construct($db, $user = 'root', $pass = '') {
        $this->data = array();
        // Llamada al constructor padre con el orden correcto (user, pass, db)
        parent::__construct($user, $pass, $db);
    }

    // +list(): void
    public function list() {
        $this->data = [];
        $sql = "SELECT * FROM productos WHERE eliminado = 0";
        if ($result = $this->conexion->query($sql)) {
            $this->data = $result->fetch_all(MYSQLI_ASSOC); // Más simple
            $result->free();
        } else {
            $this->data = ['error' => 'Query Error: ' . $this->conexion->error];
        }
      
    }

    // +add(Object): void
    public function add($postData) {
        // Asignación segura de variables
        $nombre = $postData['nombre'] ?? '';
        $marca = $postData['marca'] ?? '';
        $modelo = $postData['modelo'] ?? '';
        $precio = $postData['precio'] ?? 0.0;
        $detalles = $postData['detalles'] ?? '';
        $unidades = $postData['unidades'] ?? 0;
        $imagen = $postData['imagen'] ?? '';

        // 1. Revisar si el nombre ya existe
        $stmt_check = $this->conexion->prepare("SELECT * FROM productos WHERE nombre = ? AND eliminado = 0");
        $stmt_check->bind_param("s", $nombre);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows == 0) {
            // 2. Insertar si no existe
            $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
            $stmt_insert = $this->conexion->prepare($sql);
            // s = string, d = double, i = integer
            $stmt_insert->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);
            
            if ($stmt_insert->execute()) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto agregado";
            } else {
                $this->data['error'] = "ERROR: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        } else {
            $this->data['status'] = "error";
            $this->data['message'] = "Ya existe un producto con ese nombre";
        }
        $stmt_check->close();
    }

    // +delete(string): void
    public function delete($postData) {
        $id = $postData['id'] ?? 0;
        if ($id > 0) {
            $sql = "UPDATE productos SET eliminado = 1 WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto eliminado";
            } else {
                $this->data['error'] = "ERROR: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    // +edit(Object): void
    public function edit($postData) {
        $id = $postData['id'] ?? 0;
        $nombre = $postData['nombre'] ?? '';
        $marca = $postData['marca'] ?? '';
        $modelo = $postData['modelo'] ?? '';
        $precio = $postData['precio'] ?? 0.0;
        $detalles = $postData['detalles'] ?? '';
        $unidades = $postData['unidades'] ?? 0;
        $imagen = $postData['imagen'] ?? '';

        if ($id > 0) {
            $sql = "UPDATE productos SET nombre=?, marca=?, modelo=?, precio=?, detalles=?, unidades=?, imagen=? 
                    WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            // sssdsisi = string, string, string, double, string, integer, string, integer
            $stmt->bind_param("sssdsisi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen, $id);

            if ($stmt->execute()) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto actualizado";
            } else {
                $this->data['error'] = "ERROR: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    // +search(string): void
    public function search($getData) {
        $search = $getData['search'] ?? '';
        $like_search = "%{$search}%";
        
        $sql = "SELECT * FROM productos 
                WHERE (id = ? OR nombre LIKE ? OR marca LIKE ? OR detalles LIKE ?) 
                AND eliminado = 0";
        $stmt = $this->conexion->prepare($sql);
        // ssss = string, string, string, string
        $stmt->bind_param("ssss", $search, $like_search, $like_search, $like_search);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        } else {
            $this->data['error'] = 'Query Error: ' . $stmt->error;
        }
        $stmt->close();
    }

    // +single(string): void
    public function single($postData) {
        $id = $postData['id'] ?? 0;
        if ($id > 0) {
            $sql = "SELECT * FROM productos WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $this->data = $result->fetch_assoc(); // Solo un resultado
                $result->free();
            } else {
                $this->data['error'] = 'Query Error: ' . $stmt->error;
            }
            $stmt->close();
        }
    }

    // +singleByName(string): void
    public function singleByName($name) {
        $sql = "SELECT * FROM productos WHERE nombre = ? AND eliminado = 0";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->data = $result->fetch_assoc();
            $result->free();
        } else {
            $this->data['error'] = 'Query Error: ' . $stmt->error;
        }
        $stmt->close();
    }
    

    public function checkNameExists($getData) {
        $name = $getData['name'] ?? '';
        
        $sql = "SELECT COUNT(*) as count FROM productos WHERE nombre = ? AND eliminado = 0";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row['count'] > 0) {
                $this->data['status'] = 'error';
                $this->data['message'] = 'El nombre del producto ya existe.';
            } else {
                $this->data['status'] = 'success';
                $this->data['message'] = 'Nombre disponible.';
            }
            $result->free();
        } else {
            $this->data['error'] = "ERROR: " . $stmt->error;
        }
        $stmt->close();
    }

    // +getData(): string
    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>