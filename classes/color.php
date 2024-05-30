<?php
session_start();
include_once '../include/zeus_tfg.php';

/**
 * Modelo de colores
 */
class Color
{
    private $id_color;
    private $nombre_color;

    function __construct($id_color, $nombre_color)
    {
        $this->id_color = $id_color;
        $this->nombre_color = $nombre_color;
    }

    public function getIdColor()
    {
        return $this->id_color;
    }

    public function getNombreColor()
    {
        return $this->nombre_color;
    }

    /**
     * Devuelve true si el color es el blanco
     */
    public function getCheckedColor()
    {
        return $this->getIdColor() == '4';
    }

    /**
     * Devuelve el color CSS correspondiente
     */
    public function getBackgroundColor()
    {
        switch ($this->getIdColor()) {
            case '1':
                return 'red';
            case '2':
                return 'blue';
            case '3':
                return 'black';
            case '4':
                return 'white';
        }
    }

    /**
     * Función para obtener todos los colores
     * Devuelve el resultado en un array de colores
     */
    public static function select()
    {
        $conexion = CamisetasDB::connectDB();
        $sql = "SELECT id_color, nombre_color FROM colores";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $colores = [];
            
            // Mapeamos el resultado a un array de colores
            foreach ($resultados as $row) {
                $id_color = $row['id_color'];
                $nombre_color = $row['nombre_color'];
                $color = new Color(
                    $id_color,
                    $nombre_color
                );
                $colores[$id_color] = $color;
            }
            return $colores;
        } catch (PDOException $e) {
            // Retornamos falso en caso de error
            error_log("Error en la base de datos: " . $e->getMessage());
            return false;
        }
    }
}
