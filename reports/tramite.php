<?php
include_once("../php_includes/db_conx.php");
include_once("../functions.php");
include_once("../functions2.php");

include_once("../php_includes/check_login_status.php");

if ($user_ok == FALSE) {
  header("location: ../inicio.php");
  exit();
}

if(isset($_GET['cod'])){
  $info = tramite_get_full_info($db_conx, $_GET['cod']);
} else {
  header("location: ../inicio.php");
  exit();
}
$a = 0;
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
        <div class="table-tramite"> 

          <!-- PRIMER BLOQUE -->
          <table>
            <tr>
              <td>
                <table>
                  <tr>
                    <td class="custom_header">
                      <span>REFERENCIA</span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table>
                  <tr>
                    <td>
                      <table>                        
                        <tr>
                          <td>
                            <span>INSTITUCION DEL SISTEMA</span>                      
                          </td>
                          <td>
                            <span>UNIDAD OPERATIVA</span>                      
                          </td>
                          <td>
                            <span>COD. UO.</span>                      
                          </td>
                          <td>
                            <span>COD. LOCALIZACION</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="info institucion">Hospital San Vicente de Paúl.</span>
                          </td>
                          <td>
                            <span class="info institucion"><?php print $info->unidad;?></span>                            
                          </td>
                          <td>
                            X
                          </td>
                          <td>
                            <table>
                              <tr>
                                <td>
                                  <span>PARROQUIA</span>
                                </td>
                                <td>
                                  <span>CANTON</span>
                                </td>
                                <td>
                                  <span>PROVINCIA</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="info institucion"><?php print $info->parroquia;?></span>
                                </td>
                                <td>
                                  <span class="info institucion"><?php print $info->canton;?></span>
                                </td>
                                <td>
                                  <span class="info institucion"><?php print $info->provincia;?></span>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>                       
                      </table>
                    </td>
                    <td>
                      <table style="margin-bottom: -8px;">
                        <tr>
                          <td>
                            <span>NUMERO DE HISTORIA CLINICA</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="info institucion"><?php print $info->hc;?></span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>                
                <table>
                  <tr>
                    <td>
                      <span>APELLIDO PATERNO</span>
                    </td>           
                    <td>
                      <span>APELLIDO MATERNO</span>
                    </td>           
                    <td>
                      <span>PRIMER NOMBRE</span>
                    </td>           
                    <td>
                      <span>SEGUNDO NOMBRE</span>
                    </td>           
                    <td>
                      <span>CEDULA DE CIUDADANIA</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="info institucion"><?php print $info->pape;?></span>
                    </td>           
                    <td>
                      <span class="info institucion"><?php print $info->sape;?></span>
                    </td>           
                    <td>
                      <span class="info institucion"><?php print $info->pnom;?></span>
                    </td>           
                    <td>
                      <span class="info institucion"><?php print $info->snom;?></span>
                    </td>           
                    <td>
                      <span class="info institucion"><?php print $info->cedula;?></span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>              
              <td>
                <table>
                  <tr>
                    <td>
                      <table style="margin-bottom: -8px;">
                        <tr>
                          <td>
                            <span>FECHA DE REFERENCIA</span>
                          </td>
                          <td>
                            <span>HORA</span>
                          </td>
                          <td>
                            <span>EDAD</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="info institucion"><?php print $info->fecha;?></span>
                          </td>
                          <td>
                            <span class="info institucion"><?php print $info->hora;?></span>
                          </td>
                          <td>
                            <span class="info institucion"><?php print $info->edad;?></span>
                          </td>
                        </tr>                  
                      </table>                  
                    </td>
                    <td>
                      <table>
                        <tr>
                          <td>
                            <span>GENERO</span>
                          </td>
                          <td>
                            <span>ESTADO CIVIL</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <table>
                              <tr>
                                <td>
                                  <span>M</span>
                                </td>
                                <td>
                                  <span>F</span>
                                </td>
                              </tr>
                              <tr>
                                <td>                                  
                                  <span><?php if ($info->genero == 'masculino'){ print 'X';}?></span>                                  
                                </td>
                                <td>
                                  <span><?php if ($info->genero == 'femenino'){ print 'X';}?></span>
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                              <tr>
                                <td>
                                  <span>SOL</span>
                                </td>
                                <td>
                                  <span>CAS</span>
                                </td>
                                <td>
                                  <span>DIV</span>
                                </td>
                                <td>
                                  <span>VIU</span>
                                </td>
                                <td>
                                  <span>U-L</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span><?php if ($info->est_civil == 'soltero'){ print 'X';}?></span>
                                </td>
                                <td>
                                  <span><?php if ($info->est_civil == 'casado'){ print 'X';}?></span>
                                </td>
                                <td>
                                  <span><?php if ($info->est_civil == 'divorciado'){ print 'X';}?></span>
                                </td>
                                <td>
                                  <span><?php if ($info->est_civil == 'viudo'){ print 'X';}?></span>
                                </td>
                                <td>
                                  <span><?php if ($info->est_civil == 'unionlibre'){ print 'X';}?></span>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td>
                      <table style="margin-bottom: -8px;">
                        <tr>
                          <td>
                            <span>INSTRUCCION</span>
                          </td>
                          <td>
                            <span>EMPRESA</span>
                          </td>
                          <td>
                            <span>SEGURO</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="info"><?php print $info->instruccion;?></span>
                          </td>
                          <td>
                            <span class="info"><?php print $info->empresa;?></span>
                          </td>
                          <td>
                            <span class="info"><?php print $info->seguro;?></span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          <!-- SEGUNDO BLOQUE -->
          <table>
            <tr>
              <td>
                <span>ESTABLECIMIENTO AL QUE SE ENVIA LA REFERENCIA</span>
              </td>
              <td>
                <span class="info">HSVP</span>
              </td>
              <td>
                <span>SERVICIO AL QUE SE REFIERE</span>
              </td>
              <td>
                <span class="info"><?php print $info->servicio;?></span>
              </td>
            </tr>            
          </table>

          <!-- TERCER BLOQUE -->
          <table>
            <tr>
              <td>
                <span>1 MOTIVO DE REFERENCIA</span>
              </td>
            </tr>
            <tr>
              <td>
                <span class="info"><?php print $info->motivo;?></span>
              </td>
            </tr>
            <tr>
              <td>
                <span>2 RESUMEN DEL CUADRO CLINICO</span>
              </td>
            </tr>
            <tr>
              <td>
                <span class="info institucion"><?php print $info->resumen;?></span>
              </td>
            </tr>
            <tr>
              <td>
                <span>3 HALLAZGOS RELEVANTES DE EXAMENES Y PROCEDIMIENTOS DIAGNOSTICOS</span>
              </td>
            </tr>
            <tr>
              <td>
                <span class="info institucion"><?php print $info->hallazgo;?></span>
              </td>
            </tr>
          </table>

          <!-- CUARTO BLOQUE -->
          <table>
            <tr>
              <td>
                <span>4 DIAGNOSTICO</span><span>   pre = presuntivo - def = definitivo.</span>
              </td>
            </tr>
            <tr>
              <td>
                <?php print $info->diagnostico;?>
              </td>
            </tr>
          </table>

          <!-- QUINTO BLOQUE -->
          <table>
            <tr>
              <td>
                <span>5 PLAN DE TRATAMIENTO REALIZADO</span>
              </td>
            </tr>
            <tr>
              <td>
                <span class="info institucion"><?php print $info->tratamiento;?></span>
              </td>
            </tr>
          </table>

          <!-- SEXTO BLOQUE -->
          <table>
            <tr>
              <td>
                <table>
                  <tr>
                    <td>
                      <span>SALA</span>
                    </td>
                    <td>
                      <span class="info"><?php print $info->sala;?></span>
                    </td>
                    <td>
                      <span>CAMA</span>
                    </td>
                    <td>
                      <span class="info"><?php print $info->cama;?></span>
                    </td>
                    <td>
                      <span>MEDICO</span>
                    </td>
                    <td>
                      <span class="info"><?php print $info->medref;?></span>
                    </td>
                    <td>
                      <span>FIRMA</span>
                    </td>
                    <td>
                      _____
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table>
                  <tr>
                    <td>
                      <span>SNS MSP / HCU - form 053 / 2008</span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>          

        </div>


        <!-- CONTRAREFERENCIA -->
        <div class="table-tramite"> 

          <!-- PRIMER BLOQUE -->
          <table>
            <tr>
              <td>
                <table>
                  <tr>
                    <td class="custom_header">
                      <span>CONTRAREFERENCIA</span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table>
                  <tr>
                    <td>
                      <table>                        
                        <tr>
                          <td>
                            <span>INSTITUCION DEL SISTEMA</span>                      
                          </td>
                          <td>
                            <span>UNIDAD OPERATIVA</span>                      
                          </td>
                          <td>
                            <span>COD. UO.</span>                      
                          </td>
                          <td>
                            <span>COD. LOCALIZACION</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="info institucion">Hospital San Vicente de Paúl.</span>
                          </td>
                          <td>
                            <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->unidad:'-' ;?></span>                            
                          </td>
                          <td>
                            X
                          </td>
                          <td>
                            <table>
                              <tr>
                                <td>
                                  <span>PARROQUIA</span>
                                </td>
                                <td>
                                  <span>CANTON</span>
                                </td>
                                <td>
                                  <span>PROVINCIA</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->parroquia:'-';?></span>
                                </td>
                                <td>
                                  <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->canton:'-';?></span>
                                </td>
                                <td>
                                  <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->provincia:'-';?></span>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>                       
                      </table>
                    </td>
                    <td>
                      <table style="margin-bottom: -8px;">
                        <tr>
                          <td>
                            <span>NUMERO DE HISTORIA CLINICA</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->hc:'-';?></span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>                
                <table>
                  <tr>
                    <td>
                      <span>APELLIDO PATERNO</span>
                    </td>           
                    <td>
                      <span>APELLIDO MATERNO</span>
                    </td>           
                    <td>
                      <span>PRIMER NOMBRE</span>
                    </td>           
                    <td>
                      <span>SEGUNDO NOMBRE</span>
                    </td>           
                    <td>
                      <span>CEDULA DE CIUDADANIA</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->pape:'-';?></span>
                    </td>           
                    <td>
                      <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->sape:'-';?></span>
                    </td>           
                    <td>
                      <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->pnom:'-';?></span>
                    </td>           
                    <td>
                      <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->snom:'-';?></span>
                    </td>           
                    <td>
                      <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->cedula:'-';?></span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>              
              <td>
                <table>
                  <tr>
                    <td>
                      <table style="margin-bottom: -8px;">
                        <tr>
                          <td>
                            <span>FECHA DE REFERENCIA</span>
                          </td>
                          <td>
                            <span>HORA</span>
                          </td>
                          <td>
                            <span>EDAD</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->fecha:'-';?></span>
                          </td>
                          <td>
                            <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->hora:'-';?></span>
                          </td>
                          <td>
                            <span class="info institucion"><?php print ($info->tipo == 'contrareferencia')?$info->edad:'-';?></span>
                          </td>
                        </tr>                  
                      </table>                  
                    </td>
                    <td>
                      <table>
                        <tr>
                          <td>
                            <span>GENERO</span>
                          </td>
                          <td>
                            <span>ESTADO CIVIL</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <table>
                              <tr>
                                <td>
                                  <span>M</span>
                                </td>
                                <td>
                                  <span>F</span>
                                </td>
                              </tr>
                              <tr>
                                <td>                                  
                                  <span><?php if ($info->genero == 'masculino'){ print ($info->tipo == 'contrareferencia')?'X':'';}?></span>                                  
                                </td>
                                <td>
                                  <span><?php if ($info->genero == 'femenino'){ print ($info->tipo == 'contrareferencia')?'X':'';}?></span>
                                </td>
                              </tr>
                            </table>
                          </td>
                          <td>
                            <table>
                              <tr>
                                <td>
                                  <span>SOL</span>
                                </td>
                                <td>
                                  <span>CAS</span>
                                </td>
                                <td>
                                  <span>DIV</span>
                                </td>
                                <td>
                                  <span>VIU</span>
                                </td>
                                <td>
                                  <span>U-L</span>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <span><?php if ($info->est_civil == 'soltero'){ ($info->tipo == 'contrareferencia')?print 'X':'';}?></span>
                                </td>
                                <td>
                                  <span><?php if ($info->est_civil == 'casado'){ print ($info->tipo == 'contrareferencia')?'X':'';}?></span>
                                </td>
                                <td>
                                  <span><?php if ($info->est_civil == 'divorciado'){ print ($info->tipo == 'contrareferencia')?'X':'';}?></span>
                                </td>
                                <td>
                                  <span><?php if ($info->est_civil == 'viudo'){ print ($info->tipo == 'contrareferencia')?'X':'';}?></span>
                                </td>
                                <td>
                                  <span><?php if ($info->est_civil == 'unionlibre'){ print ($info->tipo == 'contrareferencia')?'X':'';}?></span>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td>
                      <table style="margin-bottom: -8px;">
                        <tr>
                          <td>
                            <span>INSTRUCCION</span>
                          </td>
                          <td>
                            <span>EMPRESA</span>
                          </td>
                          <td>
                            <span>SEGURO</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span class="info"><?php print ($info->tipo == 'contrareferencia')?$info->instruccion:'-';?></span>
                          </td>
                          <td>
                            <span class="info"><?php print ($info->tipo == 'contrareferencia')?$info->empresa:'-';?></span>
                          </td>
                          <td>
                            <span class="info"><?php print ($info->tipo == 'contrareferencia')?$info->seguro:'-';?></span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          <!-- SEGUNDO BLOQUE -->
          <table>
            <tr>
              <td>
                <span>ESTABLECIMIENTO AL QUE SE ENVIA LA CONTRAREFERENCIA</span>
              </td>
              <td>
                <span class="info"><?php print ($info->tipo == 'contrareferencia')?$info->unidad:'-';?></span>
              </td>
              <td>
                <span>SERVICIO QUE CONTRAREFIERE</span>
              </td>
              <td>
                <span class="info">(Ver Plan de tratamiento recomendado.)</span>
              </td>
            </tr>            
          </table>

          <!-- TERCER BLOQUE -->
          <table>
            <tr>
              <td>
                <span>1 MOTIVO DEL CUADRO CLINICO</span>
              </td>
            </tr>
            <tr>
              <td>
                X
              </td>
            </tr>
            <tr>
              <td>
                <span>2 HALLAZGOS RELEVANTES DE EXAMENES Y PROCEDIMIENTOS DIAGNOSTICOS</span>
              </td>
            </tr>
            <tr>
              <td>
                X
              </td>
            </tr>
            <tr>
              <td>
                <span>3 TRATAMIENTO Y PROCEDIMIENTOS TERAPEUTICOS REALIZADOS</span>
              </td>
            </tr>
            <tr>
              <td>
                X
              </td>
            </tr>
          </table>

          <!-- CUARTO BLOQUE -->
          <table>
            <tr>
              <td>
                <span>4 DIAGNOSTICO</span><span>   (Ver observaciones en Plan de tratamiento recomendado).</span>
              </td>
            </tr>
            <tr>
              <td>                
                  <?php print ($info->tipo == 'contrareferencia')?$info->diagnostico:'';?>                
              </td>
            </tr>
          </table>

          <!-- QUINTO BLOQUE -->
          <table>
            <tr>
              <td>
                <span>5 PLAN DE TRATAMIENTO RECOMENDADO</span>
              </td>
            </tr>
            <tr>
              <td>
                <span class="info"><?php print ($info->tipo == 'contrareferencia')?$info->observacion:'-';?></span>
              </td>
            </tr>
          </table>

          <!-- SEXTO BLOQUE -->
          <table>
            <tr>
              <td>
                <table>
                  <tr>
                    <td>
                      <span>SALA</span>
                    </td>
                    <td>
                      <span class="info"><?php print ($info->tipo == 'contrareferencia')?$info->sala:'-';?></span>
                    </td>
                    <td>
                      <span>CAMA</span>
                    </td>
                    <td>
                      <span class="info"><?php print ($info->tipo == 'contrareferencia')?$info->cama:'-';?></span>
                    </td>
                    <td>
                      <span>MEDICO</span>
                    </td>
                    <td>
                      <span class="info"><?php print ($info->tipo == 'contrareferencia')?$info->medref:'-';?></span>
                    </td>
                    <td>
                      <span>FIRMA</span>
                    </td>
                    <td>
                      _____
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table> 
                  <tr>
                    <td>
                      <span>SNS MSP / HCU - form 053 / 2008</span>
                    </td>
                    <td>
                      <span>REFERENCIA JUSTIFICADA</span>
                    </td>
                    <td>
                      <span>SI</span>
                    </td>
                    <td>
                      _______
                    </td>
                    <td>
                      <span>NO</span>
                    </td>
                    <td>
                      _______
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>          
        </div>
      </div>
    </div>
  </body>
</html>