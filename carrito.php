<?php
session_start();
include 'components/configuracion.php';
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
    <title>Carrito</title>
    <!-- Enlace al archivo CSS externo -->
    <?php include 'components/enlace.php'; ?>
</head>

<body>

    <!-- Menu -->
    <?php include 'components/menu.php'; ?>
    <div class="publicidad">
            <p>Alta calidad y estilo único. ¡Encuentra la tuya y destaca!</p>
        </div>

    <div class="contenedor-central">
        <?php

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

                echo '<p class="mensaje">Producto agregado al carrito.</p>';
            }
        }

        // Eliminar un producto del carrito
        if (isset($_POST['eliminar_producto'])) {
            $id_productoEliminar = $_POST['eliminar_producto'];
            unset($_SESSION['carrito'][$id_productoEliminar]);
            echo '<p class="card-text">Producto eliminado del carrito.</p>';
        }

        // Vaciar el carrito
        if (isset($_POST['vaciar'])) {
            unset($_SESSION['carrito']);
            echo '<p class="card-text">El carrito ha sido vaciado.</p>';
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
                        $pedido = new Pedido($fechaCompra, $id_cliente, $id_producto, $cantidad_producto, $id_color, $id_talla, 'en preparación');
                        $pedido->insert();

                        // Vaciar el carrito después de la compra
                        $_SESSION['carrito'] = [];

                        echo '<p class="card-text">Compra realizada con éxito.</p>';
                        echo '<a class="mensaje-producto" href="pedidos.php">Ver la factura de mi pedido</a>';
                        echo '<br>';
                    } catch (PDOException $e) {
                        error_log("Error en la base de datos: " . $e->getMessage());
                        var_dump($e);
                        echo "<p>Error al realizar la compra, contacte con el administrador.</p>";
                    }
                }
            } else {
                echo '<p>Error: El carrito está vacío o no se ha identificado al cliente.</p>';
            }
        }

        ?>


        <div class="productos-carrito">
            <h2>Carrito de Compras</h2>
            <?php

            // Mostrar el contenido del carrito


            if (!empty($_SESSION['carrito'])) {
                $total = 0;
                echo '<div class="row">'; // Inicio del contenedor row
                foreach ($_SESSION['carrito'] as $id_producto => $producto) {
                    echo '<div class="col-6 col-md-4 col-lg-3 mb-4">'; // Contenedor de cada producto
                    echo '<div class="card h-100">'; // Card para el producto
                    echo '<img src="' . $producto['imagen'] . '" class="card-img-top" alt="' . $producto['nombre'] . '">';
                    echo '<div class="card-body">';
                    echo '<h3 class="card-title">' . $producto['nombre'] . '</h3>';
                    echo '<p class="card-text">Talla: ' . $producto['numero_talla'] . '</p>';
                    echo '<p class="card-text">Color: ' . $producto['nombre_color'] . '</p>';
                    echo '<p class="card-text">Precio: $' . $producto['precio'] . ' c/u</p>';
                    $precio_total_producto = $producto['precio'] * $producto['cantidad'];
                    $total += $precio_total_producto;
                    echo '<p class="card-text">Cantidad: ' . $producto['cantidad'] . ' = Precio: $' . $precio_total_producto . '</p>';

                    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                    echo '<input type="hidden" name="eliminar_producto" value="' . $id_producto . '">';
                    echo '<button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>';
                    echo '</form>';

                    echo '</div>'; // Cierre de card-body
                    echo '</div>'; // Cierre de card
                    echo '</div>'; // Cierre de col
                }
                echo '</div>'; // Cierre del contenedor row

            ?>

                <div class=contenedor-inferior-carrito>
                <?php

                // Mostrar el total de la compra
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<p class="card-text">Precio Total: $' . $total . '</p>';
                echo '</div>'; // Cierre de col
                echo '</div>'; // Cierre de row

                // Formulario para comprar los productos
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<button type="submit" name="comprar" class="btn btn-success">Comprar</button>';
                echo '</form>';
                echo '</div>'; // Cierre de col
                echo '</div>'; // Cierre de row

                // Formulario para vaciar el carrito
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<button type="submit" name="vaciar" class="btn btn-warning">Vaciar</button>';
                echo '</form>';
                echo '</div>'; // Cierre de col
                echo '</div>'; // Cierre de row
                echo '</div>'; // Cierre del contenedor
            } else {
                echo '<p class="mensaje-producto">No hay productos en el carrito.</p>';
            }
                ?>
                <div class="publicidad-dos">
                    <?php
                    // Enlace para volver a home
                    echo '<a href="home.php">Seguir Comprando</a>';
                    echo '<br>';
                    ?>
                </div>
                </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>


</body>