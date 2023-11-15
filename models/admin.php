<?php
require_once '../config.php';
require_once 'conexion.php';
class AdminModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }

    public function getDatos($table)
    {
        $consult = $this->pdo->prepare("SELECT COUNT(*) AS total FROM $table WHERE estado = ?");
        $consult->execute([1]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function getIngresos($fecha)
    {
        $consult = $this->pdo->prepare("SELECT SUM(total) AS total FROM pedidos WHERE fecha = ?");
        $consult->execute([$fecha]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function getDato()
    {
        $consult = $this->pdo->prepare("SELECT * FROM configuracion");
        $consult->execute();
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function saveDatos($nombre, $telefono, $correo, $direccion, $id)
    {
        $consult = $this->pdo->prepare("UPDATE configuracion SET nombre=?, telefono=?, correo=?, direccion=? WHERE id_config = ?");
        return $consult->execute([$nombre, $telefono, $correo, $direccion, $id]);
    }
}

?>