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
  filtrarUsuario($db_conx, $_POST['op'], $_POST['btn'], $_POST['rxp'], $_POST['pa'], $_POST['ord'], $_POST['tip'], $_POST['est'], $_POST['tex']);
  exit();
}
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

  SelectUsuario($db_conx);

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
                    <input id="usuario" type="text" maxlength="20" onKeyPress="return onlyText(event);">
                  </td><td>
                    <label>Clave:</label>
                    <input id="clave" type="text" maxlength="20" placeholder="mínimo 6 caracteres">
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
          <table class="tr-data">
            <tr>
              <td style="width: 250px;">
                <label>Filtrar por:</label>
                <select style="width: 200px;" id="cmbopcion" onchange="changeOptionFilterUsuario();">
                  <option value="op1">Código</option>              
                  <option value="op2">Nombre</option>
                  <option value="op3">Tipo</option>
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
                <span  class="opt-common">
                  <label>Estado:</label>
                  <select style="width: 207px;" id="cmbest">     
                    <option value="op0">Ambos</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                  </select>
                </span>
              </td><td>                
                <span class="opt-common">
                  <label>Tipo:</label>
                  <select style="width: 207px;" id="cmbtip">
                    <option value="op0">Todos...</option>
                    <option value="admin">Administrador</option>
                    <option value="contrareferente">Contrareferente</option>
                    <option value="referente">Referente</option>
                  </select>           
                </span>  
                <span class="tx hide opt-common">
                  <label style="width: 200px;">Buscar: </label>
                  <input style="width: 200px;" type="text" id="texto"/>
                </span>
              </td>              
              <td>
                <a style="display: block;" class="a-button" href="javascript:filtrarDatos('usuario', 'car');">Actualizar</a>
                <a style="display: block;" id="print-url" class="a-button" href="http://localhost/HSVP/reports/report-page.php?page=usuarios&btn=car&rxp=2&pa=1&op=op1&ord=ASC&tip=op0&est=op0&tex=" target="_blank">Ver Reporte</a>
              </td>              
            </tr>
          </table>
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectUsuario($db_conx); ?>
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
                <a href="javascript:filtrarDatos('usuario', 'ant');">Anterior</a>
                <input disabled="Disabled" style="margin-left: 10px; margin-right: 10px; text-align: center; width: 50px;" type="text" id="pa" value="1"/>
                <a href="javascript:filtrarDatos('usuario', 'sig');">Siguiente</a>
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