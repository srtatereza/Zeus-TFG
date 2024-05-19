<?php
session_start();
include_once '../include/zeus_tfg.php';

class Pedido
{
    private $id_pedido;
    private $fecha;
    private $id_cliente;
    private $id_producto;
    private $cantidad_producto;
    private $id_color;
    private $id_talla;

    function __construct($id_pedido, $fecha, $id_cliente, $id_producto, $cantidad_producto, $id_color, $id_talla)
    {
        $this->id_pedido = $id_pedido;
        $this->fecha = $fecha;
        $this->id_cliente = $id_cliente;
        $this->id_producto = $id_producto;
        $this->cantidad_producto = $cantidad_producto;
        $this->id_color = $id_color;
        $this->id_talla = $id_talla;
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



        // Método para insertar el pedido en la base de datos
        public function insert() {
            try {
                // Conectar a la base de datos
                $conexion = camisetasDB::connectDB();
    
                // Obtener el id_producto_color_talla del producto seleccionado
                $sql = "SELECT id_producto_color_talla
                        FROM producto_color_talla
                        WHERE id_producto = ? AND id_color = ? AND id_talla = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$this->id_producto, $this->id_color, $this->id_talla]);
                $producto_color_talla_info = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (!$producto_color_talla_info) {
                    // Si no se encuentra el id_producto_color_talla, mostrar un mensaje de error
                    echo '<p>Error: No se pudo encontrar el producto con la talla y color seleccionados.</p>';
                    return;
                }
    
                // Insertar el pedido con el id_producto_color_talla obtenido
                $sql_insert = "INSERT INTO pedidos (fecha, id_cliente, id_producto_color_talla, cantidad_producto)
                               VALUES (?, ?, ?, ?)";
                $stmt_insert = $conexion->prepare($sql_insert);
                $stmt_insert->execute([$this->fecha, $this->id_cliente, $producto_color_talla_info['id_producto_color_talla'], $this->cantidad_producto]);
    
                // Confirmar la compra
                echo '<p>Compra realizada con éxito.</p>';
            } catch (PDOException $e) {
                // Manejar el error
                echo "Error en la base de datos: " . $e->getMessage();
            }
        }



// Función para obtener los pedidos de un cliente con detalles completos
public static function select($id_cliente)
{
    try {
        $conexion = camisetasDB::connectDB();
        // Obtener información completa de los pedidos del cliente
        $sql = "SELECT p.id_pedido, p.fecha, pr.nombre AS nombre_producto, pc.id_color, t.nombre AS numero_talla, p.cantidad_producto AS cantidad_producto, p.estado_pedido
        FROM pedidos p 
        JOIN productos pr ON p.id_producto = pr.id_producto
        JOIN producto_color pc ON p.id_producto = pc.id_producto
        JOIN tallas t ON p.id_talla = t.id_talla
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