<?php
session_start();
include_once '../include/zeus_tfg.php';
include_once 'classes/color.php';
include_once 'classes/talla.php';

class Producto
{
    private $id_producto;
    private $nombre;
    private $precio;
    private $imagen;
    private $tallas;
    private $colores;

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
        $this->tallas = [];
        $this->colores = [];
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

    public function getTallas()
    {
        return $this->tallas;
    }

    public function getColores()
    {
        return $this->colores;
    }

    public function setTallas(array $tallas)
    {
        $this->tallas = $tallas;
    }

    public function setColores(array $colores)
    {
        $this->colores = $colores;
    }

    public static function select()
    {
        $conexion = camisetasDB::connectDB();
        $sql = "
            SELECT p.id_producto, p.nombre, p.precio, p.imagen, c.id_color, c.nombre_color, t.id_talla, t.numero_talla
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
                $producto = $productos[$id_producto];
                if (!isset($producto)) {
                    $productoNuevo = new Producto(
                        $row['id_producto'],
                        $row['nombre'],
                        $row['precio'],
                        $row['imagen']
                    );
                    $productos[$id_producto] = $productoNuevo;
                } 

                $id_color = $row['id_color'];
                $nombre_color = $row['nombre_color'];
                $colores = $productoNuevo->getColores();
                $colores[$id_color] = new Color($id_color, $nombre_color);
                $productos[$id_producto]->setColores($colores);

                $id_talla = $row['id_talla'];
                $numero_talla = $row['numero_talla'];
                $tallas = $productoNuevo->getTallas();
                $tallas[$id_talla] = new Talla($id_talla, $numero_talla);
                $productos[$id_producto]->setTallas($tallas);
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

