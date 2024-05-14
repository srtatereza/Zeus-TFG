<?php
session_start();
include_once '../include/camisetasDB.php';

class Pedido
{
    private $id_pedido;
    private $fecha;
    private $id_cliente;
    private $id_producto;
    private $cantidad_producto;

    function __construct($id_pedido, $fecha, $id_cliente, $id_producto, $cantidad_producto)
    {
        $this->id_pedido = $id_pedido;
        $this->fecha = $fecha;
        $this->id_cliente = $id_cliente;
        $this->id_producto = $id_producto;
        $this->cantidad_producto = $cantidad_producto;
    }

    public function getId_pedido()
    {
        return $this->id_pedido;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getId_cliente()
    {
        return $this->id_cliente;
    }

    public function getIdproducto()
    {
        return $this->id_producto;
    }

    public function getCantidad_producto()
    {
        return $this->cantidad_producto;
    }

    // Función para insertar un pedido
    public function insert()
    {
        try {
            $conexion = camisetasDB::connectDB();
            $sql = "INSERT INTO pedidos (fecha, id_cliente, id_producto, cantidad_producto) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$this->fecha, $this->id_cliente, $this->id_producto, $this->cantidad_producto]);
        } catch (Exception $e) {
            // Manejar el error
            echo "Error en la base de datos: " . $e->getMessage();
        }
    }

    // Función para obtener los pedidos de un cliente
    public static function select($id_cliente)
    {
        try {
            $conexion = camisetasDB::connectDB();
            // Obtener información de los pedidos y productos asociados del cliente
            $sql = "SELECT p.id_pedido, p.fecha, pr.nombre, p.cantidad_producto as cantidad_producto
            FROM pedidos p 
            JOIN productos pr ON p.id_producto = pr.id_producto
            WHERE p.id_cliente = ? 
            ORDER BY p.fecha DESC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_cliente]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            // Devuelve falso en caso de error
            return false;
        }
    }

    // Función para eliminar un pedido
    public static function delete($id_pedido, $id_cliente)
    {
        try {
            $conexion = camisetasDB::connectDB();
            $sql = "DELETE FROM pedidos WHERE id_pedido = ? AND id_cliente = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_pedido, $id_cliente]);
        } catch (Exception $e) {
            // Manejar el error
            echo "Error al eliminar el pedido: " . $e->getMessage();
        }
    }
}
