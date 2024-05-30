<?php
session_start();
include_once '../include/zeus_tfg.php';

/**
 * Modelo de administradores
 */
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

    /**
     * Función para obtener un administrador por su usuario
     * Devuelve un array con los datos del administrador
     */
    public function select($usuario)
    {
        $conexion = CamisetasDB::connectDB();
        $sql = "SELECT * FROM administradores WHERE usuario = ?";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Relanzamos la excepcion para manejarla posteriormente
            error_log("Error en la base de datos: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Función para cambiar la contraseña de un administrador
     */
    public function cambiarContrasenia($id_administrador, $contrasenia)
    {
        $conexion = CamisetasDB::connectDB();
        $sql = "UPDATE administradores SET contrasenia = ? WHERE id_administrador = ?";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$contrasenia, $id_administrador]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Relanzamos la excepcion para manejarla posteriormente
            error_log("Error en la base de datos: " . $e->getMessage());
            throw $e;
        }
    }
}
