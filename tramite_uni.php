<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'referente') {
  header("location: index.php");
  exit();
}
?><?php
if (isset($_POST['codpac'])) {//Almacena los datos del tramite como referencia
  $codpac = $_POST['codpac'];
  $codmed = $_POST['codmed'];
  $coduni = $_POST['coduni'];
  $codser = $_POST['codser'];
  $codref = $_POST['codref'];
  $mot = $_POST['mot'];
  $res = $_POST['res'];
  $hal = $_POST['hal'];
  $pla = $_POST['pla'];
  $dia = $_POST['dia'];
  $pd = $_POST['pd'];

  $sql = "SELECT unm_codigo FROM tunidadmedico WHERE med_codigo = $codmed AND uni_codigo = $coduni";
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $codunm = $row[0];

  $sql = "SELECT res_codigo FROM trefservicios WHERE ser_codigo = $codser AND ref_codigo = $codref";
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $codres = $row[0];

  $sql = "INSERT INTO ttramite (pac_codigo, res_codigo, unm_codigo, tra_fecha, tra_motivo, tra_resum_cuad_clin,
    tra_hall_exm_proc_diag, tra_plan_trat) 
      VALUES( $codpac, $codres, $coduni, NOW(),'$mot', '$res', '$hal', '$pla')";
  $query = mysqli_query($db_conx, $sql);
  $uid = mysqli_insert_id($db_conx);

  //ALMACENA EL TRAMITE CON LOS DIAGNOSTICOS
  $tem = explode('-', $dia);
  $tempd = explode('-', $pd);
  for ($i = 0; $i < count($tem); $i++) {
    $sql = "INSERT INTO tdiagsie10 (tra_codigo, sie_codigo, dia_diagnos) 
      VALUES( $uid, $tem[$i], '$tempd[$i]')";
    $query = mysqli_query($db_conx, $sql);
  }
  exit();
}
if (isset($_POST['loadserv'])) {//Obtiene los datos del paciente seleccionado
  getServicioData($db_conx, $_POST['cod']);
  exit();
}
if (isset($_POST['pac'])) {//Obtiene los datos del paciente seleccionado
  getPacienteData($db_conx, $_POST['cod']);
  exit();
}
if (isset($_POST['autopac'])) {//Carga los datos del autocompletado de pacientes
  getPacienteAutocomplete($db_conx);
  exit();
}
if (isset($_POST['autoserv'])) {//Carga los datos del autocompletado de pacientes
  //EN CASO DE CONTAR CON OTRA ENTIDAD REFERENCIADA SE DEBERA ENVIAR EL CODIGO DE
  //DICHA ENTIDAD .::. POR EL MOMENTO QUEDA CON LA UNICA ENTIDAD HSVP COD=1
  //EJEMPLO: 
  //$ref = $_POST['ref'];
  //getServicioAutocomplete($db_conx, $ref);
  getServicioAutocomplete($db_conx);
  exit();
}
if (isset($_POST['tip'])) {//Carga datos de la unidad actual seleccionada
  $tip = $_POST['tip'];
  if ($tip == 'referente') {
    $cod = $_POST['cod'];
    $sql = "SELECT loc_cparr, loc_ccan, loc_cpro FROM vlocalunidad WHERE uni_codigo = $cod LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_array($query);
    $data = $row[0] . '-' . $row[1] . '-' . $row[2];
    echo $data;
  }
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
              <input type="hidden" name="cod_tramite" id="cod_tramite" value="" />              
              <input type="hidden" name="cod_medref" id="cod_medref" value="<?php echo $log_id; ?>" />
              <!-- ESTE CAMPO ALMACENA EL ID DE LA ENTIDAD REFERENCIADA - POR DEFECTO TIENE EL CODIGO 1
              QUE PERTENECECE AL HSVP, SE DEBERA IMPLEMENTAR CODIGO PARA ASIGNAR EL COD CORRESPONDIENTE
              EN CASO DE SER OTRA LA ENTIDAD REFERENCIADA-->
              <input type="hidden" name="cod_referenciado" id="cod_referenciado" value="1" />

              <table><tr>
                  <td  style="width: 500px;"><h2>Referencia</h2></td>
                  <td><?php echo date("d M y H:m", time()); ?></td>
                </tr></table><table><tr>
                  <td>
                    <label>Unidad: </label>
                    <?php SelectValuesUnidadesPerteneceMedico($db_conx, $log_id) ?>
                  </td>
                </tr><tr class="tr-data">
                  <td><label>Parroquia:</label><span class="data" id="par">parroquia</span></td>
                  <td><label>Cantón:</label><span class="data" id="can">canton</span></td>
                  <td><label>Provincia:</label><span class="data" id="pro">provincia</span></td>
                </tr></table><table>
                <tr>
                  <td>
                    <label style="width: 300px;">Cédula del paciente: </label>
                    <input type="hidden" name="cod_paciente" id="cod_paciente" value="" />
                    <input style="width: 300px;" type="text" name="paciente" id="paciente-auto"/>
                    <span style="position: absolute;margin-left: 10px;">
                      <img id="searchPaciente" src="images/icono-buscar.png" style="cursor:pointer ;display: block; width: 20px; margin-left: 10px;"><span>Buscar</span>
                    </span><span style="position: absolute;margin-left: 70px;">
                      <a href="paciente.php" target="blank"><img id="searchPaciente" src="images/icono-anadir.png" style="display: block; width: 20px; margin-left: 10px;"></a><span>Nuevo</span>
                    </span>
                  </td>
                </tr></table><table class="custom-table">
                <tr style="margin-top: 20px;float: left;">
                  <td><label>Apellido P.:</label><span class="data" id="pape"></span></td>
                  <td><label>Apellido M.:</label><span class="data" id="sape"></span></td>
                  <td><label>Nombre:</label><span class="data" id="nom"></span></td>
                  <td><label>Cédula:</label><span class="data" id="ced"></span></td>
                </tr> 
                <tr style="float: left;">
                  <td><label>F. Nacimiento:</label><span class="data" id="fnac"></span></td>
                  <td><label>Historia C.:</label><span class="data" id="hc"></span></td>
                  <td><label>Género:</label><span class="data" id="gen"></span></td>
                  <td><label>Est. Civil:</label><span class="data" id="ec"></span></td>
                </tr> 
                <tr class="tr-data">
                  <td><label>Teléfono:</label><span class="data" id="tel"></span></td>
                  <td><label>Instrucción:</label><span class="data" id="ins"></span></td>
                  <td><label>Empresa:</label><span class="data" id="emp"></span></td>
                  <td><label>Seguro:</label><span class="data" id="seg"></span></td>                    
                </tr> 
              </table><table>
                <tr class="tr-data">
                  <td>
                    <label style="width: 150px;">Servicio requerido: </label>
                    <input type="hidden" name="cod_servicio" id="cod_servicio" value="" />
                    <input style="width: 300px; margin-bottom: 20px;" type="text" name="servicio" id="servicio-auto"/>
                    <span style="position: absolute;margin-left: 10px;"><a href="servicios.php" target="blank"><img id="searchServcio" src="images/icono-anadir.png" style="display: block; width: 20px; margin-left: 10px;"></a><span>Nuevo</span></span>
                  </td>
                </tr>    
              </table>
              <table id="sie10" class="tr-data">
                <tr><td><label>Diagnóstico:</label><span class="data" id="serv">
                      <a id="add-diag" href="#">Añadir <img style="width: 20px; margin-bottom: -4px;" src="images/icono-anadir2.png"></a>
                    </span></td></tr>
                <tr><td>
                    <input class="cod_diag_class" type="hidden" name="cod_diag" id="cod-diag-1" value="" />
                    <input style="width:25px;" type="radio" name="group-1" value="pre" checked="true">PRE
                    <input style="width:25px;" type="radio" name="group-1" value="def">DEF
                    <input style="width:400px;" type="text" name="diagnostico" id="diagnostico-auto-1"/>                      
                  </td></tr>
              </table>
              <table><tr>
                  <td>
                    <label style="width: 400px;">Motivo de Referencia:</label>
                    <textarea style="width: 520px; height: 70px;" id="motivo_ref" cols="20" rows="2"></textarea>
                  </td>
                </tr><tr>
                  <td>
                    <label style="width: 400px;">Resumen del Cuadro Clínico:</label>
                    <textarea style="width: 520px; height: 70px;" id="resumen_ref" cols="20" rows="2"></textarea>
                  </td>
                </tr><tr>
                  <td>
                    <label style="width: 400px;">Hallazgos relevantes de examenes y procedimientos diagnósticos:</label>
                    <textarea style="width: 520px; height: 70px;" id="hallazgo_ref" cols="20" rows="2"></textarea>
                  </td>
                </tr><tr class="tr-data">
                  <td>
                    <label style="width: 400px;">Plan tratamiento realizado:</label>
                    <textarea style="width: 520px; height: 70px;" id="plan_ref" cols="20" rows="2"></textarea>
                  </td>
                </tr></table>
              <table><tr style="float: left; margin-left: 150px;"><td>
                    <a style="margin-top: 10px;" class="nuevo" href="tramite_uni.php">Nuevo</a></td><td>
                    <a id="saveTramiteUnidad" onclick="">Enviar...</a> </td><td>
                    <span id="status"></span></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>