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
<div class="menu">
    <ul class="menu-content">
        <li><a href="home.php">Home</a></li>
        <li><a href="carrito.php">Carrito</a></li>
        <li><a href="pedidos.php">Pedidos</a></li>
    </ul>
</div>

<!-- Campo de la Cookie -->
<div>
    <?php
    if (!isset($_GET['Bienvenido']) && !isset($_COOKIE['politica'])):
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
        <?php
        try {
            // Obtiene la lista de productos utilizando la función select de la clase Producto
            $productos = Producto::select();
            // Verifica si hay productos antes de mostrarlos
            if (!empty($productos)) {
                foreach ($productos as $producto) {
                    echo '<h3 class="titulo">' . $producto->getNombre() . '</h3>';
                    echo '<p class="titulo">Código: ' . $producto->getIdproducto() . '</p>';
                    echo '<p class="titulo">Precio: $' . $producto->getPrecio() . '</p>';
                    echo '<img src="' . $producto->getImagen() . '" alt="' . $producto->getNombre() . '">';

                    echo '<br>';

                    // Formulario para agregar al carrito el producto
                    echo '<form action="carrito.php" method="post">';
                    echo '<input type="hidden" name="id_producto" value="' . $producto->getIdproducto() . '">';
                    echo '<input type="hidden" name="nombre" value="' . $producto->getNombre() . '">';
                    echo '<input type="hidden" name="precio" value="' . $producto->getPrecio() . '">';

                    // Campo para seleccionar la cantidad
                    echo '<label for="cantidad" class="label_cantidad">Cantidad:</label>';
                    echo '<input type="number" name="cantidad" min="1" max="10" value="1">';

                    echo '<br>';

                    // Botón para agregar al carrito
                    echo '<input type="submit" name="agregar_al_carrito" value="Agregar al Carrito" class="formulario_submit">';
                    echo '</form>';
                }
            } else {
                echo 'No hay productos disponibles en este momento.';
            }
        } catch (PDOException $e) {
            die('Error al conectarse a la base de datos: ' . $e->getMessage());
        }
        ?>
    </div>

    <!-- Enlace para cerrar la sesión-->
    <a href="cerrar.php">Cerrar sesión</a>

</div>

</body>

</html>
