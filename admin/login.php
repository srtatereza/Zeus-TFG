<?php
session_start();
include '../components/configuracion.php';
include_once '../include/zeus_tfg.php';
include_once '../classes/administrador.php';

$idAdmin = $_SESSION['id_administrador'];

if ($idAdmin) {
  header("Location: /admin/pedidos-tienda.php");
}

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
      header("Location: pedidos-tienda.php");
    } else {
      $mensajeError = "Usuario o contraseña incorrectos.";
    }
  } catch (Exception $e) {
    error_log("Error en la base de datos: " . $e->getMessage());
    $mensajeError = "Error en el login, por favor, revisa los logs.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrador</title>
  <!-- Enlace al archivo CSS externo -->
  <?php include '../components/enlace.php'; ?>
</head>

<body>
  <!-- Menú -->
  <?php include '../components/menu.php'; ?>
  <div class="publicidad">
    <p>Login de administración</p>
  </div>

  <div class="contenedor-central-login">
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
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario" placeholder="administrador" required autocomplete="username">
        <br>

        <label for="contrasenia">Contraseña</label>
        <input type="password" name="contrasenia" id="contrasenia" placeholder="**********" required autocomplete="current-password">

        <br>
        <input type="submit" name="login_admin" value="Iniciar sesión" class="formulario_submit">
      </form>
    </div>
  </div>

  <!-- Footer -->
  <?php include '../components/footer.php'; ?>
</body>

</html>