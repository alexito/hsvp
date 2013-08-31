<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");
include_once("functions2.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'contrareferente') {
  header("location: logout.php");
  exit();
}
?>
<?php
if (isset($_POST['btn'])) {//Filtra los datos
  filtrarReferenciasHospital($db_conx, $_POST['op'], $_POST['btn'], $_POST['rxp'], $_POST['pa'], $_POST['est'], $_POST['nro'], $_POST['fd'], $_POST['fh']);
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
          <input type="hidden" id="load-page1" value="1" />
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
                  <select style="width: 207px;" id="cmbestadotipo">
                    <option value="pendiente">Pendiente</option>
                    <option value="confirmado">Confirmado</option>
                    <option value="atendido">Atendido</option>
                    <option value="contrareferencia">Contrareferencia</option>                  
                  </select>                  
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
                <a class="a-button" href="javascript:filtrarDatos('referencias', 'car');">Actualizar</a>
                <a id="print-url" class="a-button" href="http://localhost/HSVP/reports/report-page.php?" target="_blank">Ver Reporte</a>
              </td>              
            </tr>
          </table>          
          <div id="table_content" class="tablestyle">            
            <table id="table_data">

              <?php
              SelectReferenciasHospital($db_conx);
              ?>

            </table>
          </div>
          <table class="tr-data">
            <tr style="height: 120px;">
              <td style="width: 350px;">
                <span style="margin-left: 100px; width: 300px;">Resultados por página: </span>
                <select id="rxp">
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                  <option value="500">500</option>
                </select>
              </td>
              <td>
                <a href="javascript:filtrarDatos('referencias', 'ant');">Anterior</a>
                <input disabled="Disabled" style="margin-left: 10px; margin-right: 10px; text-align: center; width: 50px;" type="text" id="pa" value="1"/>
                <a href="javascript:filtrarDatos('referencias', 'sig');">Siguiente</a>
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