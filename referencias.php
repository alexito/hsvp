<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'contrareferente') {
  header("location: logout.php");
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
        <div class="col_w900">
          <table class="tr-data">
            <tr>
              <td>
                <label>Ver Trámite:</label>
                <select id="cmbestadotipo">
                  <option value="pendiente">Pendiente</option>
                  <option value="confirmado">Confirmado</option>
                  <option value="atendido">Atendido</option>
                  <option value="contrareferencia">Contrareferencia</option>
                </select>
              </td>
              <td>
                <a class="a-button" id="cargar-referencias" >Cargar...</a>
              </td>
            </tr>
          </table>
          <div id="table_content" class="tablestyle">            
            <table id="table_data">

              <?php
              if (isset($_GET['est'])) {
                SelectReferenciasHospitalPendiente($db_conx, $log_id, 10, 1, $_GET['est']);
              } else {
                SelectReferenciasHospitalPendiente($db_conx, $log_id, 10, 1);
              }
              ?>

            </table>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>