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
        <div class="table-tramite"> 

          <!-- PRIMER BLOQUE -->
          <table>
            <tr>
              <td>
                <table>
                  <tr>
                    <td>
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
                            <span>COD. LOC.</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            X
                          </td>
                          <td>
                            X
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
                                  X
                                </td>
                                <td>
                                  X
                                </td>
                                <td>
                                  X
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>                       
                      </table>
                    </td>
                    <td>
                      <table>
                        <tr>
                          <td>
                            <span>NUMERO DE HISTORIA CLINICA</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            X
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
                      X
                    </td>           
                    <td>
                      X
                    </td>           
                    <td>
                      X
                    </td>           
                    <td>
                      X
                    </td>           
                    <td>
                      X
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
                            X
                          </td>
                          <td>
                            X
                          </td>
                          <td>
                            X
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
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
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
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td>
                      <table>
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
                            X
                          </td>
                          <td>
                            X
                          </td>
                          <td>
                            X
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
                X
              </td>
              <td>
                <span>SERVICIO AL QUE SE REFIERE</span>
              </td>
              <td>
                X
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
                X
              </td>
            </tr>
            <tr>
              <td>
                <span>2 RESUMEN DEL CUADRO CLINICO</span>
              </td>
            </tr>
            <tr>
              <td>
                X
              </td>
            </tr>
            <tr>
              <td>
                <span>3 HALLAZGOS RELEVANTES DE EXAMENES Y PROCEDIMIENTOS DIAGNOSTICOS</span>
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
                <span>4 DIAGNOSTICO</span><span>pre = presuntivo - def = definitivo.</span>
              </td>
            </tr>
            <tr>
              <td>
                <table>
                  <!-- AQUI SE DESPLIEGA EL CUADRO DE DIAGNOSTICO -->
                </table>
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
                X
              </td>
            </tr>
          </table>

          <!-- SEXTO BLOQUE -->
          <table>
            <tr>
              <td>
                <span>SALA</span>
              </td>
              <td>
                X
              </td>
              <td>
                <span>CAMA</span>
              </td>
              <td>
                X
              </td>
              <td>
                <span>MEDICO</span>
              </td>
              <td>
                X
              </td>
              <td>
                <span>FIRMA</span>
              </td>
              <td>
                X
              </td>
            </tr>
            <tr>
              <td>
                <span>SNS MSP / HCU - form 053 / 2008</span>
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
                    <td>
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
                            <span>COD. LOC.</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            X
                          </td>
                          <td>
                            X
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
                                  X
                                </td>
                                <td>
                                  X
                                </td>
                                <td>
                                  X
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>                       
                      </table>
                    </td>
                    <td>
                      <table>
                        <tr>
                          <td>
                            <span>NUMERO DE HISTORIA CLINICA</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            X
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
                      X
                    </td>           
                    <td>
                      X
                    </td>           
                    <td>
                      X
                    </td>           
                    <td>
                      X
                    </td>           
                    <td>
                      X
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
                            X
                          </td>
                          <td>
                            X
                          </td>
                          <td>
                            X
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
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
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
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
                                </td>
                                <td>
                                  <span>X</span>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td>
                      <table>
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
                            X
                          </td>
                          <td>
                            X
                          </td>
                          <td>
                            X
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
                X
              </td>
              <td>
                <span>SERVICIO QUE CONTRAREFIERE</span>
              </td>
              <td>
                X
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
                <span>4 DIAGNOSTICO</span><span>def = definitivo.</span>
              </td>
            </tr>
            <tr>
              <td>
                <table>
                  <!-- AQUI SE DESPLIEGA EL CUADRO DE DIAGNOSTICO -->
                </table>
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
                X
              </td>
            </tr>
          </table>

          <!-- SEXTO BLOQUE -->
          <table>
            <tr>

              <td>
                <span>SALA</span>
              </td>
              <td>
                X
              </td>
              <td>
                <span>CAMA</span>
              </td>
              <td>
                X
              </td>
              <td>
                <span>MEDICO</span>
              </td>
              <td>
                X
              </td>
              <td>
                <span>FIRMA</span>
              </td>
              <td>
                X
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
                      X
                    </td>
                    <td>
                      <span>NO</span>
                    </td>
                    <td>
                      X
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