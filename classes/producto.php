<?php
session_start();
include_once '../include/zeus_tfg.php';

class Producto
{
    private $id_producto;
    private $nombre;
    private $precio;
    private $imagen;



    function __construct(
        $id_producto,
        $nombre,
        $precio,
        $imagen
    ) {
        $this->id_producto = $id_producto;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->imagen = $imagen;
    }

    public function getIdproducto()
    {
        return $this->id_producto;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getImagen()
    {
        return $this->imagen;
    }



    public static function select() {
        $conexion = camisetasDB::connectDB();
        $sql = "
            SELECT p.id_producto, p.nombre, p.precio, p.imagen, c.nombre_color, t.numero_talla
            FROM productos p
            JOIN producto_color_talla pct ON p.id_producto = pct.id_producto
            JOIN colores c ON pct.id_color = c.id_color
            JOIN tallas t ON pct.id_talla = t.id_talla
            WHERE p.id_producto BETWEEN 1 AND 9
        ";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organizar los productos en un array asociativo
            $productos = [];
            foreach ($resultados as $row) {
                $id_producto = $row['id_producto'];

                if (!isset($productos[$id_producto])) {
                    $producto = new Producto(
                        $row['id_producto'],
                        $row['nombre'],
                        $row['precio'],
                        $row['imagen']
                    );
                    $productos[$id_producto] = $producto;
                }

                // Agregar colores y tallas a cada producto
                $productos[$id_producto]->colores[] = $row['nombre_color'];
                $productos[$id_producto]->tallas[] = $row['numero_talla'];
            }

            return $productos;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return false;
        }
    }


// Función para obtener el ID y el nombre de la talla o el color
public static function obtenerDetalleTallaColor($valor, $tipo)
{
    $conexion = camisetasDB::connectDB();
    $sql = "";
    if ($tipo === "talla") {
        $sql = "SELECT id_talla, numero_talla FROM tallas WHERE numero_talla = ?";
    } elseif ($tipo === "color") {
        $sql = "SELECT id_color, nombre_color FROM colores WHERE nombre_color = ?";
    }

    try {
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(1, $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener el detalle de la talla o el color: " . $e->getMessage();
        return false;
    }
}



}
?>
    