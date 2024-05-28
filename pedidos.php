<?php
session_start();
include 'components/configuracion.php';
include_once 'classes/producto.php';
include_once 'classes/cliente.php';
include_once 'classes/pedido.php';
include_once 'include/zeus_tfg.php';

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
    <title>Pedidos</title>
    <!-- Enlace al archivo CSS externo -->
    <?php include 'components/enlace.php'; ?>
</head>

<body>

    <!-- Menu -->
    <?php include 'components/menu.php'; ?>
    <div class="publicidad">
        <p>Alta calidad y estilo único.</p>
    </div>

    <div class="contenedor-central">
        <div class="row">
        </div>

        <div class="col-12 col-md-8 mx-auto">
            <div class="pedidos">
                <h2>Mis pedidos</h2>

                <!-- Tabla de pedidos -->
                <!-- Verificar si hay pedidos para mostrarlos -->
                <?php if (!empty($pedidos)) { ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="table-th">Fecha del Pedido</th>
                                    <th class="table-th">Producto</th>
                                    <th class="table-th">Color</th>
                                    <th class="table-th">Talla</th>
                                    <th class="table-th">Cantidad</th>
                                    <th class="table-th">Estado</th>
                                    <!-- <th>Historial</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Recorrer la lista de pedidos y mostrarlos en la tabla -->
                                <?php foreach ($pedidos as $pedido) : ?>
                                    <tr>
                                        <td class="table-td"><?php echo $pedido['fecha']; ?></td>
                                        <td class="table-td"><?php echo $pedido['nombre']; ?></td>
                                        <td class="table-td"><?php echo $pedido['color']; ?></td>
                                        <td class="table-td"><?php echo $pedido['talla']; ?></td>
                                        <td class="table-td"><?php echo $pedido['cantidad_producto']; ?></td>
                                        <td class="table-td"><?php echo $pedido['estado']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- No hay pedidos para mostrar -->
                <?php } else { ?>
                    <p class="mensaje-producto">No hay pedidos para mostrar.</p>
                <?php } ?>

                <div class="row">
                    <div class="col-12 col-md-8 mx-auto">
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

        </div>
    </div>
    <!-- Footer -->
    <?php include 'components/footer.php'; ?>


</body>




</html>