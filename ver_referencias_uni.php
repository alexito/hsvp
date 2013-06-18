<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'referente') {
  header("location: logout.php");
  exit();
}
?><?php
if (isset($_POST['tra'])) {//Obtiene el cod del Paciente relacionado a este tramite
  $sql = "SELECT pac_codigo FROM ttramite WHERE tra_codigo =". $_POST['cod'];
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  echo $row[0];
  exit();
}
if (!isset($_GET['cod_tramite'])) {//Carga los datos del autocompletado de pacientes
  header("location: referencias_uni.php");
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
        <div class="tramite-class" id="pageMiddle">
          <div id="genform_style">
            <form name="genform" id="genform" onsubmit="return false;">
              <input type="hidden" name="cod_tramite" id="cod_tramite" value="" />              
              
              <table><tr>
                  <td  style="width: 500px;"><h2>Referencia</h2></td>
                  <td><?php //echo date("d M y H:m", time()); ?></td>
                </tr></table><table><tr>
                  <td>
                    <label><h5>Unidad:</h5></label>
                    <span class="uni" id="par"></span>
                  </td>
                </tr><tr class="tr-data">
                  <td><label>Parroquia:</label><span class="data" id="par">parroquia</span></td>
                  <td><label>Cantón:</label><span class="data" id="can">canton</span></td>
                  <td><label>Provincia:</label><span class="data" id="pro">provincia</span></td>
                </tr></table><table>
                <tr>
                  <td>
                    <label><h5>Paciente:</h5></label>                    
                  </td>
                </tr></table><table class="custom-table">
                <tr style="margin-top: 20px;float: left;">
                  <td><label>Apellido P.:</label><span class="data" id="pape"></span></td>
                  <td><label>Apellido M.:</label><span class="data" id="sape"></span></td>
                  <td><label>Nombre:</label><span class="data" id="nom"></span></td>
                  <td><label>Cédula:</label><span class="data" id="ced"></span></td>
                </tr> 
                <tr style="float: left;">
                  <td><label>F. Nacimiento:</label><span class="data" id="fnac"></span></td>
                  <td><label>Historia C.:</label><span class="data" id="hc"></span></td>
                  <td><label>Género:</label><span class="data" id="gen"></span></td>
                  <td><label>Est. Civil:</label><span class="data" id="ec"></span></td>
                </tr> 
                <tr class="tr-data">
                  <td><label>Teléfono:</label><span class="data" id="tel"></span></td>
                  <td><label>Instrucción:</label><span class="data" id="ins"></span></td>
                  <td><label>Empresa:</label><span class="data" id="emp"></span></td>
                  <td><label>Seguro:</label><span class="data" id="seg"></span></td>                    
                </tr> 
              </table><table>
                <tr class="tr-data">
                  <td>
                    <label style="width: 150px;"><h5>Servicio requerido:</h5></label>                    
                    <span class="data" id="ser"></span>
                  </td>
                </tr>    
              </table>
              <table id="sie10" class="tr-data">
                <tr><td><label><h5>Diagnóstico:</h5></label></td></tr>
                <tr><td>
                    <ul>
                      <?php //CARGAR LOS DIAGNOSTICOS ?>
                    </ul>
                  </td></tr>
              </table>
              <table><tr>
                  <td>
                    <label style="width: 400px;"><h5>Motivo de Referencia:</h5></label>
                    <span id="motivo_ref"></span>
                  </td>
                </tr><tr>
                  <td>
                    <label style="width: 400px;"><h5>Resumen del Cuadro Clínico:</h5></label>
                    <span id="resumen_ref"></span>
                  </td>
                </tr><tr>
                  <td>
                    <label style="width: 400px;"><h5>Hallazgos relevantes de examenes y procedimientos diagnósticos:</h5></label>
                    <span id="hallazgo_ref"></span>
                  </td>
                </tr><tr class="tr-data">
                  <td>
                    <label style="width: 400px;"><h5>Plan tratamiento realizado:</h5></label>
                    <span id="plan_ref"></span>
                  </td>
                </tr></table>
              <table><tr style="float: left; margin-left: 150px;"><td>
                    <a style="margin-top: 10px;" class="nuevo" href="tramite_uni.php">Nuevo</a></td><td>
                    <a class="a-button" id="saveTramiteUnidad" onclick="">Guardar...</a> </td><td>
                    <span id="status"></span></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>