<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'referente') {
  header("location: logout.php");
  exit();
}
?><?php
if (isset($_POST["pnom"])) {
  $pnom = $_POST['pnom'];
  $snom = $_POST['snom'];
  $pape = $_POST['pape'];
  $sape = $_POST['sape'];
  $ced = $_POST['ced'];
  $fnac = $_POST['fnac'];
  $cmbgenero = $_POST['cmbgenero'];
  $cmbestciv = $_POST['cmbestciv'];
  $ins = $_POST['ins'];
  $hc = $_POST['hc'];
  $tel = $_POST['tel'];
  $seg[0] = $seg[1] = "";
  $seg[2] = "seg_codigo = null,";
  if ($_POST['seg'] != null || $_POST['seg'] != "") {
    $seg[0] = "seg_codigo,";
    $seg[1] = $_POST['seg'] . ",";
    $seg[2] = "seg_codigo = " . $_POST['seg'] . ",";
  }
  $emp[0] = $emp[1] = "";
  $emp[2] = "emp_codigo = null,";  
  if ($_POST['emp'] != null || $_POST['emp'] != "") {
    $emp[0] = "emp_codigo,";
    $emp[1] = $_POST['emp'] . ",";
    $emp[2] = "emp_codigo = " . $_POST['emp'] . ",";
  }  
  if ($pnom == "" || $snom == "" || $pape == "" || $sape == "" || $ced == "" || $fnac == "" ||
          $cmbgenero == "" || $cmbestciv == "" || $ins == "" || $hc == "" || $tel == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tpaciente SET " .
            $seg[2] .
            $emp[2] .
             "pac_pnom = '$pnom',
             pac_snom = '$snom',
             pac_pape = '$pape',
             pac_sape = '$sape',
             pac_cedula = '$ced',
             pac_fch_nac = '$fnac',
             pac_genero = '$cmbgenero',
             pac_est_civ = '$cmbestciv',
             pac_instruc = '$ins',
             pac_hc = '$hc',
             pac_telef = '$tel'
             WHERE pac_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
  } else { //This is to INSERT
    $sql = "INSERT INTO tpaciente (" . $seg[0] . $emp[0] . "pac_cedula, pac_pnom, pac_snom, pac_pape, pac_sape,
      pac_fch_nac, pac_genero, pac_est_civ, pac_instruc, pac_hc, pac_telef) 
      VALUES(" . $seg[1] . $emp[1] . "'$ced','$pnom','$snom','$pape','$sape','$fnac','$cmbgenero','$cmbestciv','$ins','$hc','$tel')";
    $query = mysqli_query($db_conx, $sql);
    $uid = mysqli_insert_id($db_conx);
    //echo "insert_success";
    //exit();
  }

  SelectPaciente($db_conx, 10, 1);

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
              <input type="hidden" name="cod_paciente" id="cod_paciente" value="" />
              <table><tr><td>
                    <label>P. Nombre: </label>
                    <input id="pnom" type="text" maxlength="25">
                  </td><td>
                    <label>S. Nombre:</label>
                    <input id="snom" type="text" maxlength="25">
                  </td><td>
                    <label>P. Apellido: </label>
                    <input id="pape" type="text" maxlength="25">
                  </td><td>
                    <label>S. Apellido:</label>
                    <input id="sape" type="text" maxlength="25">
                  </td>                  
                </tr><tr><td>
                    <label>Cedula: </label>
                    <input id="ced" type="text" maxlength="15">
                  </td><td>
                    <label>F. Nacimiento:</label>
                    <input id="fnac" type="text" maxlength="10">
                  </td><td>
                    <label>Genero:</label>
                    <select class="genero" id="cmbgenero">     
                      <option value="">Seleccione...</option>
                      <option value="masculino">Masculino</option>
                      <option value="femenino">Femenino</option>
                      <option value="indefinido">Indefinido</option>
                    </select>
                  </td><td>
                    <label>Estado Civil:</label>
                    <select class="estciv" id="cmbestciv">
                      <option value="">Seleccione...</option>
                      <option value="soltero">Soltero</option>
                      <option value="casado">Casado</option>
                      <option value="divorciado">Divorciado</option>
                      <option value="viudo">Viudo</option>
                      <option value="unionlibre">Union libre</option>
                    </select>
                  </td>                  
                </tr><tr><td>
                    <label>Instruccion: </label>
                    <input id="ins" type="text" maxlength="15">
                  </td><td>
                    <label>Historia Clinica:</label>
                    <input id="hc" type="text" maxlength="10">
                  </td><td>
                    <label>Telefono: </label>
                    <input id="tel" type="text" maxlength="12">
                  </td>
                </tr>
                <tr>
                  <!--           SEGURO         c-->
                  <td>
                    <label>Seguro:</label>
                    <div id="value_seguros">                      
                      <?php SelectValuesSeguros_Empresas($db_conx, 'seguros'); ?>
                    </div>
                    <div id="seglinks">
                      <a id="segagregar" href="#">Agregar</a> - <a id="segeditar" href="#">Editar</a>
                    </div>
                  </td>
                  <td>
                    <div id="msgseg" style="max-width: 150px; margin-top: -90px; display: none; border: #4db3af dashed thin; padding: 5px;">
                      
                    </div>
                    <div id="frmseg" style="display: none; border: #4db3af dashed thin; padding: 5px;">
                      <h5>Seguro:</h5>
                      <input type="hidden" name="cod_seguro" id="cod_seguro" value="" />
                      <label>Descripcion:</label>
                      <input id="seg_descrip" type="text" maxlength="15">
                      <label>Observacion:</label>
                      <textarea id="seg_observ" cols="10" rows="2"></textarea><br>
                      <a id="segguardar" href="#">Guardar</a> - <a id="segcancelar" href="#">Cancelar</a>
                    </div>
                  </td>
                  <!--           EMPRESA         c-->
                  <td >
                    <div id="value_empresas" >
                      <label>Empresa:</label>
                      <?php SelectValuesSeguros_Empresas($db_conx, 'empresas'); ?>
                    </div>
                    <div id="emplinks">
                      <a id="empagregar" href="#">Agregar</a> - <a id="empeditar" href="#">Editar</a>
                    </div>
                  </td>
                  <td>
                    <div id="msgemp" style="max-width: 150px; margin-top: -90px; display: none; border: #4db3af dashed thin; padding: 5px;">
                      
                    </div>
                    <div id="frmemp" style="display: none; border: #4db3af dashed thin; padding: 5px;">
                      <h4>Empresa:</h4>
                      <input type="hidden" name="cod_empresa" id="cod_empresa" value="" />
                      <label>Descripcion:</label>
                      <input id="emp_descrip" type="text" maxlength="15">
                      <label>Observacion:</label>
                      <textarea id="emp_observ" cols="10" rows="2"></textarea><br>
                      <a id="empguardar" href="#">Guardar</a> - <a id="empcancelar" href="#">Cancelar</a>
                    </div>
                  </td>
                </tr>                
              </table>

              <span id="status"></span>
              <br>                            
              <a class="nuevo" id="nuevo_paciente" href="#">Nuevo</a>
              <button id="submitbtn" onclick="createPaciente()">Guardar</button>

            </form>
          </div>
        </div>
        <div class="cleaner"></div>
        <div class="col_w900">
          <div id="table_content" class="tablestyle">
            <table id="table_data">
              <!--  table data / It happens only the first loading -->
              <?php SelectPaciente($db_conx, 10, 1); ?>
            </table>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>