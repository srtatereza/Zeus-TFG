<?php
session_start();
include_once 'include/zeus_tfg.php';
include_once 'classes/producto.php';
include_once 'classes/cliente.php';

// Ejecucion de una Cookie
// Si han aceptado la política de Cookies
if (isset($_REQUEST['Bienvenido'])) {
    setcookie('politica', '1', time() + 600, '/');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda_Camisetas</title>
    <!-- Enlace al archivo CSS externo -->
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>

    <!-- Menu -->
    <?php include "components/menu.php" ?>

    <!-- Campo de la Cookie -->
    <div>
        <?php
        if (!isset($_GET['Bienvenido']) && !isset($_COOKIE['politica'])) :
        ?>
            <!-- Mensaje de cookies -->
            <div class="cookies">
                <h2>Cookies</h2>
                <p>¿Aceptas nuestras cookies?</p>
                <a href="?Bienvenido">Sí, con todas sus consecuencias</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="contenedor">
        <?php
        // Verifica si hay una sesión activa
        if (isset($_SESSION['email'])) {
            $correoUsuario = htmlspecialchars($_SESSION['email']);
            echo "<h1> Estas en Tu perfil, $correoUsuario. <br> Ahora puedes comprar lo que te guste.</h1>";
        } else {
            // Si no hay sesión activa, redirige al usuario al inicio de sesión
            header("Location: login.php");
            exit();
        }
        ?>
<!-- Productos -->
<div class="productos">
<div class="productos">
    <?php
    try {
        $productos = Producto::select();
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                echo '<div>';
                echo '<h3 class="titulo">' . $producto->getNombre() . '</h3>';
                echo '<p class="titulo">Precio: $' . $producto->getPrecio() . '</p>';
                echo '<img src="' . $producto->getImagen() . '" alt="' . $producto->getNombre() . '">';
                
                // Formulario para agregar al carrito
                echo '<form action="carrito.php" method="post">';
                echo '<input type="hidden" name="id_producto" value="' . $producto->getIdProducto() . '">';
                echo '<input type="hidden" name="nombre" value="' . $producto->getNombre() . '">';
                echo '<input type="hidden" name="precio" value="' . $producto->getPrecio() . '">';
                echo '<input type="hidden" name="imagen" value="' . $producto->getImagen() . '">';
                
                // Campo para seleccionar la cantidad
                echo '<label for="cantidad_' . $producto->getIdProducto() . '" class="label_cantidad">Cantidad:</label>';
                echo '<input type="number" id="cantidad_' . $producto->getIdProducto() . '" name="cantidad" min="1" max="10" value="1">';
                
                // Campo para seleccionar el color
                echo '<label class="label_color">Color:</label>';
                echo '<div class="color-options">';
                foreach ($producto->getColores() as $color) {
                    echo '<label class="color-option">';
                    echo '<input type="radio" name="color" value="' . $color->getIdColor() . '" style="display: none;">';
                    echo '<span class="color-circle" style="background-color:' . $color->getBackgroundColor() . ';"></span>';
                    echo '</label>';
                }
                echo '</div>';
                
                // Campo para seleccionar la talla
                echo '<label for="talla_' . $producto->getIdProducto() . '" class="label_talla">Talla:</label>';
                echo '<select id="talla_' . $producto->getIdProducto() . '" name="talla">';
                foreach ($producto->getTallas() as $talla) {
                    echo '<option value="' . $talla->getIdTalla() . '">' . strtoupper($talla->getNumeroTalla()) . '</option>';
                }
                echo '</select>';
                
                echo '<br>';
                
                // Botón para agregar al carrito
                echo '<input type="submit" name="agregar_al_carrito" value="Agregar al Carrito" class="formulario_submit">';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo 'No hay productos disponibles en este momento.';
        }
    } catch (PDOException $e) {
        die('Error al conectarse a la base de datos: ' . $e->getMessage());
    }
    ?>
</div>

</div>
    
        <!-- Enlace para cerrar la sesión-->
        <a href="cerrar.php">Cerrar sesión</a>

    </div>

</body>

</html>