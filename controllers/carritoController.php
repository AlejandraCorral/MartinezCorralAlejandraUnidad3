<?php
require_once '../models/productos.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$productos = new ProductosModel();
switch ($option) {
    case 'agregar':
        if (isset($_POST['id_producto'])) {
            $id_producto = $_POST['id_producto'];
            if (!empty($id_producto)) {
                if (isset($_SESSION['carrito']['productos'][$id_producto])) {
                    $_SESSION['carrito']['productos'][$id_producto] = 1;
                } else {
                    $_SESSION['carrito']['productos'][$id_producto] = 1;
                }
                $cantidad = count($_SESSION['carrito']['productos']);
                $msg = array('msg' => 'producto añadido', 'icono' => 'success', 'total' => $cantidad);
            } else {
                $msg = array('msg' => 'error fatal', 'icono' => 'error');
            }
        } else {
            $msg = array('msg' => 'error fatal', 'icono' => 'error');
        }
        echo json_encode($msg);
        break;
    case 'eliminar':
        $id_producto = $_GET['id'];
        if (isset($_SESSION['carrito']['productos'][$id_producto])) {
            unset($_SESSION['carrito']['productos'][$id_producto]);
            $data = array('icono' => 'success', 'msg' => 'PRODUCTO ELIMINADO DEL CARRITO');
        } else {
            $data = array('icono' => 'error', 'msg' => 'ERROR AL PRODUCTO ELIMINAR');
        }
        echo json_encode($data);
        break;
        case 'ver':
            $total = 0;
            if (isset($_SESSION['carrito']['productos'])) {
                if(!empty($_SESSION['carrito']['productos'])){
                    foreach ($_SESSION['carrito']['productos'] as $id => $cantidad) {
                        $producto = $productos->getProducto($id);
                        $total += $producto['precio_normal'] * $cantidad;
                    }
                }
            }
            echo json_encode($total);
            break;
    default:
        # code...
        break;
}
