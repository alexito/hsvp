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
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectLocalizacion($db_conx, 10, 1); ?>
            </table>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>