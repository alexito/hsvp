<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'admin') {
  header("location: logout.php");
  exit();
}
?><?php
//When Change the selected option in combobox
if (isset($_POST["get"])) {
  $cod = $_POST['cod'];
  if ($_POST['get'] == "servicios") {
    getServicioxMedico($db_conx, "servicios", $cod);
  } else if ($_POST['get'] == "medicos") { //This is for UPDATE  
    getServicioxMedico($db_conx, "medicos", $cod);
  }
  exit();
}
//When Save relation MedicoxServicios
if (isset($_POST['save'])) {
  $medref = $_POST['medref'];
  $serv = $_POST['serv'];
  $mr = explode(',', $medref);
  $se = explode(',', $serv);
  if ($_POST["op"] == "ms") {
    $sql = "UPDATE tmedicoxservicio SET mes_activo = 'inactivo' WHERE mer_codigo = $mr[0]";
    $query = mysqli_query($db_conx, $sql);

    for ($i = 0; $i < count($se); $i++) {
      $sqltem = "SELECT * FROM tmedicoxservicio WHERE mer_codigo = $mr[0] AND res_codigo = $se[$i]";
      $querytem = mysqli_query($db_conx, $sqltem);
      $n_filas = $querytem->num_rows;
      if ($n_filas > 0) {
        $sql = "UPDATE tmedicoxservicio SET mes_activo = 'activo' WHERE mer_codigo = $mr[0] AND res_codigo = $se[$i]";
        $query = mysqli_query($db_conx, $sql);
      } else {
        $sql = "INSERT INTO tmedicoxservicio (mer_codigo, res_codigo, mes_activo) VALUES($mr[0], $se[$i], 'activo')";
        $query = mysqli_query($db_conx, $sql);
      }
    }
  } else if ($_POST["op"] == "sm") {
    $sql = "UPDATE tmedicoxservicio SET mes_activo = 'inactivo' WHERE res_codigo = $se[0]";
    $query = mysqli_query($db_conx, $sql);

    for ($i = 0; $i < count($mr); $i++) {
      $sqltem = "SELECT * FROM tmedicoxservicio WHERE res_codigo = $se[0] AND mer_codigo = $mr[$i]";
      $querytem = mysqli_query($db_conx, $sqltem);
      $n_filas = $querytem->num_rows;
      if ($n_filas > 0) {
        $sql = "UPDATE tmedicoxservicio SET mes_activo = 'activo' WHERE res_codigo = $se[0] AND mer_codigo = $mr[$i]";
        $query = mysqli_query($db_conx, $sql);
      } else {
        $sql = "INSERT INTO tmedicoxservicio (mer_codigo, res_codigo, mes_activo) VALUES($mr[$i], $se[0], 'activo')";
        $query = mysqli_query($db_conx, $sql);
      }
    }
  }
  echo 'Datos Actualizados Correctamente.';
  exit();
}
?>
<head>
  <?php include_once("php_includes/head.php"); ?>
</head>
<body>
  <div id="templatemo_wrapper">
    <?php include_once("php_includes/template_pageTop.php"); ?>

    <div id="templatemo_main">
      <div id="pageMiddle">
        <div class="accordion_holder">
          <div id="basic-accordian" >
            <div class="tab_container">
              <div id="op1" class="accordion_headings header_highlight" >Medico - Servicios</div>
              <div id="op2" class="accordion_headings" >Servicio - Medicos</div>
            </div>
            <div style="float:left;">
              <div id="dat1" class="accordion_content"  >
                <div class="accordion_child">
                  <table style="width: 100%;"><tr><td>
                        <label>Medico:</label></td><td><label style="margin-left: 45px;">Servicio:</label>
                      </td></tr><tr><td style="width: 50%;">
                        <?php SelectValuesServicios_MReferenciado($db_conx, 'medicoreferenciado'); ?>
                        <img id="loader" style="float: right;margin-right: -42px;margin-top: 220px;width: 80px; display: none;" src="images/loading2.gif">
                      </td><td style="width: 50%;">
                        <?php SelectValuesServicios_MReferenciado($db_conx, 'servicios', 'multiple'); ?>
                      </td></tr>
                  </table>
                  <div style="width: 50%;">
                    <button id="btnrel" onclick="saveMedicoServicio('ms')">Guardar</button>
                    <span id="status" class="status-rel">Seleccione un Medico y los Servicios.</span>
                  </div>
                </div>
              </div>
              <div id="dat2" class="accordion_content hide">
                <div class="accordion_child">
                  <table style="width: 100%;"><tr><td>
                        <label>Servicio:</label></td><td><label style="margin-left: 45px;">Médicos:</label>
                      </td></tr><tr><td style="width: 50%;">
                        <?php SelectValuesServicios_MReferenciado($db_conx, 'servicios'); ?>
                        <img id="loaderx" style="float: right;margin-right: -42px;margin-top: 220px;width: 80px; display: none;" src="images/loading2.gif">
                      </td><td style="width: 50%;">
                        <?php SelectValuesServicios_MReferenciado($db_conx, 'medicoreferenciado', 'multiple'); ?>
                      </td></tr>
                  </table>    
                  <div style="width: 50%;">
                    <button id="btnrelx" onclick="saveMedicoServicio('sm')">Guardar</button>
                    <span id="statusx" class="status-rel">Seleccione un Servicio y los Medicos.</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once("php_includes/template_pageBottom.php"); ?>
</body>
</html>
