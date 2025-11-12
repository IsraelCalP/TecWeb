<?php
namespace TECWEB\MYAPI;

use TECWEB\MYAPI\DataBase as DataBase;

require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = NULL;
    public function __construct($db, $user = 'root', $pass = '') {
        $this->data = array();
        parent::__construct($user, $pass, $db);
    }

    public function list() {
        // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
        $this->data = array();
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
            // SE OBTIENEN LOS RESULTADOS
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function add($postData) {
        if (isset($postData['nombre'])) {
            $jsonOBJ = json_decode(json_encode($postData));

            $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
            $result = $this->conexion->query($sql);

            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO productos VALUES (
                    null,
                    '{$jsonOBJ->nombre}',
                    '{$jsonOBJ->marca}',
                    '{$jsonOBJ->modelo}',
                    {$jsonOBJ->precio},
                    '{$jsonOBJ->detalles}',
                    {$jsonOBJ->unidades},
                    '{$jsonOBJ->imagen}',
                    0
                )";

                if ($this->conexion->query($sql)) {
                    $this->data['status'] = "success";
                    $this->data['message'] = "Producto agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecutó $sql. " . $this->conexion->error;
                }
            }

            $result->free();
            $this->conexion->close();
        }
    }

    public function delete($postData) {
        if (isset($postData['id'])) {
            $id = intval($postData['id']);
            $sql = "UPDATE productos SET eliminado = 1 WHERE id = {$id}";

            if ($this->conexion->query($sql)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto eliminado";
            } else {
                $this->data['message'] = "ERROR: No se ejecutó $sql. " . $this->conexion->error;
            }

            $this->conexion->close();
        }
    }

    public function edit($postData) {
        if (isset($postData['id'])) {
            $jsonOBJ = json_decode(json_encode($postData));

            $sql  = "UPDATE productos SET ";
            $sql .= "nombre='{$jsonOBJ->nombre}', ";
            $sql .= "marca='{$jsonOBJ->marca}', ";
            $sql .= "modelo='{$jsonOBJ->modelo}', ";
            $sql .= "precio={$jsonOBJ->precio}, ";
            $sql .= "detalles='{$jsonOBJ->detalles}', ";
            $sql .= "unidades={$jsonOBJ->unidades}, ";
            $sql .= "imagen='{$jsonOBJ->imagen}' ";
            $sql .= "WHERE id={$jsonOBJ->id}";

            $this->conexion->set_charset("utf8");

            if ($this->conexion->query($sql)) {
                $this->data['status'] = "success";
                $this->data['message'] = "Producto actualizado";
            } else {
                $this->data['message'] = "ERROR: No se ejecutó $sql. " . $this->conexion->error;
            }

            $this->conexion->close();
        }
    }

    public function name($getData) {
        if (isset($getData['name'])) {
            $name = $this->conexion->real_escape_string($getData['name']);

            $sql = "SELECT COUNT(*) as count FROM productos WHERE nombre = '{$name}' AND eliminado = 0";
            $result = $this->conexion->query($sql);

            if ($result) {
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
                $this->data['message'] = "ERROR: No se pudo ejecutar la consulta. " . $this->conexion->error;
            }

            $this->conexion->close();
        }
    }

    public function search($getData) {
        if (isset($getData['search'])) {
            $search = $this->conexion->real_escape_string($getData['search']);

            $sql = "SELECT * FROM productos 
                    WHERE (id = '{$search}' 
                    OR nombre LIKE '%{$search}%' 
                    OR marca LIKE '%{$search}%' 
                    OR detalles LIKE '%{$search}%') 
                    AND eliminado = 0";

            if ($result = $this->conexion->query($sql)) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if (!is_null($rows)) {
                    foreach ($rows as $num => $row) {
                        foreach ($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }

                $result->free();
            } else {
                die('Query Error: ' . $this->conexion->error);
            }

            $this->conexion->close();
        }
    }

    public function single($postData) {
        if (isset($postData['id'])) {
            $id = intval($postData['id']); 

            $sql = "SELECT * FROM productos WHERE id = {$id}";

            if ($result = $this->conexion->query($sql)) {
                $row = $result->fetch_assoc();

                if (!is_null($row)) {
                    foreach ($row as $key => $value) {
                        $this->data[$key] = utf8_encode($value);
                    }
                }

                $result->free();
            } else {
                die('Query Error: ' . $this->conexion->error);
            }

            $this->conexion->close();
        }
    }

    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>