<?php
require_once 'config/config.php';

class CategoriaModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=perfumeria;charset=utf8', 'root', '');
    }

    public function getCategorias($orderBy = null, $orderDirection = 'ASC') {
        $validColumns = ['nombre_categoria', 'id_categoria'];
        $orderBy = in_array($orderBy, $validColumns) ? $orderBy : 'nombre_categoria';
        $orderDirection = strtoupper($orderDirection) == 'DESC' ? 'DESC' : 'ASC';
    
        $query = $this->db->prepare("SELECT * FROM categorías ORDER BY $orderBy $orderDirection");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    

    public function getCategoriaById($id) {
        $query = $this->db->prepare("SELECT * FROM categorías WHERE id_categoria = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function addCategoria($nombre_categoria) {
        $query = $this->db->prepare("INSERT INTO categorías (nombre_categoria) VALUES (?)");
        $query->execute([$nombre_categoria]);
        return $this->db->lastInsertId();
    }

    public function updateCategoria($id, $nombre_categoria) {
        $query = $this->db->prepare("UPDATE categorías SET nombre_categoria = ? WHERE id_categoria = ?");
        $query->execute([$nombre_categoria, $id]);
        return $query->rowCount();
    }

    public function deleteCategoria($id) {
        $query = $this->db->prepare("DELETE FROM categorías WHERE id_categoria = ?");
        $query->execute([$id]);
        return $query->rowCount();
    }
}
