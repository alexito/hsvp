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
  filtrarLocalizacion($db_conx, $_POST['op'], $_POST['btn'], $_POST['rxp'], $_POST['pa'], $_POST['ord'], $_POST['tex']);
  exit();
}

if (isset($_POST["d"])) {
  $d = $_POST['d'];
  $p = $_POST['p'];
  $c = $_POST['c'];
  $pr = $_POST['pr'];
  if ($d == "" || $p == "" || $c == "" || $pr == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tlocalizacion SET 
             loc_descrip = '$d',
             loc_cparr = '$p',
             loc_ccan = '$c',
             loc_cpro = '$pr' 
             WHERE loc_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
    $uid = mysqli_insert_id($db_conx);
    //echo "update_success";
    //exit();
  } else { //This is to INSERT
    $sql = "INSERT INTO tlocalizacion (loc_descrip, loc_cparr, loc_ccan, loc_cpro) VALUES('$d','$p','$c','$pr')";
    $query = mysqli_query($db_conx, $sql);
    $uid = mysqli_insert_id($db_conx);
    //echo "insert_success";
    //exit();
  }

  SelectLocalizacion($db_conx, 10, 1);

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
              <input type="hidden" name="cod_localizacion" id="cod_localizacion" value="" />
              <table><tr><td>
                    <label>Descripción: </label>
                    <input id="descripcion" type="text" maxlength="25">
                  </td><td>
                    <label>Parroquía:</label>
                    <input id="parroquia" type="text" maxlength="50">
                  </td>
                </tr>
                <tr><td>
                    <label>Cantón:</label>
                    <input id="canton" type="text" maxlength="50">
                  </td><td>
                    <label>Provincia:</label>
                    <input id="provincia" type="text" maxlength="50">
                  </td>
                </tr>
              </table>
              <span id="status"></span>
              <br>                            
              <a class="nuevo" id="nueva_localizacion" href="#">Nuevo</a>
              <button id="signupbtn" onclick="createLocalizacion()">Guardar</button>               
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
                  <option value="loc_codigo">Código</option>
                  <option value="loc_descrip">Descripción</option>
                  <option value="loc_cparr">Parroquia</option>
                  <option value="loc_ccan">Cantón</option>
                  <option value="loc_cpro">Provincia</option>
                  <option value="op5">Específicar</option>
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
                <span id="top2" class="hide opt-common">
                  <label style="width: 200px;">Palabra(s) específica(s): </label>
                  <input style="width: 200px;" type="text" id="texto"/>
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
              <?php SelectLocalizacion($db_conx); ?>
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