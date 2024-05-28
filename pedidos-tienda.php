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

// Verificar si se ha enviado el formulario de actualización del estado del pedido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_estado_pedido'])) {
    $id_pedido = $_POST['id_pedido'];
    $estado_pedido = $_POST['estado_pedido'];
    // Llamar al método para actualizar el estado del pedido
    Pedido::updateEstadoPedido($id_pedido, $estado_pedido);
    // Redirigir o mostrar mensaje de éxito
    header("Location: pedidos-tienda.php");
    exit();
}

// Obtener la lista de pedidos por id de cliente utilizando la función select de la clase Pedido
$pedidos = Pedido::selectAllPedidos();
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
    <!-- Menú -->
    <?php include 'components/menu.php'; ?>

    <div class="publicidad">
        <p>Alta calidad y estilo único.</p>
    </div>

    <div class="contenedor-central">
        <div class="row">
            <div class="col-12">
                <div class="pedidos">
                    <h2>Lista de Pedidos</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Pedido</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Color</th>
                                    <th>Talla</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido) : ?>
                                    <tr>
                                        <td><?php echo $pedido['id_pedido']; ?></td>
                                        <td><?php echo $pedido['fecha']; ?></td>
                                        <td><?php echo $pedido['nombre_cliente'] . " " . $pedido['apellido_cliente']; ?></td>
                                        <td><?php echo $pedido['nombre_producto']; ?></td>
                                        <td><?php echo $pedido['cantidad_producto']; ?></td>
                                        <td><?php echo $pedido['color']; ?></td>
                                        <td><?php echo $pedido['talla']; ?></td>
                                        <td>
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                                <select name="estado_pedido" class="form-control">
                                                    <option value="En preparación" <?php if ($pedido['estado_pedido'] == "En preparación") echo 'selected'; ?>>En preparación</option>
                                                    <option value="En Reparto" <?php if ($pedido['estado_pedido'] == "En Reparto") echo 'selected'; ?>>En Reparto</option>
                                                    <option value="Entregado" <?php if ($pedido['estado_pedido'] == "Entregado") echo 'selected'; ?>>Entregado</option>
                                                    <option value="Cancelado" <?php if ($pedido['estado_pedido'] == "Cancelado") echo 'selected'; ?>>Cancelado</option>
                                                </select>
                                                <button type="submit" name="actualizar_estado_pedido" class="btn btn-primary">Actualizar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>
</body>


</html>