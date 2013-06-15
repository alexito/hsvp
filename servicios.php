<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'admin') {
  header("location: logout.php");
  exit();
}
?><?php
if (isset($_POST["d"])) {
  $d = $_POST['d'];
  $o = $_POST['o'];
  $r = $_POST['r'];

  if ($d == "" || $o == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tservicios SET 
             ser_descrip = '$d',
             ser_observ = '$o'
             WHERE ser_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
    $sql = "UPDATE trefservicios SET 
             ref_codigo = '$r'             
             WHERE ser_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
  } else { //This is to INSERT
    $sql = "INSERT INTO tservicios (ser_descrip, ser_observ) VALUES('$d','$o')";
    $query = mysqli_query($db_conx, $sql);
    $uid = mysqli_insert_id($db_conx);
    $sql = "INSERT INTO trefservicios (ser_codigo, ref_codigo) VALUES($uid,$r)";
    $query = mysqli_query($db_conx, $sql);
  }

  SelectServicios($db_conx, 10, 1);

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
              <input type="hidden" name="cod_servicios" id="cod_servicios" value="" />
              <table><tr><td>
                    <label>Descripción: </label>
                    <input id="descripcion" type="text" maxlength="25">
                  </td>
                </tr>
                <div class="div-referenciado" style="float: right; margin-right: 560px;">
                <label>Referenciado:</label>
                    <div id="value_referenciado">                      
                      <?php SelectValuesReferenciado($db_conx, 'seguros'); ?>
                    </div>
                    <div id="reflinks">
                      <a id="refagregar" href="#">Agregar</a> - <a id="refeditar" href="#">Editar</a>
                    </div>
                <div id="frmref" style="display: none; margin-left: 190px; margin-top: -180px; position: absolute; border: #4db3af dashed thin; padding: 5px;">
                      <h5>Referenciado:</h5>
                      <input type="hidden" name="cod_referenciado" id="cod_referenciado" value="" />
                      <label>Descripcion:</label>
                      <input id="ref_descrip" type="text" maxlength="25">
                      <label>Siglas:</label>
                      <input id="ref_siglas" type="text" maxlength="6">
                      <label>Observación:</label>
                      <textarea id="ref_observ" style="width: 93%;" cols="10" rows="2"></textarea><br>
                      <a id="refguardar" href="#">Guardar</a> - <a id="refcancelar" href="#">Cancelar</a>
                    </div>
                </div>
                <tr><td>
                  <label>Observación:</label>
                  <textarea class="ref-observ" style="width: 150px;" id="observacion" cols="10" rows="2"></textarea>
                  </td>
                </tr>
              </table>
              <span id="status"></span>
              <br>                            
              <a class="nuevo" id="nuevo_servicios" href="#">Nuevo</a>
              <button id="submitbtn" onclick="createServicios()">Guardar</button>               
            </form>
          </div>
        </div>
        <div class="cleaner"></div>
        <div class="col_w900">
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectServicios($db_conx, 10, 1); ?>
            </table>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>