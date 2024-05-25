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

    <?php
    session_start();
    include 'components/configuracion.php';
    include_once 'include/zeus_tfg.php';
    include_once 'classes/administrador.php';

    if (isset($_SESSION['id_administrador'])) {
    ?>
        <h1>Bienvenido a tu panel de administración, <?php echo $_SESSION['administrador']; ?></h1>







        
        <!-- Enlace para cerrar la sesión-->
        <a href="cerrar.php">Cerrar sesión</a>

    <?php
    } else {
        // Verifica si se envió el formulario de inicio de sesión
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_admin"])) {
            $usuario = trim($_POST["usuario"]);
            $contrasenia = trim($_POST["contrasenia"]);

            // Crea una instancia de Administrador y realiza la consulta
            $admin = new Administrador(null, $usuario, $contrasenia);

            try {
                $adminEncontrado = $admin->select($usuario);

                // Verifica si se encontró el correo y si la contraseña coincide con la registrada.
                if ($adminEncontrado && password_verify($contrasenia, $adminEncontrado['contrasenia'])) {
                    $_SESSION['id_administrador'] = $adminEncontrado['id_administrador'];
                    $_SESSION['administrador'] = $adminEncontrado['usuario'];
                    header("Location: admin.php");
                } else {
                    $mensajeError = "Usuario o contraseña incorrectos.";
                }
            } catch (Exception $e) {
                error_log("Error en la base de datos: " . $e->getMessage());
                $mensajeError = "Error en el login, por favor, revisa los logs.";
            }
        }
        ?>
        <div class="contenedor">
            <?php
            // Mostrar un Mensaje en caso de Error.
            if (isset($mensajeError)) {
                echo "<p>$mensajeError</p>";
            }
            ?>

            <!-- Formulario de inicio de sesión -->
            <h2>Iniciar sesión</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="formulario">
                <label for="usuario">Usuario:</label>
                <input type="username" name="usuario" id="usuario" placeholder="Usuario" required autocomplete="username">
                <br>

                <label for="contrasenia">Contraseña:</label>
                <input type="password" name="contrasenia" id="contrasenia" placeholder="contraseña" required autocomplete="current-password">

                <br>
                <input type="submit" name="login_admin" value="Iniciar sesión" class="formulario_submit">
            </form>

        </div>
    <?php
    }
    ?>
        
</body>

</html>