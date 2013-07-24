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
          <table class="tr-data">
            <tr>
              <td style="width: 250px;">
                <label>Filtrar por:</label>
                <select style="width: 200px;" id="cmbopcion" onchange="changeOptionFilterLocalizacion();">
                  <option value="op1">Código</option>              
                  <option value="op3">Activo</option>
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
                <span id="top1" class="opt-common">
                  <label>Estado:</label>
                  <select style="width: 207px;" id="cmborden">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                  </select>                  
                </span>
                <span id="top2" class="hide opt-common">
                  <label style="width: 200px;">Descripción / Localización: </label>
                  <input style="width: 200px;" type="text" id="descrip"/>
                </span>               
              </td>              
              <td>
                <a class="a-button" href="javascript:filtrarDatos('localizacion', 'car');">Actualizar</a>
              </td>              
            </tr>
          </table>
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectUnidad($db_conx, 10, 1); ?>
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
                <a href="javascript:filtrarDatos('localizacion', 'ant');">Anterior</a>
                <input disabled="Disabled" style="margin-left: 10px; margin-right: 10px; text-align: center; width: 50px;" type="text" id="pa" value="1"/>
                <a href="javascript:filtrarDatos('localizacion', 'sig');">Siguiente</a>
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