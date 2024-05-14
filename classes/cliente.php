<?php
session_start();
include_once '../include/zeus_tfg.php';

class Cliente
{
    private $id_cliente;
    private $nombre;
    private $apellido;
    private $direccion;
    private $telefono;
    private $email;
    private $contrasenia;

    function __construct($id_cliente, $nombre, $apellido, $direccion, $telefono, $email, $contrasenia)
    {
        $this->id_cliente = $id_cliente;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->contrasenia = $contrasenia;
    }

    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getGmail()
    {
        return $this->email;
    }

    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    // Función para insertar un cliente
    public function insert()
    {
        $conexion = camisetasDB::connectDB();
        $sql = "INSERT INTO camisetas.clientes (nombre, apellido, direccion, telefono, email, contrasenia) VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->email, $this->contrasenia]);
        } catch (PDOException $e) {
            // Manejar el error
            echo "Error en la base de datos: " . $e->getMessage();
        }
    }

    // Función para obtener un cliente
    public function select($email)
    {
        $conexion = camisetasDB::connectDB();
        $sql = "SELECT * FROM clientes WHERE email = ?";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            // Devuelve falso en caso de error
            return false;
        }
    }
}
