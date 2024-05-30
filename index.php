<?php
session_start(); // Iniciar la sesión si no está iniciada
include_once 'include/zeus_tfg.php';
include_once 'components/configuracion.php';
include_once 'classes/producto.php';
include_once 'classes/cliente.php';

// Verificar si el usuario ha iniciado sesión
$usuario_iniciado = isset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZEUS</title>
  <!-- Enlace al archivo CSS externo -->
  <?php include 'components/enlace.php'; ?>
</head>

<body>
  <!-- Enlace al menu -->
  <?php include 'components/menu.php'; ?>

  <?php include 'components/carrusel.php'; ?>
  <div class="publicidad">
    <p>Alta calidad y estilo único. ¡Encuentra la tuya y destaca!</p>
  </div>
  <div class="contenedor-central-fondo">
    <div class="contenedor-central">
      <!-- Contenedor de productos -->
      <div class="productos row">
        <?php
        $productos = Producto::select();
        if (!empty($productos)) {
          foreach ($productos as $producto) {
            echo '<div class="col-6 col-md-4 col-lg-3 mb-4">'; // Css para el contenedor
            echo '<div class="card">';
            echo '<img src="' . $producto->getImagen() . '" class="card-img-top" alt="' . $producto->getNombre() . '">';
            echo '<div class="card-body">';
            echo '<h3 class="card-title">' . $producto->getNombre() . '</h3>';
            echo '<p class="card-text">Precio: $' . $producto->getPrecio() . '</p>';
            echo '<button type="button" class="btn btn-primary comprar-btn">Comprar</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo '<div class="col-12"><p>No hay productos disponibles en este momento.</p></div>';
        }
        ?>
      </div>

      <!-- Modal de inicio de sesión -->
      <div class="modal fade" id="sesionModal" tabindex="-1" role="dialog" aria-labelledby="sesionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <p>Para comprar, debes iniciar sesión.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
              <a href="login.php" class="btn btn-primary">Continuar</a>
            </div>
          </div>
        </div>
      </div>

      <script>
        $(document).ready(function() {
          // Cuando se hace clic en el botón "Comprar"
          $(".comprar-btn").click(function() {
            // Mostrar el modal de inicio de sesión
            $("#sesionModal").modal('show');
          });

          // Cuando se hace clic en el botón "No"
          $(".modal-footer .btn-secondary").click(function() {
            // Ocultar el modal de inicio de sesión
            $("#sesionModal").modal('hide');
          });
        });

        $('.carousel').carousel({
          interval: 1000
        });
      </script>

    </div>
  </div>

  <!-- Contenedor de enlace al login.php -->

  <div class="publicidad-dos">
    <a class="visitanos" href="login.php">Visita nuestra Web</a>
  </div>

  <!-- Footer -->
  <?php include 'components/footer.php'; ?>
  </div>
</body>

</html>