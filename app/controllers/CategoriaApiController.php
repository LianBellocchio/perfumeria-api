<?php

require_once 'app/models/CategoriaModel.php';
require_once 'libs/jwt.php';

class CategoriaApiController {
    private $model;

    public function __construct() {
        $this->model = new CategoriaModel();
    }

    // Obtener todas las categorías
    public function getAll($req, $res) {
        $orderBy = isset($req->query->orderBy) ? $req->query->orderBy : null;
        $orderDirection = isset($req->query->orderDirection) ? $req->query->orderDirection : 'ASC';
    
        $categorias = $this->model->getCategorias($orderBy, $orderDirection);
        echo json_encode($categorias);
    }
    

    // Obtener una categoría por su ID
    public function get($req, $res) {
        $id = $req->params->id;
        $categoria = $this->model->getCategoriaById($id);
        if ($categoria) {
            echo json_encode($categoria);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Categoría no encontrada"]);
        }
    }

    // Crear una nueva categoría (requiere autenticación)
    public function create($req, $res) {
        $data = $req->body;
        if (isset($data->nombre_categoria)) {
            $id = $this->model->addCategoria($data->nombre_categoria);
            http_response_code(201);
            echo json_encode(["message" => "Categoría creada", "id_categoria" => $id]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Faltan datos obligatorios"]);
        }
    }

    // Actualizar una categoría existente (requiere autenticación)
    public function update($req, $res) {
        $id = $req->params->id;
        $data = $req->body;
        if (isset($data->nombre_categoria)) {
            $result = $this->model->updateCategoria($id, $data->nombre_categoria);
            if ($result) {
                http_response_code(200);
                echo json_encode(["message" => "Categoría actualizada"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Categoría no encontrada"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Faltan datos obligatorios"]);
        }
    }

    // Eliminar una categoría (requiere autenticación)
    public function delete($req, $res) {
        $id = $req->params->id;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(["message" => "ID inválido"]);
            return;
        }

        $result = $this->model->deleteCategoria($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(["message" => "Categoría eliminada"]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Categoría no encontrada"]);
        }
    }
}
?>
