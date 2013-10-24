<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");
include_once("functions2.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'admin') {
  header("location: inicio.php");
  exit();
}
?><?php
if (isset($_POST['btn'])) {//Filtra los datos
  filtrarMedicoReferenciado($db_conx, $_POST['op'], $_POST['btn'], $_POST['rxp'], $_POST['pa'], $_POST['ord'], $_POST['est'], $_POST['tex']);
  exit();
}

if (isset($_POST["codmed"])) {
  $codmed = $_POST['codmed'];
  $esp = $_POST['esp'];
  $obs = $_POST['obs'];
  $est = $_POST['est'];
  $pnom = $_POST['pnom'];
  $snom = $_POST['snom'];
  $pape = $_POST['pape'];
  $sape = $_POST['sape'];
  if ($esp == "" || $est == "" || $pnom == "" || $snom == "" || $pape == "" || $sape == "") {
    echo "Algunos valores del formulario con invalidos.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tmedicoreferenciado SET 
             mer_codmed = '$codmed',
             mer_especial = '$esp',
             mer_observ = '$obs',
             mer_estado = '$est',
             mer_pnom = '$pnom',
             mer_snom = '$snom',
             mer_pape = '$pape',
             mer_sape = '$sape' 
             WHERE mer_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
  } else { //This is to INSERT
    $sql = "INSERT INTO tmedicoreferenciado (mer_codmed, mer_especial, mer_observ,
      mer_estado, mer_pnom, mer_snom, mer_pape, mer_sape) VALUES('$codmed','$esp','$obs','$est', '$pnom', '$snom', '$pape', '$sape');";
    $query = mysqli_query($db_conx, $sql);
    $uid = mysqli_insert_id($db_conx);
  }

  SelectMedicoReferenciado($db_conx, 10, 1);

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
        <div id="pageMiddle">
          <div id="genform_style">
            <form name="genform" id="genform" onsubmit="return false;">
              <input type="hidden" name="cod_medicoreferenciado" id="cod_medicoreferenciado" value="" />

              <table><tr><td>                    
                    <label>P. Nombre: </label>
                    <input id="pnom" type="text" maxlength="25" onKeyPress="return onlyText(event);">                    
                  </td><td>
                    <label>S. Nombre:</label>
                    <input id="snom" type="text" maxlength="25" onKeyPress="return onlyText(event);">
                  </td></tr>
                <tr><td>
                    <label>P. Apellido:</label>
                    <input id="pape" type="text" maxlength="25" onKeyPress="return onlyText(event);">
                  </td><td>
                    <label>S. Apellido:</label>
                    <input id="sape" type="text" maxlength="25" onKeyPress="return onlyText(event);">
                  </td><tr><td>                    
                    <label>Cod. Medico: </label>
                    <input id="codmed" type="text" maxlength="15">                    
                  </td><td>
                    <label>Especialidad:</label>
                    <input id="especialidad" type="text" maxlength="15" onKeyPress="return onlyText(event);">
                  </td><td>
                    <label>Estado:</label>
                    <select class="estado" id="cmbestado">
                      <option value="">Seleccione...</option>
                      <option value="activo">Activo</option>
                      <option value="inactivo">Inactivo</option>
                    </select>
                  </td></tr>
                </tr>
              </table>
              <label>Observacion:</label>
              <textarea id="observacion-med-ref" cols="20" rows="2"></textarea>
              <br>

              <div>
                <span id="status"></span>
                <br>                            
                <a class="nuevo" id="nuevo_medicoreferenciado" href="#">Nuevo</a>
                <button id="submitbtn" onclick="createMedicoReferenciado()">Guardar</button>               
              </div>
            </form>
          </div>
        </div>
        <div class="cleaner"></div>
        <div class="col_w900">
          <table class="tr-data">
            <tr>
              <td style="width: 250px;">
                <label>Filtrar por:</label>
                <select style="width: 200px;" id="cmbopcion" onchange="changeOptionFilterMedRef();">
                  <option value="op1">Código</option>              
                  <option value="op2">Nombre</option>
                  <option value="op3">Especialidad</option>
                  <option value="op4">Especificar</option>
                </select>
              </td>
              <td style="width: 250px;">
                <span id="top1" class="opt-common">
                  <label>Ordenar:</label>
                  <select style="width: 207px;" id="cmborden">
                    <option value="ASC">Ascendente</option>
                    <option value="DESC">Descendente</option>
                  </select>
                </span>
                <span id="top2" class="opt-common">
                  <label>Estado:</label>
                  <select style="width: 207px;" id="cmbact">
                    <option value="op0">Ambos</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                  </select>                  
                </span>
                <span id="top4" class="hide opt-common">
                  <label style="width: 200px;">Buscar: </label>
                  <input style="width: 200px;" type="text" id="texto"/>
                </span>
              </td>              
              <td>
                <a class="a-button" href="javascript:filtrarDatos('med-referenciado', 'car');">Actualizar</a>
                <a id="print-url" class="a-button" href="http://localhost/HSVP/reports/report-page.php?page=medico-referenciado&btn=car&rxp=5&pa=1&op=op1&ord=ASC&est=op0&tex=" target="_blank">Ver Reporte</a>
              </td>              
            </tr>
          </table>
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectMedicoReferenciado($db_conx); ?>
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
                <a href="javascript:filtrarDatos('med-referenciado', 'ant');">Anterior</a>
                <input disabled="Disabled" style="margin-left: 10px; margin-right: 10px; text-align: center; width: 50px;" type="text" id="pa" value="1"/>
                <a href="javascript:filtrarDatos('med-referenciado', 'sig');">Siguiente</a>
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