<?php
require_once '../config.php';
require_once 'conexion.php';
class PedidosModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }

    public function getPedidos()
    {
        $consult = $this->pdo->prepare("SELECT * FROM pedidos");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProducto($id)
    {
        $consult = $this->pdo->prepare("SELECT * FROM productos WHERE id_producto = $id");
        $consult->execute();
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductos($id_pedido)
    {
        $consult = $this->pdo->prepare("SELECT * FROM detalle_compra WHERE id_pedido = $id_pedido");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function savePedido($transaccion, $fecha, $nombre, $direccion, $telefono, $total)
    {
        $consult = $this->pdo->prepare("INSERT INTO pedidos (transaccion, fecha, nombre, direccion, telefono, total) VALUES (?,?,?,?,?,?)");
        $consult->execute([$transaccion, $fecha, $nombre, $direccion, $telefono, $total]);
        return $this->pdo->lastInsertId();
    }

    public function registrarDetalle($id_pedido, $id, $nombre, $precio, $cantidad)
    {
        $consult = $this->pdo->prepare("INSERT INTO detalle_compra (id_pedido, id_producto, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
        return $consult->execute([$id_pedido, $id, $nombre, $precio, $cantidad]);
    }

    public function cambiar($id_pedido)
    {
        $consult = $this->pdo->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
        return $consult->execute([0, $id_pedido]);
    }

    public function actualizarStock($stock, $id)
    {
        $consult = $this->pdo->prepare("UPDATE productos SET stock = ? WHERE id_producto = ?");
        return $consult->execute([$stock, $id]);
    }
}