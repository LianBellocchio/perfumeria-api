<?php
require_once 'config/config.php';

class ProductoModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=perfumeria;charset=utf8', 'root', '');
    }

    public function getProductos($orderBy = null, $orderDirection = 'ASC') {
        $validColumns = ['nombre_producto', 'precio', 'id_categoria'];
        $orderBy = in_array($orderBy, $validColumns) ? $orderBy : 'nombre_producto';
        $orderDirection = strtoupper($orderDirection) == 'DESC' ? 'DESC' : 'ASC';
    
        $query = $this->db->prepare("SELECT p.*, c.nombre_categoria FROM productos p LEFT JOIN categorías c ON p.id_categoria = c.id_categoria ORDER BY $orderBy $orderDirection");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    

    public function getProductoById($id) {
        $query = $this->db->prepare("SELECT p.*, c.nombre_categoria FROM productos p LEFT JOIN categorías c ON p.id_categoria = c.id_categoria WHERE p.id_producto = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function addProducto($nombre_producto, $descripcion, $precio, $id_categoria) {
        $query = $this->db->prepare("INSERT INTO productos (nombre_producto, descripcion, precio, id_categoria) VALUES (?, ?, ?, ?)");
        $query->execute([$nombre_producto, $descripcion, $precio, $id_categoria]);
        return $this->db->lastInsertId();
    }

    public function updateProducto($id, $nombre_producto, $descripcion, $precio, $id_categoria) {
        $query = $this->db->prepare("UPDATE productos SET nombre_producto = ?, descripcion = ?, precio = ?, id_categoria = ? WHERE id_producto = ?");
        $query->execute([$nombre_producto, $descripcion, $precio, $id_categoria, $id]);
        return $query->rowCount();
    }

    public function deleteProducto($id) {
        $query = $this->db->prepare("DELETE FROM productos WHERE id_producto = ?");
        $query->execute([$id]);
        return $query->rowCount();
    }
}
?>
