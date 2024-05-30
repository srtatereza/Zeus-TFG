<?php
session_start();
include_once '../include/zeus_tfg.php';

/**
 * Modelo de pedidos
 */
class Pedido
{
    private $id_pedido;
    private $fecha;
    private $id_cliente;
    private $id_producto;
    private $cantidad_producto;
    private $id_color;
    private $id_talla;
    private $estado_pedido;

    function __construct($fecha, $id_cliente, $id_producto, $cantidad_producto, $id_color, $id_talla, $estado_pedido,)
    {
        $this->id_pedido = null;
        $this->fecha = $fecha;
        $this->id_cliente = $id_cliente;
        $this->id_producto = $id_producto;
        $this->cantidad_producto = $cantidad_producto;
        $this->id_color = $id_color;
        $this->id_talla = $id_talla;
        $this->estado_pedido = $estado_pedido;
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
    public function getId_color()
    {
        return $this->id_color;
    }
    public function getId_talla()
    {
        return $this->id_talla;
    }
    public function getEstado_pedido()
    {
        return $this->estado_pedido;
    }

    /**
     * Inserta un pedido en la base de datos con los datos de este objeto
     */
    public function insert()
    {
        try {
            // Conectar a la base de datos
            $conexion = CamisetasDB::connectDB();

            // Insertar el pedido con el id_producto_color_talla obtenido
            $sql_insert = "INSERT INTO pedidos 
                (fecha, id_cliente, id_producto, cantidad_producto, id_color, id_talla)
                VALUES (?, ?, ?, ?, ?, ?)";

            $stmt_insert = $conexion->prepare($sql_insert);
            $stmt_insert->execute([
                $this->fecha,
                $this->id_cliente,
                $this->id_producto,
                $this->cantidad_producto,
                $this->id_color,
                $this->id_talla
            ]);
        } catch (PDOException $e) {
            // Relanzamos el error para manejarlo posteriormente
            error_log("Error en la base de datos: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Función para obtener los pedidos de un cliente con detalles completos, por id del cliente
     * Retorna un array con los pedidos
     */
    public static function select($id_cliente)
    {
        try {
            $conexion = CamisetasDB::connectDB();

            // Obtener información completa de los pedidos del cliente
            $sql = "SELECT 
                p.id_pedido AS id_pedido,
                p.fecha AS fecha,
                pr.nombre AS nombre,
                co.nombre_color AS color,
                ta.numero_talla AS talla,
                p.cantidad_producto AS cantidad_producto,
                p.estado_pedido AS estado
                FROM pedidos p
                JOIN clientes c ON p.id_cliente = c.id_cliente
                JOIN producto_color_talla pct ON p.id_producto = pct.id_producto AND p.id_color = pct.id_color AND p.id_talla = pct.id_talla
                JOIN productos pr ON pct.id_producto = pr.id_producto
                JOIN colores co ON pct.id_color = co.id_color
                JOIN tallas ta ON pct.id_talla = ta.id_talla
                WHERE p.id_cliente = ?
                ORDER BY p.fecha;
            ";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_cliente]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Devuelve falso en caso de error
            error_log("Error en la base de datos: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un pedido de la base de datos
     */
    public static function delete($id_pedido, $id_cliente)
    {
        try {
            $conexion = CamisetasDB::connectDB();
            $sql = "DELETE FROM pedidos WHERE id_pedido = ? AND id_cliente = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_pedido, $id_cliente]);
        } catch (PDOException $e) {
            // Relanzamos el error para manejarlo posteriormente
            error_log("Error en la base de datos: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Función para obtener todos los pedidos
     * Retorna un array con los pedidos
     */
    public static function selectAllPedidos()
    {
        try {
            $conexion = CamisetasDB::connectDB();
            $sql = "SELECT 
            p.id_pedido AS id_pedido,
            p.fecha AS fecha,
            c.nombre as nombre_cliente,
            c.apellido as apellido_cliente,
            pr.nombre AS nombre_producto,
            co.nombre_color AS color,
            ta.numero_talla AS talla,
            p.cantidad_producto AS cantidad_producto,
            p.estado_pedido AS estado_pedido
        FROM pedidos p
        JOIN clientes c ON p.id_cliente = c.id_cliente
        JOIN producto_color_talla pct ON p.id_producto = pct.id_producto AND p.id_color = pct.id_color AND p.id_talla = pct.id_talla
        JOIN productos pr ON pct.id_producto = pr.id_producto
        JOIN colores co ON pct.id_color = co.id_color
        JOIN tallas ta ON pct.id_talla = ta.id_talla
        ORDER BY p.fecha;
    ";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Retornamos falso en caso de error
            error_log("Error en la base de datos: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Función para actualizar el estado de un pedido, por id de pedido y estado
     */
    public static function updateEstadoPedido($id_pedido, $estado_pedido)
    {
        try {
            $conexion = CamisetasDB::connectDB();
            $sql = "UPDATE pedidos SET estado_pedido = ? WHERE id_pedido = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$estado_pedido, $id_pedido]);
        } catch (Exception $e) {
            // Relanzamos el error para manejarlo posteriormente
            error_log("Error en la base de datos: " . $e->getMessage());
            throw $e;
        }
    }
}
