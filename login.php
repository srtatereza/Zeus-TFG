<?php
session_start();
include_once 'include/zeus_tfg.php';
include_once 'components/configuracion.php';
include_once 'classes/cliente.php';

// Verificar si se ha iniciado sesión, sino redirigir a la home de la tienda (porque ya hay una sesión iniciada)
if (isset($_SESSION['id_cliente'])) {
    header("Location: /home.php");
}

// Verifica si se envió el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logarse"])) {
    $email = trim($_POST["email"]);
    $contrasenia = trim($_POST["contrasenia"]);

    // Crea una instancia de Cliente y realiza la consulta
    $cliente = new Cliente($email, $contrasenia, "", "", "", "", "");
    $clienteEncontrado = $cliente->select($email);

    // Verifica si se encontró el correo y si la contraseña coincide con la registrada.
    if ($clienteEncontrado && password_verify($contrasenia, $clienteEncontrado['contrasenia'])) {
        $_SESSION['email'] = $email;
        $_SESSION['id_cliente'] = $clienteEncontrado['id_cliente'];

        // Destruimos la sesión de administrador si la hay para evitar conflictos
        $_SESSION['id_administrador'] = null;

        // Redirigimos a la página de home
        header("Location: home.php");
        exit();
    } else {
        $mensajeError = "Email o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Enlace al archivo CSS externo -->
    <?php include 'components/enlace.php'; ?>
</head>
<!-- menu -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #EBEDEF;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img id="logo-img" src="img/logo-oficial.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-center margin-ritgh:10px">
            <span class="navbar-brand" style="font-size: 3rem; margin-right: 20px; margin-left: 20px;">ZEUS</span>
            <a class="navbar-brand" style="font-size: 3rem;" href="index.php">Inicio</a>
    </div>
</nav>

<body>
    <div class="contenedor-central-login">
        <!-- Enlace para registrarse -->
        <p>¿No estás registrado?<br><a href='registro.php'>Ir a Registrarse</a></p>

        <?php
        // Mostrar un Mensaje en caso de Error.
        if (isset($mensajeError)) {
            echo "<p>$mensajeError</p>";
        }
        ?>
        <div class="contenedor-login">
            <!-- Formulario de inicio de sesión -->
            <h2>Iniciar sesión</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="formulario">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="email@ejemplo.com" required autocomplete="username">
                <br>

                <label for="contrasenia">Contraseña</label>
                <input type="password" name="contrasenia" placeholder="**********" required autocomplete="current-password">

                <br>
                <input type="submit" name="logarse" value="Iniciar sesión" class="formulario_submit">
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

</body>

</html>