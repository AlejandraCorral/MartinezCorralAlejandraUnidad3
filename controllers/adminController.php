<?php
require_once '../models/admin.php';
$option = (empty($_GET['option'])) ? '' : $_GET['option'];
$admin = new AdminModel();
switch ($option) {
    case 'totales':
        $fecha = date('Y-m-d');
        $data['usuario'] = $admin->getDatos('usuarios');
        $data['productos'] = $admin->getDatos('productos');
        $data['pedidos'] = $admin->getDatos('pedidos');
        $data['ingresos'] = $admin->getIngresos($fecha);
        echo json_encode($data);
        break;
    case 'datos':
        $data = $admin->getDato();
        echo json_encode($data);
        break;
    case 'save':
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $id = $_POST['id'];
        if (empty($id) || empty($nombre) || empty($telefono) || empty($direccion) || empty($correo)) {
            $res = array('tipo' => 'error', 'mensaje' => 'TODO LOS CAMPOS SON REQUERIDOS');
        } else {
            $result = $admin->saveDatos($nombre, $telefono, $correo, $direccion, $id);
            if ($result) {
                $res = array('tipo' => 'success', 'mensaje' => 'REGISTRO MODIFICADO');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'ERROR AL MODIFICAR');
            }
        }
        echo json_encode($res);
        break;
    default:
        # code...
        break;
}
