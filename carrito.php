<?php
session_start();
include_once 'classes/cliente.php';
include_once 'classes/producto.php';
include_once 'classes/pedido.php';
include_once 'classes/color.php';
include_once 'classes/talla.php';
include_once 'include/zeus_tfg.php';
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

    <?php

    // Establecer el nivel de reporte de errores
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Agregar un producto al carrito
    if (isset($_POST['agregar_al_carrito'])) {
        $tallas = Talla::select();
        $colores = Color::select();

        if (isset($_POST['id_producto'], $_POST['nombre'], $_POST['precio'], $_POST['cantidad'], $_POST['talla'], $_POST['color'], $_POST['imagen'])) {
            $id_producto = trim($_POST['id_producto']);
            $nombre = trim($_POST['nombre']);
            $precio = trim($_POST['precio']);
            $imagen = trim($_POST['imagen']);
            $cantidad = (int) trim($_POST['cantidad']);
            $id_talla = trim($_POST['talla']);
            $id_color = trim($_POST['color']);

            // Aquí debes buscar en la base de datos el id_color y el id_talla correspondientes al nombre_color y numero_talla
            // y almacenarlos junto con otros detalles del producto en el carrito

            $numero_talla = $tallas[$id_talla]->getNumeroTalla();
            $nombre_color = $colores[$id_color]->getNombreColor();

            // Luego, cuando tengas los IDs, puedes almacenarlos en el carrito así:
            $_SESSION['carrito'][$id_producto] = array(
                'id_producto' => $id_producto,
                'nombre' => $nombre,
                'precio' => $precio,
                'imagen' => $imagen,
                'cantidad' => $cantidad,
                'numero_talla' => $numero_talla,
                'nombre_color' => $nombre_color,
                'id_color' => $id_color, // Agregar el ID del color al carrito
                'id_talla' => $id_talla // Agregar el ID de la talla al carrito
            );

            echo '<p>Producto agregado al carrito.</p>';
        }
    }

    // Eliminar un producto del carrito
    if (isset($_POST['eliminar_producto'])) {
        $id_productoEliminar = $_POST['eliminar_producto'];
        unset($_SESSION['carrito'][$id_productoEliminar]);
        echo '<p>Producto eliminado del carrito.</p>';
    }

    // Vaciar el carrito
    if (isset($_POST['vaciar'])) {
        unset($_SESSION['carrito']);
        echo '<p>El carrito ha sido vaciado.</p>';
    }

    // Al realizar la compra
    if (isset($_POST['comprar'])) {
        $fechaCompra = date('Y-m-d H:i:s');

        if (isset($_SESSION['carrito']) && isset($_SESSION['id_cliente'])) {
            $id_cliente = $_SESSION['id_cliente'];

            foreach ($_SESSION['carrito'] as $producto) {
                $id_producto = $producto['id_producto'];
                $cantidad_producto = $producto['cantidad'];
                $id_color = $producto['id_color']; // Obtén el ID del color del carrito
                $id_talla = $producto['id_talla']; // Obtén el ID de la talla del carrito

                // Aquí debes insertar el pedido en la tabla pedidos usando los IDs del color y la talla obtenidos del carrito

                // Crear y ejecutar la inserción del pedido
                try {
                    $pedido = new Pedido($fechaCompra, $id_cliente, $id_producto, $cantidad_producto, $id_color, $id_talla);
                    $pedido->insert();

                    // Vaciar el carrito después de la compra
                    $_SESSION['carrito'] = [];

                    echo '<p>Compra realizada con éxito.</p>';
                    echo '<a href="pedidos.php">Ver la factura de mi pedido</a>';
                    echo '<br>';
                } catch(PDOException $e) {
                    error_log("Error en la base de datos: " . $e->getMessage());
                    echo "<p>Error al realizar la compra, contacte con el administrador.</p>";
                }
            }
        } else {
            echo '<p>Error: El carrito está vacío o no se ha identificado al cliente.</p>';
        }
    }

    // Mostrar el contenido del carrito
    if (!empty($_SESSION['carrito'])) {
        $total = 0;
        foreach ($_SESSION['carrito'] as $id_producto => $producto) {
            echo '<img src="' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
            echo '<p class="titulo_c">Nombre: ' . $producto['nombre'] . '</p>';
            echo '<p class="titulo_c">Talla: ' . $producto['numero_talla'] . '</p>';
            echo '<p class="titulo_c">Color: ' . $producto['nombre_color'] . '</p>';
            echo '<p class="titulo_c">Precio: $' . $producto['precio'] . ' c/u</p>';
            $precio_total_producto = $producto['precio'] * $producto['cantidad'];
            $total += $precio_total_producto;
            echo '<p class="titulo_c">Cantidad: ' . $producto['cantidad'] . ' = Precio: $' . $precio_total_producto . '</p>';
            echo '<br>';

            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            echo '<input type="hidden" name="eliminar_producto" value="' . $id_producto . '">';
            echo '<input type="submit" name="eliminar" value="Eliminar" class="formulario_submit_eliminar">';
            echo '</form>';

            echo '<br>';
        }

        // Mostrar el total de la compra
        echo '<p class="titulo_c">Precio Total: $' . $total . '</p>';
        echo '<br>';

        // Formulario para comprar los productos
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<input type="submit" name="comprar" value="Comprar" class="formulario_submit">';
        echo '</form>';

        echo '<br>';

        // Formulario para vaciar el carrito
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<input type="submit" name="vaciar" value="Vaciar" class="formulario_submit">';
        echo '</form>';
    } else {
        echo '<p>No hay productos en el carrito.</p>';
    }

    // Enlace para volver a home
    echo '<a href="home.php">Seguir Comprando</a>';
    echo '<br>';
    ?>

</body>