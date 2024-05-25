<?php
session_start(); // Iniciar la sesión si no está iniciada
$usuario_iniciado = isset($_SESSION['email']); // Verificar si el usuario ha iniciado sesión
?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #EBEDEF;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img id="logo-img" src="img/logo-oficial.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-top">
        </a>
        <span class="navbar-brand" style="font-size: 3rem; ">ZEUS</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarNav" class="collapse navbar-collapse justify-content-center" style="font-size: 2.5rem;">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Home">Características</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Precios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
            </ul>
            <ul class="navbar-nav mr-auto">
                <?php
                if ($usuario_iniciado) {
                    // Si el usuario ha iniciado sesión, mostrar el botón de "Cerrar Sesión"
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>';
                    echo '</li>';
                } else {
                    // Si el usuario no ha iniciado sesión, mostrar el botón de "Iniciar Sesión" con el icono
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="login.php"><i class="fas fa-user"></i> Iniciar Sesión</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

