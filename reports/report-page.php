<?php
include_once("../php_includes/db_conx.php");
include_once("../functions.php");
include_once("../functions2.php");

include_once("../php_includes/check_login_status.php");

if ($user_ok == FALSE) {
  header("location: ../inicio.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>HSVP - RC</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-2.0.0.min.js"></script>
    <script src="js/js.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div id="main-content">
        <table id="cabecera">
          <tr>
            <td>
              <span>
                <img src="css/msp.png" />
              </span>
            </td>
            <td>
              <div>
                <h2>Hospital San Vicente de Paúl.</h2>
              </div>
              <div>
                <h3>Sistema de Referencia y Contrareferencia.</h3>
              </div>
              <div>
                <p>REPORTE DE 
                  <?php
                  echo strtoupper($_GET['page']) . '   -   ';
                  echo gmdate("j/m/Y, g:i a", time() + (3600 * -5));
                  ?>
                </p> 
              </div>
            </td>
          </tr>
        </table>
        <div class="table-report-style"> 
          <table>
            <?php
            if (isset($_GET['btn'])) {//Filtra los datos  
              switch ($_GET['page']) {
                case 'localizaciones':
                  filtrarLocalizacion($db_conx, $_GET['op'], $_GET['btn'], $_GET['rxp'], $_GET['pa'], $_GET['ord'], $_GET['tex']);
                  break;
                case 'pacientes':
                  filtrarPaciente($db_conx, $_GET['op'], $_GET['btn'], $_GET['rxp'], $_GET['pa'], $_GET['ord'], $_GET['fn'], $_GET['gen'], $_GET['ec'], $_GET['tex']);
                  break;
                case 'unidades':
                  filtrarUnidad($db_conx, $_GET['op'], $_GET['btn'], $_GET['rxp'], $_GET['pa'], $_GET['ord'], $_GET['est'], $_GET['tex']);
                  break;
              }
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>