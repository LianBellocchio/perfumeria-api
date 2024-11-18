<?php
require_once 'config/config.php';

class ProductoIngredienteModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=perfumeria;charset=utf8', 'root', '');
    }

    public function getIngredientesPorProductoId($id_producto) {
        $query = $this->db->prepare("SELECT i.*, pi.cantidad FROM productos_ingredientes pi INNER JOIN ingredientes i ON pi.id_ingrediente = i.id_ingrediente WHERE pi.id_producto = ?");
        $query->execute([$id_producto]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function addIngredienteAProducto($id_producto, $id_ingrediente, $cantidad) {
        $query = $this->db->prepare("INSERT INTO productos_ingredientes (id_producto, id_ingrediente, cantidad) VALUES (?, ?, ?)");
        $query->execute([$id_producto, $id_ingrediente, $cantidad]);
        return $this->db->lastInsertId();
    }

    public function updateIngredienteProducto($id_producto, $id_ingrediente, $cantidad) {
        $query = $this->db->prepare("UPDATE productos_ingredientes SET cantidad = ? WHERE id_producto = ? AND id_ingrediente = ?");
        $query->execute([$cantidad, $id_producto, $id_ingrediente]);
        return $query->rowCount();
    }

    public function deleteIngredienteProducto($id_producto, $id_ingrediente) {
        $query = $this->db->prepare("DELETE FROM productos_ingredientes WHERE id_producto = ? AND id_ingrediente = ?");
        $query->execute([$id_producto, $id_ingrediente]);
        return $query->rowCount();
    }
}
?>
