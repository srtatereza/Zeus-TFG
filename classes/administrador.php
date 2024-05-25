<?php
session_start();
include_once '../include/zeus_tfg.php';

class Administrador
{
    private $id_administrador;
    private $usuario;
    private $contrasenia;

    function __construct($id_administrador, $usuario, $contrasenia)
    {
        $this->id_administrador = $id_administrador;
        $this->usuario = $usuario;
        $this->contrasenia = $contrasenia;
    }

    public function getId_administrador()
    {
        return $this->id_administrador;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    // Función para obtener un administrador
    public function select($usuario)
    {
        $conexion = camisetasDB::connectDB();
        $sql = "SELECT * FROM administradores WHERE usuario = ?";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Relanzamos la excepcion
            throw $e;
        }
    }
}
