<?php
include_once("php_includes/check_login_status.php");

// Make sure the _GET username is set, and sanitize it
if (isset($_GET["usu"])) {
  $u = preg_replace('#[^a-z0-9]#i', '', $_GET['usu']);
} else {
  header("location: http://www.google.com");
  exit();
}
// Select the member from the users table
$sql = "SELECT * FROM tusuario WHERE usu_usuario='$u' AND usu_activo='activo' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if ($numrows < 1) {
  echo "That user does not exist or is not yet activated, press back";
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include_once("php_includes/head.php"); ?>
  </head>
  <body>
    <div id="templatemo_wrapper">
      <?php include_once("php_includes/template_pageTop.php"); ?>
      <div id="templatemo_main">
        <div class="col_w900" >
          <p>Bienvenido <?php echo $log_username; ?></p>
          <h3>Panel de Inicio.</h3>
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <tr><td>Opción. </td><td>Descripción.</td></tr>
              <?php
              if ($user_ok == TRUE && $log_tipo == 'admin') {
                ?>

              <tr><td><a href="medico_referente.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Medico Referente</span></a> </td><td style="font-size: 14px;"> Ingrese o edite Médicos Referentes (Personal que atenderá en las Unidades Médicas).</td></tr>
                <tr><td><a href="medico_referenciado.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Medico Referenciado</span></a> </td><td style="font-size: 14px;"> Ingrese o edite Médicos Referenciados (Personal que atenderá en la Unidad Central u Hospital).</td></tr>       
                <tr><td><a href="servicios.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Servicio</span></a> </td><td style="font-size: 14px;"> Ingrese o edite los Servicios disponibles que ofrece en el Hospital.</td></tr>
                <tr><td><a href="medicoxservicio.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Medico - Servicio</span></a> </td><td style="font-size: 14px;"> Relacione un Médico -> Servicios / Servicio -> Medicos correspondientes.</td></tr>
                <tr><td><a href="localizacion.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Localizacion</span></a> </td><td style="font-size: 14px;"> Ingrese o edite Localizaciones que luego corresponderán a las Unidades.</td></tr>
                <tr><td><a href="unidad.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Unidad</span></a> </td><td style="font-size: 14px;"> Ingrese o edite las Unidades Médicas.</td></tr>
                <tr><td><a href="usuario.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Usuario</span></a> </td><td style="font-size: 14px;"> Ingrese o edite los Usuarios y sus Claves para el acceso al Sistema.</td></tr>

              <?php } ?>
              <?php
              if ($user_ok == TRUE && $log_tipo == 'referente') {
                ?>
                <tr><td><a href="tramite_uni.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Crear Referencia</span></a> </td><td style="font-size: 14px;">Crea una nueva Referencia/Trámite detallando información que será revisada en el Hospital.</td></tr>
                  <tr><td><a href="referencias_uni.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Ver Referencias</span></a> </td><td style="font-size: 14px;">Revise el estado de las Referencias/Trámites y/o edite su estado.</td></tr>
                  <tr><td><a href="paciente.php" target="_blanket"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Pacientes</span></a> </td><td style="font-size: 14px;">Ingrese o edite un Paciente con información detallada.</td></tr>
              <?php } ?>
              <?php
              if ($user_ok == TRUE && $log_tipo == 'contrareferente') {
                ?>
                  <tr><td><a href="referencias.php"><img style="height: 25px; float: left;padding: 5px;" src="images/option.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Ver Referencias</span></a> </td><td style="font-size: 14px;">Revise el estado de las Referencias/Trámites y/o edite su estado.</td></tr>
                <?php
              }
              if ($user_ok == TRUE) {
                ?>
                <tr><td><a href="logout.php"><img style="height: 25px; float: left;padding: 5px;" src="images/logout.png"/><span style="margin-top: 7px; float: left;font-size: 14px;">Salir</span></a> </td><td style="font-size: 14px;">Cierre su sesión.</td></tr>
              <?php } ?>
            </table>
          </div>
          <div class="cleaner"></div>
        </div> <!-- end of main -->
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>
