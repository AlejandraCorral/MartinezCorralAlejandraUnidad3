<?php
require_once '../config.php';
require_once 'conexion.php';
class ProductosModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }

    public function getProductos()
    {
        $consult = $this->pdo->prepare("SELECT * FROM productos WHERE estado = 1");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProducto($id_producto)
    {
        $consult = $this->pdo->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $consult->execute([$id_producto]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function comprobarNombre($nombre, $accion)
    {
        if ($accion == 0) {
            $consult = $this->pdo->prepare("SELECT * FROM productos WHERE titulo = ?");
            $consult->execute([$nombre]);
        } else {
            $consult = $this->pdo->prepare("SELECT * FROM productos WHERE titulo = ? AND id_producto != ?");
            $consult->execute([$nombre, $accion]);
        }
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function save($nombre, $descripcion, $precio, $stock, $imgname)
    {
        $consult = $this->pdo->prepare("INSERT INTO productos (titulo, descripcion_corta, precio_normal, stock, foto_destacada) VALUES (?,?,?,?,?)");
        return $consult->execute([$nombre, $descripcion, $precio, $stock, $imgname]);
    }

    public function delete($id_producto)
    {
        $consult = $this->pdo->prepare("UPDATE productos SET estado = ? WHERE id_producto = ?");
        return $consult->execute([0, $id_producto]);
    }

    public function update($nombre, $descripcion, $precio, $stock, $imgname, $id_producto)
    {
        $consult = $this->pdo->prepare("UPDATE productos SET titulo=?, descripcion_corta=?, precio_normal=?, stock=?, foto_destacada=? WHERE id_producto=?");
        return $consult->execute([$nombre, $descripcion, $precio, $stock, $imgname, $id_producto]);
    }
}
