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
  filtrarServicios($db_conx, $_POST['btn'], $_POST['rxp'], $_POST['pa'], $_POST['ord'], $_POST['tex']);
  exit();
}

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
                  <div class ="hide" id="reflinks">
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
          <table class="tr-data">
              <td style="width: 250px;">
                <span id="top1" class="opt-common">
                  <label>Descripción:</label>
                  <select style="width: 207px;" id="cmborden">
                    <option value="ASC">Ascendente</option>
                    <option value="DESC">Descendente</option>
                  </select>                  
                </span>
                </td><td style="width: 250px;">
                <span id="top2" class="opt-common">
                  <label style="width: 200px;">Buscar: </label>
                  <input style="width: 200px;" type="text" id="texto"/>
                </span>               
              </td>              
              <td>
                <a class="a-button" href="javascript:filtrarDatos('servicios', 'car');">Actualizar</a>
              </td>              
            </tr>
          </table> 
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectServicios($db_conx); ?>
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
                <a href="javascript:filtrarDatos('servicios', 'ant');">Anterior</a>
                <input disabled="Disabled" style="margin-left: 10px; margin-right: 10px; text-align: center; width: 50px;" type="text" id="pa" value="1"/>
                <a href="javascript:filtrarDatos('servicios', 'sig');">Siguiente</a>
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