<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'admin') {
  header("location: logout.php");
  exit();
}
?><?php
if (isset($_POST["loc"])) {
  $loc = $_POST['loc'];
  $des = $_POST['des'];
  $act = $_POST['act'];
  $obs = $_POST['obs'];
  if ($loc == "" || $des == "" || $act == "" || $obs == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tunidad SET 
             loc_codigo = $loc,
             uni_descrip = '$des',
             uni_activo = '$act',
             uni_observ = '$obs' 
             WHERE uni_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
    $uid = mysqli_insert_id($db_conx);
    //echo "update_success";
    //exit();
  } else { //This is to INSERT
    $sql = "INSERT INTO tunidad (loc_codigo, uni_descrip, uni_observ, uni_activo) VALUES($loc,'$des','$obs','$act');";
    $query = mysqli_query($db_conx, $sql);
    $uid = mysqli_insert_id($db_conx);
    //echo "insert_success";
    //exit();
  }

  SelectUnidad($db_conx, 10, 1);

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
              <input type="hidden" name="cod_unidad" id="cod_unidad" value="" />
              <table><tr><td>
                    <div class="ui-widget">
                      <label>Localizacion: </label>
                      <?php SelectValuesLocalizacion($db_conx); ?>
                    </div>
                  </td><td>
                    <label>Descripcion:</label>
                    <input id="descripcion" type="text" maxlength="25">
                  </td>
                  <td>
                    <div class="ui-widget">
                      <label>Activo:</label>
                      <select class="activo" id="cmbactivo">
                        <option value="">Seleccione...</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                      </select>
                    </div>
                  </td>
                </tr>
              </table>

              <label>Observacion:</label>
              <textarea id="observacion" cols="20" rows="2"></textarea>
              <br>
              <div>
                <span id="status"></span>
                <br>                            
                <a class="nuevo" id="nueva_unidad" href="#">Nuevo</a>
                <button id="submitbtn" onclick="createUnidad()">Guardar</button>               
              </div>
            </form>
          </div>
        </div>
        <div class="cleaner"></div>
        <div class="col_w900">
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectUnidad($db_conx, 10, 1); ?>
            </table>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>