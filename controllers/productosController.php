<?php
require_once '../models/productos.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$productos = new ProductosModel();
switch ($option) {
    case 'listar':
        $data = $productos->getProductos();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<div class="d-flex">
                <a class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id_producto'] . ')"><i class="fas fa-eraser"></i></a>
                <a class="btn btn-primary btn-sm" onclick="edit(' . $data[$i]['id_producto'] . ')"><i class="fas fa-edit"></i></a>
            </div>';
        }
        echo json_encode($data);
        break;
    case 'save':
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $id_producto = $_POST['id_producto'];
        $img = $_FILES['imagen'];
        $fecha = date('YmdHis');        
        if (!empty($img['name'])) {
            $imgname = $fecha . '.jpg';
            $destino = '../assets/images/productos/' . $imgname;
        } else if (empty($img['name']) && !empty($_POST['imagen_actual'])) {
            $imgname = $_POST['imagen_actual'];
        } else {
            $imgname = 'default.png';
        }
        if ($id_producto == '') {
            $consult = $productos->comprobarNombre($nombre, 0);
            if (empty($consult)) {
                $result = $productos->save($nombre, $descripcion, $precio, $stock, $imgname);
                if ($result) {
                    if (!empty($img['name'])) {
                        move_uploaded_file($img['tmp_name'], $destino);
                    }
                    $res = array('tipo' => 'success', 'mensaje' => 'PRODUCTO REGISTRADO');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL AGREGAR');
                }
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'EL PRODUCTO YA EXISTE');
            }
        } else {
            $consult = $productos->comprobarNombre($nombre, $id_producto);
            if (empty($consult)) {
                $result = $productos->update($nombre, $descripcion, $precio, $stock, $imgname, $id_producto);
                if ($result) {
                    if (!empty($img['name'])) {
                        $data = $productos->getProducto($id_producto);
                        if (file_exists('../assets/images/productos/' . $data['foto_destacada'])) {
                            if ($data['foto_destacada'] != 'default.png') {
                                unlink('../assets/images/productos/' . $data['foto_destacada']);
                            }
                        }
                        move_uploaded_file($img['tmp_name'], $destino);
                    }
                    $res = array('tipo' => 'success', 'mensaje' => 'PRODUCTO MODIFICADO');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL MODIFICAR');
                }
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'EL PRODUCTO YA EXISTE');
            }
        }
        echo json_encode($res);
        break;
    case 'delete':
        $id_producto = $_GET['id'];
        $data = $productos->delete($id_producto);
        if ($data) {
            $temp = $productos->getProducto($id_producto);
            if (file_exists('../assets/images/productos/' . $temp['foto_destacada'])) {
                if ($temp['foto_destacada'] != 'default.png') {
                    unlink('../assets/images/productos/' . $temp['foto_destacada']);
                }
            }
            $res = array('tipo' => 'success', 'mensaje' => 'PRODUCTO ELIMINADO');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL ELIMINAR');
        }
        echo json_encode($res);
        break;
    case 'edit':
        $id_producto = $_GET['id'];
        $data = $productos->getProducto($id_producto);
        echo json_encode($data);
        break;
    default:
        # code...
        break;
}
