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
  <title>zeus</title>
  <!-- Enlace al archivo CSS externo -->
  <?php include 'components/enlace.php'; ?>
</head>


<body>

  <?php include 'components/menu.php'; ?>

  <script>
    $('.carousel').carousel({
      interval: 2000
    })
  </script>

  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img/carrusel-dos.png" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>First slide label</h5>
          <p>Some representative placeholder content for the first slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="img/carrusel-uno.png" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Second slide label</h5>
          <p>Some representative placeholder content for the second slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="img/carrusel-tres.png" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Third slide label</h5>
          <p>Some representative placeholder content for the third slide.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <div class="contenedor">

    <div class="productos">
      <?php
      $productos = Producto::select();
      if (!empty($productos)) {
        foreach ($productos as $producto) {
          echo '<div>';
          echo '<h3 class="titulo">' . $producto->getNombre() . '</h3>';
          echo '<p class="titulo">Precio: $' . $producto->getPrecio() . '</p>';
          echo '<img src="' . $producto->getImagen() . '" alt="' . $producto->getNombre() . '">';
        }
      } else {
        echo 'No hay productos disponibles en este momento.';
      }
      echo '</div>';
      ?>
    </div>
  </div>
</body>

</html>