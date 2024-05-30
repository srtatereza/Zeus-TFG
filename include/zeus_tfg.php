<?php

/**
 * Conexión con la base de datos
 */
abstract class CamisetasDB
{
  private static $server = 'localhost:3307';
  private static $db = 'zeus_tfg';
  private static $user = 'root';
  private static $password = '';

  /**
   * Conexión con la base de datos, devuelve el objeto PDO
   */
  public static function connectDB()
  {
    try {
      $conexion = new PDO("mysql:host=" . self::$server . ";dbname=" . self::$db . ";charset=utf8", self::$user, self::$password);
    } catch (PDOException $e) {
      echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
      die("Error: " . $e->getMessage());
    }
    return $conexion;
  }
}
