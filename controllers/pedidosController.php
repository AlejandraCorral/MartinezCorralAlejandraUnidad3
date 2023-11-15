<?php
require_once '../models/pedidos.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$pedidos = new PedidosModel();
switch ($option) {
    case 'listar':
        $data = $pedidos->getPedidos();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['productos'] = '';
            $data[$i]['cantidad'] = '';
            $productos = $pedidos->getProductos($data[$i]['id']);
            foreach ($productos as $producto) {
                $data[$i]['productos'] .= '<li>' . $producto['nombre'] . '</li>';
                $data[$i]['cantidad'] .= '<li>' . $producto['cantidad'] . '</li>';
            }
            $estado = ($data[$i]['estado']) ? '' : 'checked';
            $data[$i]['accion'] = '<div class="btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-primary">
                <input type="checkbox" ' . $estado . ' onchange="cambiar(' . $data[$i]['id'] . ')">
            </label>
        </div>';
        }
        echo json_encode($data);
        break;
    case 'cambiar':
        $id_pedido = $_GET['id'];
        $data = $pedidos->cambiar($id_pedido);
        if ($data) {
            $res = array('tipo' => 'success', 'mensaje' => 'ESTADO MODIFICADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR');
        }
        echo json_encode($res);
        break;
    case 'savePedido':
        $datos = file_get_contents('php://input');
        $json = json_decode($datos, true);
        $nombre = $json['nombre'];
        $direccion = $json['direccion'];
        $telefono = $json['telefono'];
        $transaccion = $json['detalle']['id'];
        $total = $json['detalle']['purchase_units'][0]['amount']['value'];
        $fecha = date('Y-m-d');
        $pedido = $pedidos->savePedido($transaccion, $fecha, $nombre, $direccion, $telefono, $total);
        if ($pedido > 0) {
            foreach ($_SESSION['carrito']['productos'] as $id => $cantidad) {
                $producto = $pedidos->getProducto($id);
                $stock = $producto['stock'] - $cantidad;
                $pedidos->actualizarStock($stock, $id);
                $pedidos->registrarDetalle($pedido, $id, $producto['titulo'], $producto['precio_normal'], $cantidad);
            }
            unset($_SESSION['carrito']['productos']);
            $res = array('tipo' => 'success', 'mensaje' => 'PEDIDO REGISTRADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL REGISTRAR PEDIDO');
        }
        echo json_encode($res);
        break;
    default:
        # code...
        break;
}
