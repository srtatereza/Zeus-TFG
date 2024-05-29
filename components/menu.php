<?php
session_start(); // Iniciar la sesión si no está iniciada
$usuario_iniciado = isset($_SESSION['email']); // Verificar si el usuario ha iniciado sesión
$admin_iniciado = isset($_SESSION['id_administrador']); // Verificar si el admin ha iniciado sesión

// Obtener el nombre del archivo actual
$pagina_actual = basename($_SERVER['PHP_SELF']);

?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #EBEDEF;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img id="logo-img" src="/img/logo-oficial.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
        </a>
        <span class="navbar-brand" style="font-size: 3rem; ">ZEUS</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarNav" class="collapse navbar-collapse justify-content-center" style="font-size: 2.5rem;">
            <ul class="navbar-nav">
                <?php if ($usuario_iniciado) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/carrito.php">Carrito</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/pedidos.php">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contacto.php">Contacto</a>
                    </li>
                <?php elseif ($admin_iniciado) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/pedidos-tienda.php">Gestionar pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/cambio.php">Cambiar contraseña</a>
                    </li>
                <?php else : ?>
                    <?php if ($pagina_actual === 'index.php') : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav mr-auto">
                <?php if ($usuario_iniciado || $admin_iniciado) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php"><i class="fas fa-user"></i> Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
