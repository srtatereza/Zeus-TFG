<?php
session_start();
include 'components/configuracion.php';
include_once 'include/zeus_tfg.php';
include_once 'classes/administrador.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <!-- Enlace al archivo CSS externo -->
    <?php include 'components/enlace.php'; ?>
</head>

<body>
    <div class="publicidad">
        <p>Bienvenido, Administrador</p>
    </div>


    <div class="contenedor-central-login">
        <?php
        if (isset($_SESSION['id_administrador'])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cambiar_contrasenia_admin"])) {
                $contrasenia = trim($_POST["contrasenia"]);
                $confirmar_contrasenia = trim($_POST["confirmar_contrasenia"]);

                if ($contrasenia !== $confirmar_contrasenia) {
                    $mensajeCambio = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
                }

                $admin = new Administrador(null, null, null);
                try {
                    $contrasenia_nueva = password_hash($contrasenia, PASSWORD_BCRYPT);
                    $admin->cambiarContrasenia($_SESSION['id_administrador'], $contrasenia_nueva);
                    $mensajeCambio = "La contraseña se ha actualizado correctamente.";
                } catch (Exception $e) {
                    error_log("Error en la base de datos: " . $e->getMessage());
                    $mensajeCambio = "Error en el cambio de contraseña, por favor, revisa los logs.";
                }
            }
        ?>
            <h1>Cambiar contraseña de administrador</h2>
                <div class="contenedor-login">

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" oninput='up2.setCustomValidity(up2.value != up.value ? "Passwords do not match." : "")' class="container">
                        <div class="form-group">
                            <label for="password1">Contraseña:</label>
                            <input id="password1" type="password" required name="contrasenia" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password2">Confirmar contraseña:</label>
                            <input id="password2" type="password" name="confirmar_contrasenia" class="form-control">
                        </div>
                        <input type="submit" name="cambiar_contrasenia_admin" value="Cambiar Contraseña" class="formulario_submit">
                    </form>
                    <?php
                    if (isset($mensajeCambio)) {
                        echo "<p>$mensajeCambio</p>";
                        // Agregar enlace a pedidos-tienda.php
                        echo '<a href="pedidos-tienda.php">Continuar</a>';
                    }
                    ?>
                </div>
                <!-- Enlace para cerrar la sesión-->
                <a href="logout.php">Cerrar sesión</a>

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
                <div class="contenedor-login">
                    <!-- Formulario de inicio de sesión -->
                    <h2>Iniciar sesión</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="formulario">
                        <div class="form-group">
                            <label for="usuario">Usuario:</label>
                            <input type="text" name="usuario" id="usuario" placeholder="Usuario" required autocomplete="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="contrasenia">Contraseña:</label>
                            <input type="password" name="contrasenia" id="contrasenia" placeholder="Contraseña" required autocomplete="current-password" class="form-control">
                        </div>
                        <input type="submit" name="login_admin" value="Iniciar sesión" class="formulario_submit">
                    </form>
                </div>

            <?php
        }
            ?>
    </div>
    <!-- Footer -->
    <?php include 'components/footer.php'; ?>
</body>

</html>