<?php
require_once '../config.php';
require_once 'conexion.php';
class UsuariosModel{
    private $pdo, $con;
    public function __construct() {
        $this->con = new Conexion();
        $this->pdo = $this->con->conectar();
    }

    public function getUsers()
    {
        $consult = $this->pdo->prepare("SELECT * FROM usuarios WHERE estado = 1");
        $consult->execute();
        return $consult->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($id)
    {
        $consult = $this->pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $consult->execute([$id]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function comprobarCorreo($correo)
    {
        $consult = $this->pdo->prepare("SELECT * FROM usuarios WHERE correo = ? AND estado = 1");
        $consult->execute([$correo]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function saveUser($nombre, $correo, $clave, $telefono)
    {
        $consult = $this->pdo->prepare("INSERT INTO usuarios (nombre, correo, clave, telefono) VALUES (?,?,?,?)");
        return $consult->execute([$nombre, $correo, $clave, $telefono]);
    }

    public function deleteUser($id)
    {
        $consult = $this->pdo->prepare("UPDATE usuarios SET estado = ? WHERE id_usuario = ?");
        return $consult->execute([0, $id]);
    }

    public function updateUser($nombre, $correo, $telefono, $id)
    {
        $consult = $this->pdo->prepare("UPDATE usuarios SET nombre=?, correo=?, telefono=? WHERE id_usuario=?");
        return $consult->execute([$nombre, $correo, $telefono, $id]);
    }
}

?>