<?php
session_start();
include 'components/configuracion.php';
include_once 'include/zeus_tfg.php';
include_once 'classes/cliente.php';

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
    <title>Tienda_Camisetas</title>
    <!-- Enlace al archivo CSS externo -->
    <?php include 'components/enlace.php'; ?>
</head>

<body>
<div class="contenedor">
    <?php
    // Mostrar un Mensaje en caso de Error.
    if (isset($mensajeError)) {
        echo "<p>$mensajeError</p>";
    }
    ?>

    <!-- Enlace para registrarse -->
    <p>¿No estás registrado?<br><a href='registro.php'>Ir a Registrarse</a></p>

    <!-- Formulario de inicio de sesión -->
    <h2>Iniciar sesión</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="formulario">
        <label for="email">email:</label>
        <input type="email" name="email" id="email" placeholder="Correo electrónico" required autocomplete="username">
        <br>

        <label for="contrasenia">contraseña:</label>
        <input type="password" name="contrasenia" id="contrasenia" placeholder="contraseña" required
               autocomplete="current-password">

        <br>
        <input type="submit" name="logarse" value="Iniciar sesión" class="formulario_submit">
    </form>

</div>

</body>

</html>
