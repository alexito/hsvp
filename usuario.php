<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

session_start();
// If user is logged in, header them away
if (isset($_SESSION["username"])) {
  header("location: message.php?msg=Error inesperado - localizacion.php");
  exit();
}
?><?php
if (isset($_POST["u"])) {
  $u = $_POST['u'];
  $c = md5($_POST['c']);
  $t = $_POST['t'];
  $a = $_POST['a'];
  //$f = $_POST['f'];
  if ($u == "" || $c == "" || $t == "" || $a == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tusuario SET 
             usu_usuario = '$u',
             usu_clave = '" . $c . "',
             usu_tipo = '$t',
             usu_activo = '$a'
             WHERE usu_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
  } else { //This is to INSERT
    $sql = "INSERT INTO tusuario (usu_usuario, usu_clave, usu_tipo, usu_activo) 
      VALUES('$u','$c','$t','$a')";
    $query = mysqli_query($db_conx, $sql);
  }

  SelectUsuario($db_conx, 10, 1);

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
              <input type="hidden" name="cod_usuario" id="cod_usuario" value="" />
              <table><tr><td>
                    <label>Usuario: </label>
                    <input id="usuario" type="text" maxlength="20">
                  </td><td>
                    <label>Clave:</label>
                    <input id="clave" type="text" maxlength="20">
                  </td>
                </tr>
                <tr><td>
                    <label>Tipo:</label>
                    <select class="activo" id="cmbtipo">
                        <option value="">Seleccione...</option>
                        <option value="admin">Administrador</option>                        
                        <option value="contrareferente">Contrareferente</option>
                        <option value="referente" disabled>Referente</option>
                      </select>
                  </td><td>
                    <label>Activo:</label>
                    <select class="activo" id="cmbactivo">
                        <option value="">Seleccione...</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                      </select>
                  </td>
                </tr>
              </table>
              <span id="status"></span>
              <br>                            
              <a class="nuevo" id="nuevo_usuario" href="#">Nuevo</a>
              <button id="submitbtn" onclick="createUsuario()">Guardar</button>               
            </form>
          </div>
        </div>
        <div class="cleaner"></div>
        <div class="col_w900">
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectUsuario($db_conx, 10, 1); ?>
            </table>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>