<?php
session_start();
include 'components/configuracion.php';
include_once 'include/zeus_tfg.php';
include_once 'classes/producto.php';
include_once 'classes/cliente.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda_Camisetas</title>
    <!-- Enlace al archivo CSS externo -->
    <?php include 'components/enlace.php'; ?>
</head>
<body>
    <!-- Menu -->
    <?php include 'components/menu.php'; ?>

    <div class="contenedor">
        <?php
        // Verifica si hay una sesión activa
        if (isset($_SESSION['email'])) {
            $correoUsuario = htmlspecialchars($_SESSION['email']);
        } else {
            // Si no hay sesión activa, redirige al usuario al inicio de sesión
            header("Location: login.php");
            exit();
        }
        ?>
      <!-- Carrusel -->
<?php include 'components/carrusel.php'; ?>

<div class="publicidad">
    <p>Alta calidad y estilo único. ¡Encuentra la tuya y destaca!</p>
  </div>

<div class="contenedor-central">
<!-- Productos -->
<div class="productos row">
    <?php
    try {
        $productos = Producto::select();
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                echo '<div class="col-6 col-md-4 col-lg-3 mb-4">';
                echo '<div class="card">';
                echo '<img src="' . $producto->getImagen() . '" class="card-img-top" alt="' . $producto->getNombre() . '">';
                echo '<div class="card-body">';
                echo '<h3 class="card-title">' . $producto->getNombre() . '</h3>';
                echo '<p class="card-text-precio">Precio: $' . $producto->getPrecio() . '</p>';
                
                // Formulario para agregar al carrito
                echo '<form action="carrito.php" method="post">';
                echo '<input type="hidden" name="id_producto" value="' . $producto->getIdProducto() . '">';
                echo '<input type="hidden" name="nombre" value="' . $producto->getNombre() . '">';
                echo '<input type="hidden" name="precio" value="' . $producto->getPrecio() . '">';
                echo '<input type="hidden" name="imagen" value="' . $producto->getImagen() . '">';
                
                // Campo para seleccionar la cantidad
                echo '<div class="form-group">';
                echo '<label for="cantidad_' . $producto->getIdProducto() . '" class="label_home">Cantidad:</label>';
                echo '<input type="number" id="cantidad_' . $producto->getIdProducto() . '" name="cantidad" class="form-control" style="font-size: 1.5rem;" min="1" max="10" value="1">';
                echo '</div>';
            
                // Campo para seleccionar la talla
                echo '<div class="form-group">';
                echo '<label for="talla_' . $producto->getIdProducto() . '" class="label_home">Talla:</label>';
                echo '<select id="talla_' . $producto->getIdProducto() . '" name="talla" class="form-control" " style="font-size: 1.5rem;">';
                foreach ($producto->getTallas() as $talla) {
                    echo '<option value="' . $talla->getIdTalla() . '">' . strtoupper($talla->getNumeroTalla()) . '</option>';
                }
                echo '</select>';
                echo '</div>';

                // Campo para seleccionar el color
                echo '<div class="form-group-color">';
                echo '<label class="label_home">Color:</label>';
                echo '<div class="color-options">';
                foreach ($producto->getColores() as $color) {
                    echo '<label class="color-option">';
                    echo '<input type="radio" name="color" value="' . $color->getIdColor() . '" style="display: none;">';
                    echo '<span class="color-circle" style="background-color:' . $color->getBackgroundColor() . ';"></span>';
                    echo '</label>';
                }
                echo '</div>';
                echo '</div>';
                
                // Botón para agregar al carrito
                echo '<button type="submit" name="agregar_al_carrito" class="btn btn-primary">Agregar al Carrito</button>';
                echo '</form>';
                
                echo '</div>'; // cierre de card-body
                echo '</div>'; // cierre de card
                echo '</div>'; // cierre de col
            }
        } else {
            echo '<div class="col-12"><p>No hay productos disponibles en este momento.</p></div>';
        }
    } catch (Exception $e) {
        echo '<div class="col-12"><p>Hubo un error al cargar los productos.</p></div>';
    }
    ?>
</div>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

</body>

</html>