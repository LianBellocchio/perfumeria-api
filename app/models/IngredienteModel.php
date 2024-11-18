<?php
require_once 'config/config.php';

class IngredienteModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=perfumeria;charset=utf8', 'root', '');
    }

    public function getIngredientes($orderBy = null, $orderDirection = 'ASC') {
        $validColumns = ['nombre_ingrediente', 'descripcion', 'id_ingrediente'];
        $validDirections = ['ASC', 'DESC'];
    
        if (!in_array($orderBy, $validColumns)) {
            $orderBy = 'nombre_ingrediente';
        }
        
        if (!in_array(strtoupper($orderDirection), $validDirections)) {
            $orderDirection = 'ASC';
        } else {
            $orderDirection = strtoupper($orderDirection);
        }
    
        $sql = "SELECT * FROM ingredientes ORDER BY $orderBy $orderDirection";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    

    public function getIngredienteById($id) {
        $query = $this->db->prepare("SELECT * FROM ingredientes WHERE id_ingrediente = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function addIngrediente($nombre_ingrediente, $descripcion) {
        $query = $this->db->prepare("INSERT INTO ingredientes (nombre_ingrediente, descripcion) VALUES (?, ?)");
        $query->execute([$nombre_ingrediente, $descripcion]);
        return $this->db->lastInsertId();
    }

    public function updateIngrediente($id, $nombre_ingrediente, $descripcion) {
        $query = $this->db->prepare("UPDATE ingredientes SET nombre_ingrediente = ?, descripcion = ? WHERE id_ingrediente = ?");
        $query->execute([$nombre_ingrediente, $descripcion, $id]);
        return $query->rowCount();
    }

    public function deleteIngrediente($id) {
        $query = $this->db->prepare("DELETE FROM ingredientes WHERE id_ingrediente = ?");
        $query->execute([$id]);
        return $query->rowCount();
    }
}
?>
