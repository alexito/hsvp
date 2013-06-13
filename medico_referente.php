<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

session_start();
// If user is logged in, header them away
if (isset($_SESSION["username"])) {
  header("location: message.php?msg=Error inesperado - medico_referente.php");
  exit();
}
?><?php
if (isset($_POST["codmed"])) {
  $set_user = FALSE;
  if ($_POST['usu'] != "0" && $_POST['cla'] != "0") {
    $u = $_POST['usu'];
    $c = md5($_POST['cla']);
    $set_user = TRUE;
  }
  $codmed = $_POST['codmed'];
  $esp = $_POST['esp'];
  $obs = $_POST['obs'];
  $est = $_POST['est'];
  $pnom = $_POST['pnom'];
  $snom = $_POST['snom'];
  $pape = $_POST['pape'];
  $sape = $_POST['sape'];
  $unid = $_POST['unid'];
  if ($codmed == "" || $esp == "" || $obs == "" || $est == "" || $pnom == "" || $snom == "" || $pape == "" || $sape == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tmedicoreferente SET 
             med_codmed = '$codmed',
             med_especial = '$esp',
             med_observ = '$obs',
             med_estado = '$est',
             med_pnom = '$pnom',
             med_snom = '$snom',
             med_pape = '$pape',
             med_sape = '$sape' 
             WHERE med_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
    $uid = $cod;

    $sql = "UPDATE  tunidadmedico SET unm_activo = 'inactivo' WHERE med_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);

    $unid = explode(",", $unid);
    for ($i = 0; $i < count($unid); $i++) {
      $temsql = "SELECT * FROM tunidadmedico WHERE med_codigo = $uid AND uni_codigo = $unid[$i]";
      $temquery = mysqli_query($db_conx, $temsql);
      if (mysqli_num_rows($temquery) > 0) {
        $sql = "UPDATE  tunidadmedico SET unm_activo = 'activo' WHERE med_codigo = $uid AND uni_codigo = $unid[$i]";
        $query = mysqli_query($db_conx, $sql);
      } else {
        $sql = "INSERT INTO tunidadmedico (med_codigo, uni_codigo, unm_activo) 
          VALUES($uid,$unid[$i],'$est');";
        $query = mysqli_query($db_conx, $sql);
      }
    }

    //UPDATE USUARIO  Y CLAVE
    if ($set_user) {
      $sql = "UPDATE tusuario SET 
             usu_usuario = '$u',
             usu_clave = '$c',
             usu_tipo = 'referente',
             usu_activo = 'activo'             
             WHERE med_codigo = $cod";
      $query = mysqli_query($db_conx, $sql);
    }
  } else { //This is to INSERT
    $sql = "INSERT INTO tmedicoreferente (med_codmed, med_especial, med_observ,
      med_estado, med_pnom, med_snom, med_pape, med_sape) VALUES('$codmed','$esp','$obs','$est', '$pnom', '$snom', '$pape', '$sape');";
    $query = mysqli_query($db_conx, $sql);
    $uid = mysqli_insert_id($db_conx);

    //INSERT USUARIO Y CLAVE
    if ($set_user) {
      $sql = "INSERT INTO tusuario (usu_usuario, usu_clave, usu_tipo, usu_activo, med_codigo) 
      VALUES('$u','$c','referente','activo', $uid)";
      $query = mysqli_query($db_conx, $sql);
    }
    
    $sql = "UPDATE  tunidadmedico SET unm_activo = 'inactivo' WHERE med_codigo = $uid";
    $query = mysqli_query($db_conx, $sql);

    $unid = explode(",", $unid);
    for ($i = 0; $i < count($unid); $i++) {
      $temsql = "SELECT * FROM tunidadmedico WHERE med_codigo = $uid AND uni_codigo = $unid[$i]";
      $temquery = mysqli_query($db_conx, $temsql);
      if (mysqli_num_rows($temquery) > 0) {
        $sql = "UPDATE  tunidadmedico SET unm_activo = 'activo' WHERE med_codigo = $uid AND uni_codigo = $unid[$i]";
        $query = mysqli_query($db_conx, $sql);
      } else {
        $sql = "INSERT INTO tunidadmedico (med_codigo, uni_codigo, unm_activo) 
          VALUES($uid,$unid[$i],'$est');";
        $query = mysqli_query($db_conx, $sql);
      }
    }
  }

  SelectMedicoReferente($db_conx, 10, 1);

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
              <input type="hidden" name="cod_medicoreferente" id="cod_medicoreferente" value="" />

              <table><tr><div id="value_unidades" style="display: block; float: right; margin-right: 110px;">
                  <label>Unidades:</label>
                  <?php SelectValuesUnidad($db_conx); ?>
                </div></tr><tr><td>                    
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
                  </td></tr><tr><td>                    
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
                <tr class="usu-cla"><td >
                    <label>Usuario: </label>
                    <input id="usuario" type="text" maxlength="20">
                  </td><td>
                    <label>Clave:</label>
                    <input id="clave" type="text" maxlength="20">
                  </td></tr>
              </table>
              <label>Observacion:</label>
              <textarea id="observacion-med-ref" cols="20" rows="2"></textarea>
              <br>

              <div>
                <span id="status"></span>
                <br>                            
                <a class="nuevo" id="nuevo_medicoreferente" href="#">Nuevo</a>
                <button id="submitbtn" onclick="createMedicoReferente()">Guardar</button>               
              </div>
            </form>
          </div>
        </div>
        <div class="cleaner"></div>
        <div class="col_w900">
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectMedicoReferente($db_conx, 10, 1); ?>
            </table>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>