<?PHP
session_start();
include_once 'include/camisetasDB.php';
include_once 'classes/cliente.php';

// Comprueba si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrarse"])) {
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $direccion = trim($_POST["direccion"]);
    $telefono = trim($_POST["telefono"]);
    $email = trim($_POST["email"]);
    $contraseniaRegistro = trim($_POST["contrasenia_registro"]);
    $contraseniaConfirmacion = trim($_POST["confirmar_contrasenia"]);

    // Comprueba si las contraseñas coinciden
    if ($contraseniaRegistro !== $contraseniaConfirmacion) {
        $mensajeRegistro = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } else {
        // Inserta un cliente utilizando la función insert de la clase cliente
        $almacenarPassword = password_hash($contraseniaRegistro, PASSWORD_BCRYPT);
        $cliente = new Cliente("", $nombre, $apellido, $direccion, $telefono, $email, $almacenarPassword);
        $cliente->insert();
        // Mensaje de depuración
        $mensajeRegistro = "Usuario registrado con éxito.";
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
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>

<div class="contenedor">
    <?php
    // Mostrar un mensaje de Registro o un Mensaje en caso de Error.
    if (isset($mensajeRegistro)) {
        echo "<p>$mensajeRegistro</p>";
    }
    ?>

    <!-- Enlace para iniciar sesión -->
    <p>¿Estás registrado? <br> <a href='login.php'> Inicia sesión</a></p>

    <!-- Formulario de Registro -->
    <h2>Registrarse</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="formulario">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
        <br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>
        <br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" placeholder="Dirección" required>
        <br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Teléfono" required>
        <br>

        <label for="email">EMAIL:</label>
        <input type="email" name="email" id="email" placeholder="Correo electrónico" autocomplete="username" required>
        <br>

        <label for="contrasenia_registro">Nueva Contraseña:</label>
        <input type="password" name="contrasenia_registro" id="contrasenia_registro" placeholder="Contraseña" required
               autocomplete="new-password">
        <br>

        <label for="confirmar_contrasenia">Repetir Contraseña:</label>
        <input type="password" name="confirmar_contrasenia" id="confirmar_contrasenia"
               placeholder="Confirmar Contraseña" required autocomplete="new-password">
        <br>

        <input type="submit" name="registrarse" value="Registrarse" class="formulario_submit">
    </form>

</div>

</body>
</html>
