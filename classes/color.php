<?php
session_start();
include_once '../include/zeus_tfg.php';

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

    public function getBackgroundColor()
    {
        switch ($this->id_color) {
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

    public static function select()
    {
        $conexion = camisetasDB::connectDB();
        $sql = "SELECT id_color, nombre_color FROM colores";
        try {
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $colores = [];
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
            echo "Error al obtener el detalle del color: " . $e->getMessage();
            return false;
        }
    }
}
