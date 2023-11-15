<?php
require_once 'config.php';
require_once 'conexion.php';
class HomeModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }

    public function getproducts()
    {
        $consult = $this->pdo->prepare("SELECT * FROM productos WHERE estado = 1 ORDER BY id_producto DESC");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getproductsNuevos()
    {
        $consult = $this->pdo->prepare("SELECT * FROM productos WHERE estado = 1 ORDER BY id_producto DESC LIMIT 15");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getproduct($id)
    {
        $consult = $this->pdo->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $consult->execute([$id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }
}