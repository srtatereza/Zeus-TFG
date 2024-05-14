<?php
session_start();

include_once 'classes/producto.php';
include_once 'classes/cliente.php';
include_once 'classes/pedido.php';
include_once 'include/camisetasDB.php';

$id_cliente = $_SESSION['id_cliente'];

// Verificar si se ha enviado el formulario de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_pedido'])) {
    // Eliminar el pedido por id de pedido y id de cliente, utilizando la función delete de la clase Pedido
    $idPedidoEliminar = trim($_POST['id_pedido']);
    Pedido::delete($idPedidoEliminar, $id_cliente);
}

// Obtener la lista de pedidos por id de cliente utilizando la función select de la clase Pedido
$pedidos = Pedido::select($id_cliente);
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
    <div class="carrito-producto">
        <h2>Pedidos del Cliente</h2>

        <!-- Tabla de pedidos -->
        <!-- Verificar si hay pedidos para mostrarlos -->
        <?php if (!empty($pedidos)) { ?>
            <table aria-describedby="tabla de pedidos">
                <tr>
                    <th>ID Pedido</th>
                    <th>Fecha del Pedido</th>
                    <th>Nombre del Producto</th>
                    <th>Cantidad</th>
                    <th>Historial</th>
                </tr>
                <!-- Recorrer la lista de pedidos y mostrarlos en la tabla -->
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo $pedido['id_pedido']; ?></td>
                        <td><?php echo $pedido['fecha']; ?></td>
                        <td><?php echo $pedido['nombre']; ?></td>
                        <td><?php echo $pedido['cantidad_producto']; ?></td>
                        <td>
                            <!-- Formulario para eliminar el pedido específico -->
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                <input type="submit" name="eliminar_pedido" value="Eliminar" class="formulario_submit">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <!-- No hay pedidos para mostrar -->
        <?php } else { ?>
            <p>No hay pedidos para mostrar.</p>
        <?php } ?>
    </div>

    <br>
    <!-- Enlace para el home-->
    <a href="home.php">Seguir Comprando</a>
    <br>
    <br>

    <!-- Enlace para cerrar la sesión-->
    <a href="cerrar.php">Cerrar sesión</a>

</div>

</body>

</html>
