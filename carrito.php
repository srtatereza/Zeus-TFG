<?php
session_start();
include_once 'classes/cliente.php';
include_once 'classes/producto.php';
include_once 'classes/pedido.php';
include_once 'include/camisetasDB.php';
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

<div class="contenedor">
    <!-- Carrito -->
    <div class="carrito-producto">
        <h2>Carrito de Compras</h2>
        <?php
        // Verifica si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Agregar un producto al carrito
            if (isset($_POST['agregar_al_carrito'])) {
                $id_producto = trim($_POST['id_producto']);
                $nombre = trim($_POST['nombre']);
                $precio = trim($_POST['precio']);
                $cantidad = (int)trim($_POST['cantidad']);

                // Verifica que la cantidad sea válida (entre 1 y 10)
                if ($cantidad > 0 && $cantidad <= 10) {
                    // Verifica si el carrito ya existe en la sesión
                    if (!isset($_SESSION['carrito'])) {
                        $_SESSION['carrito'] = array();
                    }

                    // Agrega el producto al carrito en la sesión
                    $_SESSION['carrito'][$id_producto] = array(
                        'nombre' => $_POST['nombre'],
                        'precio' => $_POST['precio'],
                        'cantidad' => $cantidad
                    );
                    echo '<p>Producto agregado al carrito.</p>';
                } else {
                    echo '<p>La cantidad seleccionada no es válida.</p>';
                }

                // Realiza el pedido al hacer clic en "Comprar"
            } elseif (isset($_POST['comprar'])) {
                // Obtener la fecha actual
                $fechaCompra = date('Y-m-d H:i:s');
                // Insertar el pedido utilizando la clase "Pedido"
                foreach ($_SESSION['carrito'] as $id_producto => $producto) {
                    $cantidad_producto = $producto['cantidad'];
                    $id_cliente = $_SESSION['id_cliente'];
                    $pedido = new Pedido("", $fechaCompra, $id_cliente, $id_producto, $cantidad_producto);
                    $pedido->insert();
                }

                // Limpiar el carrito después de realizar la compra
                $_SESSION['carrito'] = [];
                echo '<p>Compra realizada con éxito.</p>';
                echo '<a href="pedidos.php">Ver la factura de mi pedido</a>';
                echo '<br>';

                // Procesar la eliminación de un producto
            } elseif (isset($_POST['eliminar_producto'])) {
                $id_productoEliminar = $_POST['eliminar_producto'];
                unset($_SESSION['carrito'][$id_productoEliminar]);
                echo '<p>Producto eliminado del carrito.</p>';

                // Vaciado del carrito
            } elseif (isset($_POST['vaciar'])) {
                unset($_SESSION['carrito']);
                echo '<p>El carrito ha sido vaciado.</p>';
            }
        }

        // Muestra productos en el carrito y calcula el total
        if (!empty($_SESSION['carrito'])) {
            $total = 0;
            foreach ($_SESSION['carrito'] as $id_producto => $producto) {
                echo '<p class="titulo_c">Nombre:' . $producto['nombre'] . '</p>';
                echo '<p class="titulo_c">Precio: ' . $producto['precio'] . '$.c/u</p>';

                // Calcular el total de la compra
                $precio_total_producto = $producto['precio'] * $producto['cantidad'];
                $total += $precio_total_producto;

                // Muestra la cantidad del producto y el precio total
                echo '<p class="titulo_c">' . 'Cantidad: ' . $producto['cantidad'] . ' = Precio: $' . $precio_total_producto . '</p>';
                echo '<br>';

                // Agrega un enlace para eliminar productos del carrito
                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<input type="hidden" name="eliminar_producto" value="' . $id_producto . '">';
                echo '<input type="submit" name="eliminar" value="Eliminar" class="formulario_submit_eliminar">';
                echo '</form>';
                echo '<br>';
            }

            // Muestra el total de la compra
            echo '<p class="titulo_c">Precio Total: $' . $total . '</p>';
            echo '<br>';

            // Formulario para comprar los productos
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            echo '<input type="submit" name="comprar" value="comprar" class="formulario_submit">';
            echo '</form>';

            echo '<br>';

            // Formulario para vaciar el carrito
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            echo '<input type="submit" name="vaciar" value="vaciar" class="formulario_submit">';
            echo '</form>';
        } else {
            echo '<p>No hay productos en el carrito.</p>';
        }

        echo '<br>';

        // Enlace para volver a home
        echo '<a href="home.php">Seguir Comprando</a>';
        ?>
    </div>

</div>
</body>
</html>
