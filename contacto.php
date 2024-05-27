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
    <title>Contacto</title>
    <!-- Enlace al archivo CSS externo -->
    <?php include 'components/enlace.php'; ?>
</head>

<body>
    <!-- Menu -->
    <?php include 'components/menu.php'; ?>

    <div class="publicidad">
        <p>Alta calidad y estilo único. ¡Encuentra la tuya y destaca!</p>
    </div>
 

    <div class="container-contacto">
        <!-- Descripción de la tienda -->
        <div class="row description-container">
            <div class="col-12 d-flex flex-column"> <!-- Usando flexbox para la descripción -->
                <h2>Sobre nuestra tienda</h2>
                <p class="contacto-p">Nuestra tienda, fundada en 2018, se dedica a ofrecer productos de la más alta calidad a nuestros clientes.
                    Contamos con la mejor maquinaria del mercado, lo que nos permite producir mercancía de calidad superior.
                    Nos enorgullecemos de nuestros diseños originales y ofrecemos la opción
                    de personalización para que cada cliente pueda obtener un producto único y a su medida.
                    Nuestro compromiso es garantizar la satisfacción total de nuestros clientes a través de productos excepcionales y
                    un servicio de atención al cliente de primera clase.</p>
                <!-- Imágenes de la tienda -->
                <div class="row images-container">
                    <div class="col-6 col-md-6 mb-3">
                        <img src="/img/tienda-uno.png" alt="Imagen 1" class="img-fluid">
                    </div>
                    <div class="col-6 col-md-6 mb-3">
                        <img src="/img/tienda-dos.jpg" alt="Imagen 2" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <!-- Información de contacto -->
        <div class="row contact-container">
            <div class="col-12 text-center"> <!-- Centrando el contenido -->
                <h2>Contactanos</h2>
                <p class="contacto-p">Correo electrónico: contacto@tiendazeus.com</p>
                <p class="contacto-p">Teléfono: +123 456 789</p>
                <p class="contacto-p"> Ubicación de nuestra fábrica: Calle Principal, Ciudad, País</p>
                <h3>Solo tenemos pedidos Online</h3>
                <img src="/img/ubicacion.png" alt="Fábrica" class="img-fluid mx-auto d-block"> <!-- Agregado mx-auto d-block para centrar la imagen -->
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

</body>

</html>