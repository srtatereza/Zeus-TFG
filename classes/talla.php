<?php
session_start();
include_once '../include/zeus_tfg.php';

/**
 * Modelo de tallas
 */
class Talla
{
    private $id_talla;
    private $numero_talla;

    function __construct($id_talla, $numero_talla)
    {
        $this->id_talla = $id_talla;
        $this->numero_talla = $numero_talla;
    }

    public function getIdTalla()
    {
        return $this->id_talla;
    }

    public function getNumeroTalla()
    {
        return $this->numero_talla;
    }

    /**
     * Obtener todas las tallas
     */
    public static function select()
    {
        $conexion = CamisetasDB::connectDB();
        $sql = "SELECT id_talla, numero_talla FROM tallas";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $tallas = [];

            // Recorremos los resultados y creamos objetos Talla
            foreach ($resultados as $row) {
                $id_talla = $row['id_talla'];
                $numero_talla = $row['numero_talla'];
                $talla = new Talla(
                    $id_talla,
                    $numero_talla
                );
                $tallas[$id_talla] = $talla;
            }
            return $tallas;
        } catch (PDOException $e) {
            // Retornamos falso en caso de error
            error_log("Error en la base de datos: " . $e->getMessage());
            return false;
        }
    }
}
