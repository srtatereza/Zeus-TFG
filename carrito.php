<?php
session_start();
include_once 'include/zeus_tfg.php';
include_once 'components/configuracion.php';
include_once 'classes/cliente.php';
include_once 'classes/producto.php';
include_once 'classes/pedido.php';
include_once 'classes/color.php';
include_once 'classes/talla.php';
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

    <div class="contenedor-central-fondo">
        <div class="contenedor-central">
            <?php

            // Agregar un producto al carrito
            if (isset($_POST['agregar_al_carrito'])) {
                // Verificar si se han enviado los datos del formulario
                if (isset($_POST['id_producto'], $_POST['nombre'], $_POST['precio'], $_POST['cantidad'], $_POST['talla'], $_POST['color'], $_POST['imagen'])) {
                    $id_producto = trim($_POST['id_producto']);
                    $nombre = trim($_POST['nombre']);
                    $precio = trim($_POST['precio']);
                    $imagen = trim($_POST['imagen']);
                    $cantidad = (int) trim($_POST['cantidad']);
                    $id_talla = trim($_POST['talla']);
                    $id_color = trim($_POST['color']);

                    // Se buscar en la base de datos el id_color y el id_talla correspondientes al nombre_color y numero_talla
                    // y se almacena junto con otros detalles del producto en el carrito

                    $tallas = Talla::select();
                    $colores = Color::select();

                    $numero_talla = $tallas[$id_talla]->getNumeroTalla();
                    $nombre_color = $colores[$id_color]->getNombreColor();

                    // Luego, cuando tenga los IDs, puedes almacenarlos en el carrito así:
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
                } else {
                    echo '<p class="mensaje">Error al agregar el producto al carrito.</p>';
                }
                // Al realizar la compra
            } else if (isset($_POST['comprar'])) {
                // obtener la fecha de la compra
                $fechaCompra = date('Y-m-d H:i:s');

                foreach ($_SESSION['carrito'] as $producto) {
                    $id_producto = $producto['id_producto'];
                    $id_cliente = $_SESSION['id_cliente'];
                    $cantidad_producto = $producto['cantidad'];
                    $id_color = $producto['id_color'];
                    $id_talla = $producto['id_talla'];

                    // Insertar el pedido en la tabla pedidos usando los IDs del color y la talla obtenidos del carrito
                }
                try {
                    $pedido = new Pedido($fechaCompra, $id_cliente, $id_producto, $cantidad_producto, $id_color, $id_talla, 'en preparación');
                    $pedido->insert();
                } catch (PDOException $e) {
                    echo "<p>Error al realizar la compra, contacte con el administrador.</p>";
                }
                // Vaciar el carrito después de la compra
                $_SESSION['carrito'] = [];
                echo '<p class="card-text">Compra realizada con éxito.</p>';
                echo '<a class="mensaje-producto" href="pedidos.php">Ver la factura de mi pedido</a>';
                echo '<br>';
                // Procesar la eliminación de un producto del carrito
            } elseif (isset($_POST['eliminar_producto'])) {
                $id_productoEliminar = $_POST['eliminar_producto'];
                unset($_SESSION['carrito'][$id_productoEliminar]);
                echo '<p class="card-text">Producto eliminado del carrito.</p>';

                // Vaciar el carrito
            } elseif (isset($_POST['vaciar'])) {
                unset($_SESSION['carrito']);
                echo '<p class="card-text"> Error:El carrito ha sido vaciado.</p>';
            }

            ?>


            <!-- Muestra productos en el carrito y calcula el total de la compra -->
            <div class="productos-carrito">
                <h2>Carrito de Compras</h2>
                <?php

                // Mostrar el contenido del carrito
                if (!empty($_SESSION['carrito'])) {
                    $total = 0;
                    echo '<div class="row">'; // Inicio del contenedor row 
                    foreach ($_SESSION['carrito'] as $id_producto => $producto) {
                        echo '<div class="col-6 col-md-4 col-lg-3 mb-4">'; // CSS para contenedor de cada producto
                        echo '<div class="card h-100">'; // CSS para el producto
                        echo '<img src="' . $producto['imagen'] . '" class="card-img-top" alt="' . $producto['nombre'] . '">';
                        echo '<div class="card-body">';
                        echo '<h3 class="card-title">' . $producto['nombre'] . '</h3>';
                        echo '<p class="card-text">Talla: ' . $producto['numero_talla'] . '</p>';
                        echo '<p class="card-text">Color: ' . $producto['nombre_color'] . '</p>';
                        echo '<p class="card-text">Precio: $' . $producto['precio'] . ' c/u</p>';
                        // Calcular el precio total de la compra
                        $precio_total_producto = $producto['precio'] * $producto['cantidad'];
                        $total += $precio_total_producto;
                        // Mostrar la cantidad y el precio total de la compra del producto
                        echo '<p class="card-text">Cantidad: ' . $producto['cantidad'] . ' = Precio: $' . $precio_total_producto . '</p>';

                        // Formulario para eliminar un producto del carrito
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
                    <!-- Contenedor para mostrar el total de la compra  -->
                    <div class=contenedor-inferior-carrito>
                    <?php
                    echo '<div class="row">';
                    echo '<div class="col-12">';
                    // Mostrar el precio total de la compra
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

                    // Formulario para vaciar todo el carrito
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
                    <!-- Contenedor para mostrar enlace para volver a home-->
                    <div class="publicidad-dos">
                        <?php
                        echo '<a href="home.php">Seguir Comprando</a>';
                        echo '<br>';
                        ?>
                    </div>

                    </div>
            </div>

            <!-- Footer -->
            <?php include 'components/footer.php'; ?>
        </div>

    </div>

</body>

</html>