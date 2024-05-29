<?php
session_start();
include '../components/configuracion.php';
include_once '../include/zeus_tfg.php';
include_once '../classes/administrador.php';

$idAdmin = $_SESSION['id_administrador'];

if (isset($idAdmin)) {
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cambiar_contrasenia_admin"])) {
    $contrasenia = trim($_POST["contrasenia"]);
    $confirmar_contrasenia = trim($_POST["confirmar_contrasenia"]);

    if ($contrasenia !== $confirmar_contrasenia) {
      $mensajeCambio = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    }

    $admin = new Administrador(null, null, null);
    try {
      $contrasenia_nueva = password_hash($contrasenia, PASSWORD_BCRYPT);
      $admin->cambiarContrasenia($idAdmin, $contrasenia_nueva);
      $mensajeCambio = "La contraseña se ha actualizado correctamente.";
    } catch (Exception $e) {
      error_log("Error en la base de datos: " . $e->getMessage());
      $mensajeCambio = "Error en el cambio de contraseña, por favor, revisa los logs.";
    }
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
    <p>Cambiar contraseña de administración</p>
  </div>

  <div class="contenedor-central-login">
    <div class="contenedor-login">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" oninput='up2.setCustomValidity(up2.value != up.value ? "Passwords do not match." : "")' class="container">
        <div class="form-group">
          <label for="password1">Contraseña</label>
          <input id="password1" type="password" placeholder="**********" required name="contrasenia" class="form-control">
        </div>
        <div class="form-group">
          <label for="password2">Confirmar contraseña</label>
          <input id="password2" type="password" placeholder="**********" required name="confirmar_contrasenia" class="form-control">
        </div>
        <input type="submit" name="cambiar_contrasenia_admin" value="Cambiar Contraseña" class="formulario_submit">
      </form>
      <?php
      if (isset($mensajeCambio)) {
        echo "<p>$mensajeCambio</p>";
      }
      ?>
    </div>
  </div>

  <!-- Footer -->
  <?php include '../components/footer.php'; ?>
</body>

</html>