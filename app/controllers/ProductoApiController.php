<?php

require_once 'app/models/ProductoModel.php';
require_once 'libs/jwt.php';

class ProductoApiController {
    private $model;

    public function __construct() {
        $this->model = new ProductoModel();
    }

    // Obtener todos los productos
    public function getAll($req, $res) {
        $orderBy = isset($req->query->orderBy) ? $req->query->orderBy : null;
        $orderDirection = isset($req->query->orderDirection) ? $req->query->orderDirection : 'ASC';
    
        $productos = $this->model->getProductos($orderBy, $orderDirection);
        echo json_encode($productos);
    }
    

    // Obtener un producto por su ID
    public function get($req, $res) {
        $id = $req->params->id;
        $producto = $this->model->getProductoById($id);
        if ($producto) {
            echo json_encode($producto);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Producto no encontrado"]);
        }
    }

    // Crear un nuevo producto (requiere autenticación)
    public function create($req, $res) {
        $data = $req->body;
        if (isset($data->nombre_producto, $data->descripcion, $data->precio, $data->id_categoria)) {
            $id = $this->model->addProducto($data->nombre_producto, $data->descripcion, $data->precio, $data->id_categoria);
            http_response_code(201);
            echo json_encode(["message" => "Producto creado", "id_producto" => $id]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Faltan datos obligatorios"]);
        }
    }

    // Actualizar un producto existente (requiere autenticación)
    public function update($req, $res) {
        $id = $req->params->id;
        $data = $req->body;
        if (isset($data->nombre_producto, $data->descripcion, $data->precio, $data->id_categoria)) {
            $result = $this->model->updateProducto($id, $data->nombre_producto, $data->descripcion, $data->precio, $data->id_categoria);
            if ($result) {
                http_response_code(200);
                echo json_encode(["message" => "Producto actualizado"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Producto no encontrado"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Faltan datos obligatorios"]);
        }
    }

    // Eliminar un producto (requiere autenticación)
    public function delete($req, $res) {
        $id = $req->params->id;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(["message" => "ID inválido"]);
            return;
        }

        $result = $this->model->deleteProducto($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(["message" => "Producto eliminado"]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Producto no encontrado"]);
        }
    }
}

?>
