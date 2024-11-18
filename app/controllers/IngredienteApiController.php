<?php

require_once 'app/models/IngredienteModel.php';
require_once 'libs/jwt.php';

class IngredienteApiController {
    private $model;

    public function __construct() {
        $this->model = new IngredienteModel();
    }

    // Obtener todos los ingredientes
    public function getAll($req, $res) {
        // Leer los parámetros de ordenación de la consulta (si los hay)
        $orderBy = isset($req->query->orderBy) ? $req->query->orderBy : null;
        $orderDirection = isset($req->query->orderDirection) ? $req->query->orderDirection : 'ASC';
    
        $ingredientes = $this->model->getIngredientes($orderBy, $orderDirection);
        echo json_encode($ingredientes);
    }
    

    // Obtener un ingrediente por su ID
    public function get($req, $res) {
        $id = $req->params->id;
        $ingrediente = $this->model->getIngredienteById($id);
        if ($ingrediente) {
            echo json_encode($ingrediente);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Ingrediente no encontrado"]);
        }
    }

    // Crear un nuevo ingrediente (requiere autenticación)
    public function create($req, $res) {
        $data = $req->body;
        if (isset($data->nombre_ingrediente, $data->descripcion)) {
            $id = $this->model->addIngrediente($data->nombre_ingrediente, $data->descripcion);
            http_response_code(201);
            echo json_encode(["message" => "Ingrediente creado", "id_ingrediente" => $id]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Faltan datos obligatorios"]);
        }
    }

    // Actualizar un ingrediente existente (requiere autenticación)
    public function update($req, $res) {
        $id = $req->params->id;
        $data = $req->body;
        if (isset($data->nombre_ingrediente, $data->descripcion)) {
            $result = $this->model->updateIngrediente($id, $data->nombre_ingrediente, $data->descripcion);
            if ($result) {
                http_response_code(200);
                echo json_encode(["message" => "Ingrediente actualizado"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Ingrediente no encontrado"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Faltan datos obligatorios"]);
        }
    }

    // Eliminar un ingrediente (requiere autenticación)
    public function delete($req, $res) {
        $id = $req->params->id;
        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(["message" => "ID inválido"]);
            return;
        }

        $result = $this->model->deleteIngrediente($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(["message" => "Ingrediente eliminado"]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Ingrediente no encontrado"]);
        }
    }
}

?>