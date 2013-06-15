<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'admin') {
  header("location: logout.php");
  exit();
}
?><?php
if (isset($_POST["codmed"])) {
  $codmed = $_POST['codmed'];
  $esp = $_POST['esp'];
  $obs = $_POST['obs'];
  $est = $_POST['est'];
  $pnom = $_POST['pnom'];
  $snom = $_POST['snom'];
  $pape = $_POST['pape'];
  $sape = $_POST['sape'];
  if ($codmed == "" || $esp == "" || $obs == "" || $est == "" || $pnom == "" || $snom == "" || $pape == "" || $sape == "") {
    echo "The form submission is missing values.";
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
                    <input id="pnom" type="text" maxlength="25">                    
                  </td><td>
                    <label>S. Nombre:</label>
                    <input id="snom" type="text" maxlength="25">
                  </td></tr>
                <tr><td>
                    <label>P. Apellido:</label>
                    <input id="pape" type="text" maxlength="25">
                  </td><td>
                    <label>S. Apellido:</label>
                    <input id="sape" type="text" maxlength="25">
                  </td><tr><td>                    
                    <label>Cod. Medico: </label>
                    <input id="codmed" type="text" maxlength="15">                    
                  </td><td>
                    <label>Especialidad:</label>
                    <input id="especialidad" type="text" maxlength="15">
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
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectMedicoReferenciado($db_conx, 10, 1); ?>
            </table>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>