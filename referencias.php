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
              <td style="width: 250px;">
                <label>Filtrar por:</label>
                <select id="cmbopcion" onchange="changeOptionFilter();">
                  <option value="op1">Estado del Trámite</option>
                  <option value="op2">Numero de Trámite / Cédula</option>
                  <option value="op3">Fecha</option>
                </select>
              </td>
              <td style="width: 250px;">
                <span id="top1" class="opt-common">
                  <label>Ver Trámite:</label>
                  <select id="cmbestadotipo">
                    <option value="pendiente">Pendiente</option>
                    <option value="confirmado">Confirmado</option>
                    <option value="atendido">Atendido</option>
                    <option value="contrareferencia">Contrareferencia</option>                  
                  </select>
                  <?php if (isset($_GET['est'])) {//PERMITE DEJAR SELECCIONADA LA OPCION LUEGO DE REFRESCAR LA PAGINA. ?>
                    <script>
                      $('#cmbestadotipo').val('<?php echo $_GET['est']; ?>');
                    </script>
                  <?php } ?>
                </span>
                <span id="top2" class="hide opt-common">
                  <label style="width: 200px;">Nro. Trámite o Cédula: </label>
                  <input style="width: 200px;" type="text" id="nro-tra-ced"/>
                </span>
                <span id="top3" class="hide opt-common">
                  <label>Fecha desde: </label>
                  <input style="width: 200px;" type="text" id="fecha-desde"/>
                  <label>Fecha hasta: </label>
                  <input style="width: 200px;" type="text" id="fecha-hasta"/>
                </span>
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
          <table class="tr-data">
            <tr style="height: 120px;">
              <td style="width: 350px;">
                <span style="margin-left: 100px; width: 300px;">Resultados por página: </span>
                <input style="width: 50px;" type="text" id="rxp" value="20"/><br/>
              </td>
              <td>
                <a href="#">Anterior</a>
                <input style="margin-left: 10px; margin-right: 10px; text-align: center; width: 50px;" type="text" id="pa" value="1"/><a>Siguiente</a>
              </td>
            </tr>
          </table>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>