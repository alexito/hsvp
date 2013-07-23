<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

include_once("php_includes/check_login_status.php");

if ($user_ok == FALSE || $log_tipo != 'referente') {
  header("location: referencias_uni.php");
  exit();
}
if (isset($_GET['cod_tramite'])) {
  if (!verficarTramitePertenencia($db_conx, $_GET['cod_tramite'], $_SESSION['codigo'])) {
    header("location: referencias_uni.php");
  }
}
?><?php
if (isset($_POST['tra'])) {//Obtiene el cod del Paciente relacionado a este tramite
  $sql = "SELECT pac_codigo FROM ttramite WHERE tra_codigo =" . $_POST['cod'];
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  echo $row[0];
  exit();
}
if (!isset($_GET['cod_tramite'])) {//Carga los datos del autocompletado de pacientes
  header("location: referencias_uni.php");
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
        <div class="tramite-class" id="pageMiddle">
          <div id="genform_style" style="border-bottom: medium none;">
            <form name="genform" id="genform" onsubmit="return false;">
              <input type="hidden" name="cod_tramite" id="cod_tramite" value="<?php echo $_GET['cod_tramite']; ?>" />              

              <table><tr>
                  <td  style="width: 500px;"><h3>Referencia </h3></td><td><h4>Trámite Nro:  <?php echo $_GET['cod_tramite']; ?></h4></td>

                </tr></table>
              <?php selectTramiteLocalizacion($db_conx, $_GET['cod_tramite']); ?>
              <table class="custom-table">
                <tr>
                  <td>
                    <label><h5>Paciente:</h5></label>                    
                  </td>
                </tr>
                <tr style="margin-top: -10px;float: left;">
                  <td><h6>Apellido P.:</h6><span id="pape"></span></td>
                  <td><h6>Apellido M.:</h6><span id="sape"></span></td>
                  <td><h6>Nombre:</h6><span id="nom"></span></td>
                  <td><h6>Cédula:</h6><span id="ced"></span></td>
                </tr> 
                <tr style="float: left;">
                  <td><h6>F. Nacimiento:</h6><span id="fnaci"></span></td>
                  <td><h6>Historia C.:</h6><span id="hc"></span></td>
                  <td><h6>Género:</h6><span id="gen"></span></td>
                  <td><h6>Est. Civil:</h6><span id="ec"></span></td>
                </tr> 
                <tr class="tr-data">
                  <td><h6>Teléfono:</h6><span id="tel"></span></td>
                  <td><h6>Instrucción:</h6><span id="ins"></span></td>
                  <td><h6>Empresa:</h6><span id="emp"></span></td>
                  <td><h6>Seguro:</h6><span id="seg"></span></td>                    
                </tr> 
              </table><table>
                <tr class="tr-data">
                  <td>
                    <label style="width: 150px;"><h5>Servicio requerido:</h5></label>                    
                    <span id="ser"><?php selectTramiteServicio($db_conx, $_GET['cod_tramite']); ?></span>
                  </td>
                </tr>    
              </table>
              <table id="sie10" class="tr-data">
                <tr><td><label><h5>Diagnóstico:</h5></label></td></tr>
                <tr><td>
                    <ul>
                      <?php selectTramiteDiagnostico($db_conx, $_GET['cod_tramite']); ?>
                    </ul>
                  </td></tr>
              </table>
              <?php selectTramiteData($db_conx, $_GET['cod_tramite']); ?>

              <?php if (isTramitePendiente($db_conx, $_GET['cod_tramite'])) { ?>
  <!--                <table class="tr-data">
                    <tr>
                      <td style="width: 60%;">
                        <h5>Médicos disponibles:</h5>
                <?php //SelectValuesMedicoServicio($db_conx, $_GET['cod_tramite']); ?>
                      </td>
                      <td>
                        <table>
                          <tr>
                            <td>
                              <h5>Asignar fecha de atención:</h5>
                              <input placeholder="Fecha de atención." style="width: 200px;" type="text" id="fecha-atencion"/>
                            </td>                    
                          </tr>
                          <tr>
                            <td>
                              <h5>Sala:</h5>
                              <input placeholder="Sala (opcional)" style="width: 200px;" type="text" id="sala"/>
                            </td>                    
                          </tr>
                          <tr>
                            <td>
                              <h5>Cama:</h5>
                              <input placeholder="Cama (opcional)" style="width: 200px;" type="text" id="cama"/>
                            </td>                    
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h5>Observación:</h5>
                        <textarea style="height: 150px; width: 390px;" id="observacion" cols="20" rows="2"></textarea>
                      </td>
                      <td>
                        <table>
                          <tr class="custom-row1"><td>                    
                              <a style="float: left; margin-top: 100px; margin: 4px; width: 180px;" class="a-button" id="confirmar-tramite" >CONFIRMAR TRAMITE...</a></td>
                          </tr><tr class="custom-row1">
                            <td><a style="float: left; margin: 4px; width: 180px;" class="a-button" id="cancelTramite" >CANCELAR TRAMITE...</a></td>
                          </tr><tr class="custom-row2" style="display: none; border: 3px dotted red;float: left;padding: 18px;">
                            <td><span id="status">El trámite se cancelará de forma permanente,<br>¿Desea continuar con la cancelación del trámite?</span></td>
                            <td style="float: left;margin-left: 90px;margin-top: 20px;"><a class="a-button" id="cancelTramiteHospitalSi" >SI</a></td>
                            <td style="float: left;margin-top: 20px;"><a class="a-button" id="cancelTramiteNo" >NO</a></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>                -->
              <?php } else if (isTramiteConfirmado($db_conx, $_GET['cod_tramite']) && !isTramiteContrareferencia($db_conx, $_GET['cod_tramite'])) { ?>
                <table class="tr-data">
                  <tr>
                    <td style="width: 60%;">
                      <h5>Médico:</h5>
                      <span id="medicoref">
                        <?php
                        $sql = "SELECT mer_pape, mer_sape, mer_pnom, mer_snom FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                        $query = mysqli_query($db_conx, $sql);
                        $row = mysqli_fetch_array($query);
                        echo '' . $row[0] . ' ' . $row[1] . ' ' . $row[2] . ' ' . $row[3];
                        ?></span>
                    </td>
                  </tr><tr>
                    <td>
                      <table>
                        <tr>
                          <td style="width: 200px;">                      
                            <h5>Fecha de atención:</h5>
                            <span id="fecha-confirmado">
                              <?php
                              $sql = "SELECT asi_fecha FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                              $query = mysqli_query($db_conx, $sql);
                              $row = mysqli_fetch_array($query);
                              echo '' . $row[0];
                              ?></span>
                          </td>
                          <td style="width: 100px;">
                            <h5>Sala:</h5>
                            <span id="sala">
                              <?php
                              $sql = "SELECT tra_sala FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                              $query = mysqli_query($db_conx, $sql);
                              $row = mysqli_fetch_array($query);
                              echo '' . $row[0];
                              ?></span>
                          </td>  
                          <td style="width: 100px;">
                            <h5>Cama:</h5>
                            <span id="sala">
                              <?php
                              $sql = "SELECT tra_cama FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                              $query = mysqli_query($db_conx, $sql);
                              $row = mysqli_fetch_array($query);
                              echo '' . $row[0];
                              ?></span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>Observaciónes:</h5>                      
                      <span id="observacion-anterior">
                        <?php
                        $sql = "SELECT tra_observ FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                        $query = mysqli_query($db_conx, $sql);
                        $row = mysqli_fetch_array($query);
                        echo '' . $row[0];
                        ?></span>

                    </td>
                  </tr>
                </table>
              <?php } else { ?>
                <table class="tr-data">
                  <tr>
                    <td style="width: 60%;">
                      <h5>Médico:</h5>
                      <span id="medicoref">
                        <?php
                        $sql = "SELECT mer_pape, mer_sape, mer_pnom, mer_snom FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                        $query = mysqli_query($db_conx, $sql);
                        $row = mysqli_fetch_array($query);
                        echo '' . $row[0] . ' ' . $row[1] . ' ' . $row[2] . ' ' . $row[3];
                        ?>
                      </span>
                    </td>
                  </tr><tr>
                    <td>
                      <table>
                        <tr>
                          <td style="width: 200px;">                      
                            <h5>Fecha de atención:</h5>
                            <span id="fecha-confirmado">
                              <?php
                              $sql = "SELECT asi_fecha FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                              $query = mysqli_query($db_conx, $sql);
                              $row = mysqli_fetch_array($query);
                              echo '' . $row[0];
                              ?>
                            </span>
                          </td>
                          <td style="width: 100px;">
                            <h5>Sala:</h5>
                            <span id="sala">
                              <?php
                              $sql = "SELECT tra_sala FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                              $query = mysqli_query($db_conx, $sql);
                              $row = mysqli_fetch_array($query);
                              echo '- ' . $row[0];
                              ?>
                            </span>
                          </td>  
                          <td style="width: 100px;">
                            <h5>Cama:</h5>
                            <span id="sala">
                              <?php
                              $sql = "SELECT tra_cama FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                              $query = mysqli_query($db_conx, $sql);
                              $row = mysqli_fetch_array($query);
                              echo '- ' . $row[0];
                              ?>
                            </span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>Observaciones:</h5>                      
                      <span id="observacion-anterior">
                        <?php
                        $sql = "SELECT tra_observ FROM vtramitexmedicoref WHERE tra_codigo =" . $_GET['cod_tramite'];
                        $query = mysqli_query($db_conx, $sql);
                        $row = mysqli_fetch_array($query);
                        echo '' . $row[0];
                        ?>
                      </span>
                    </td>
                  </tr>
                </table>
              <?php } ?>
              <?php if (!isTramiteCanceled($db_conx, $_GET['cod_tramite']) && !isTramiteAtendido($db_conx, $_GET['cod_tramite'])) { ?>
                <table><tr class="custom-row1" style="float: left; margin-left: 350px;"><td>                    
                    <td><a class="a-button" id="cancelTramite" >CANCELAR TRAMITE...</a></td>
                  </tr><tr class="custom-row2" style="display: none; margin-left: 300px; border: 3px dotted red;float: left;padding: 18px;">
                    <td><span id="status">El trámite se cancelará de forma permanente,<br>¿Desea continuar con la cancelación del trámite?</span></td>
                    <td style="float: left;margin-left: 90px;margin-top: 20px;"><a class="a-button" id="cancelTramiteSi" >SI</a></td>
                    <td style="float: left;margin-top: 20px;"><a class="a-button" id="cancelTramiteNo" >NO</a></td>
                  </tr>
                </table>
              <?php } ?>
            </form>
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>