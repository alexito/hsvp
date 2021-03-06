<?php

function existeServicio($db_conx, $d){
  $sql = "SELECT ser_descrip FROM vreferenciaservicio WHERE ser_descrip LIKE '%$d%'";
  $query = mysqli_query($db_conx, $sql);
  $existe = '0';
  while($row = mysqli_fetch_array($query)){    
    if(strtolower($d) == strtolower($row[0])){
      $existe = '1';
      break;
    }
  }
  echo $existe;
}

function tramite_get_full_info($db_conx, $cod) {
  $info = new stdClass();

  //datos del tramite
  $sql = "SELECT * FROM ttramite WHERE TRA_CODIGO = $cod";
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);

  $info->codigo = $row['TRA_CODIGO'];
  $info->estado = $row['TRA_ESTADO'];
  $info->pac_codigo = $row['PAC_CODIGO'];
  $info->unm_codigo = $row['UNM_CODIGO'];
  $cFecha = explode(' ', $row['TRA_FECHA']);
  $info->fecha = $cFecha[0];
  $info->hora = $cFecha[1];
  $info->motivo = $row['TRA_MOTIVO'];
  $info->resumen = $row['TRA_RESUM_CUAD_CLIN'];
  $info->hallazgo = $row['TRA_HALL_EXM_PROC_DIAG'];
  $info->tratamiento = $row['TRA_PLAN_TRAT'];
  $info->sala = $row['TRA_SALA'];
  $info->cama = $row['TRA_CAMA'];
  $info->tipo = $row['TRA_TIPO'];
  $info->activo = $row['TRA_ACTIVO'];
  $info->justificado = $row['TRA_JUSTIF'];
  $info->observacion = $row['TRA_OBSERV'];
  $info->res_codigo = $row['RES_CODIGO'];

  $sql = "SELECT uni_codigo FROM tunidadmedico WHERE unm_codigo = $info->unm_codigo";
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);

  $sql = "SELECT * FROM tunidad WHERE uni_codigo = " . $row['uni_codigo'];
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);

  $info->unidad = $row['UNI_DESCRIP'];

  $sql = "SELECT * FROM tlocalizacion WHERE loc_codigo = " . $row['LOC_CODIGO'];
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);

  $info->parroquia = $row['LOC_CPARR'];
  $info->canton = $row['LOC_CCAN'];
  $info->provincia = $row['LOC_CPRO'];

  $sql = "SELECT * FROM tpaciente WHERE pac_codigo = " . $info->pac_codigo;
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);

  $info->cedula = $row['PAC_CEDULA'];
  $info->pape = $row['PAC_PAPE'];
  $info->sape = $row['PAC_SAPE'];
  $info->pnom = $row['PAC_PNOM'];
  $info->snom = $row['PAC_SNOM'];
  $info->genero = $row['PAC_GENERO'];
  $info->est_civil = $row['PAC_EST_CIV'];
  $info->instruccion = $row['PAC_INSTRUC'];
  $info->hc = $row['PAC_HC'];
  $info->edad = CalculaEdad($row['PAC_FCH_NAC']);
  $info->emp_codigo = (isset($row['EMP_CODIGO'])) ? $row['EMP_CODIGO'] : 0;
  $info->seg_codigo = (isset($row['SEG_CODIGO'])) ? $row['SEG_CODIGO'] : 0;

  if ($info->seg_codigo != 0) {
    $sql = "SELECT * FROM tseguros WHERE seg_codigo = " . $row['SEG_CODIGO'];
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_array($query);
    if ($row) {
      $info->seguro = $row['SEG_DESCRIP'];
    }
  } else {
    $info->seguro = '-';
  }

  if ($info->emp_codigo != 0) {
    $sql = "SELECT * FROM tempresas WHERE emp_codigo = " . $info->emp_codigo;
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_array($query);
    if ($row) {
      $info->empresa = $row['EMP_DESCRIP'];
    }
  } else {
    $info->empresa = '-';
  }

  $sql = "SELECT * FROM tasignacion WHERE tra_codigo = " . $cod;
  $query = mysqli_query($db_conx, $sql);

  if ($query) {
    $row = mysqli_fetch_array($query);

    $sql = "SELECT * FROM tmedicoxservicio WHERE mes_codigo = " . $row['MES_CODIGO'];
    $query = mysqli_query($db_conx, $sql);
    if ($query) {
      $row = mysqli_fetch_array($query);

      $sql = "SELECT * FROM tmedicoreferenciado WHERE mer_codigo = " . $row['MER_CODIGO'];
      $query = mysqli_query($db_conx, $sql);
      $row = mysqli_fetch_array($query);

      $info->medref = $row['MER_PAPE'] . ' ' . $row['MER_SAPE'] . ' ' . $row['MER_PNOM'] . ' ' . $row['MER_SNOM'];
    } else {
      $info->medref = '-';
    }
    $sql = "SELECT * FROM trefservicios WHERE res_codigo = " . $info->res_codigo;
    $query = mysqli_query($db_conx, $sql);
    if ($query) {
      $row = mysqli_fetch_array($query);

      $sql = "SELECT * FROM tservicios WHERE ser_codigo = " . $row['SER_CODIGO'];
      $query = mysqli_query($db_conx, $sql);
      $row = mysqli_fetch_array($query);

      $info->servicio = $row['SER_DESCRIP'];
    } else {
      $info->servicio = '-';
    }
  }

  //Diagnostico SIE10

  $sql = "SELECT * FROM tdiagsie10 WHERE tra_codigo = " . $cod;
  $query = mysqli_query($db_conx, $sql);
  
  $c = 1;
  $info->diagnostico = '<table><tr>
    <td>No.</td>
    <td>Diagnostico</td>
    <td>SIE10</td>
    <td>Estado</td>
    </tr>';
  while ($row = mysqli_fetch_array($query)) {
    $temsql = "SELECT * FROM tsie10 WHERE sie_codigo = " . $row['SIE_CODIGO'];
    $temquery = mysqli_query($db_conx, $temsql);
    $temrow = mysqli_fetch_array($temquery);
    
    $info->diagnostico .= '<tr><td>' . $c++ . '</td><td><span class="info">' . $temrow['SIE_DESCRIP'] . '</span></td>';
    $info->diagnostico .= '<td><span class="info">' . $temrow['SIE_CODIF'] . '</span></td>';
    $info->diagnostico .= '<td><span class="info">' . $row['DIA_DIAGNOS'] . '</span></td></tr>';
        
  }
  $info->diagnostico .= '</table>';

  return $info;
}

function CalculaEdad($fecha) {
  list($Y, $m, $d) = explode("-", $fecha);
  return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}

function SelectValuesMedicoServicio($db_conx, $tra_codigo) {
  $data = '<select style="width:400px;" size="10" class="cmbmedicoservicio" id="cmbmedicoservicio">';

  $sql = "SELECT res_codigo FROM ttramite WHERE tra_codigo =" . $tra_codigo;
  $query = mysqli_query($db_conx, $sql);

  if ($query->num_rows > 0) {
    $row = mysqli_fetch_array($query);

    $sql = "SELECT mes_codigo, mer_pape, mer_sape, mer_pnom, mer_snom FROM vmedicoxservicio WHERE res_codigo = $row[0]";
    $query = mysqli_query($db_conx, $sql);

    $n_filas = $query->num_rows;

    $c = 0;
    while ($c < $n_filas) {
      $row = mysqli_fetch_array($query);
      $data .= '<option value="' . $row[0] . '">' . $row[1] . ' ' . $row[2] . ' ' . $row[3] . ' ' . $row[4] . '</option>';
      $c++;
    }
  }
  $data .= '</select>';
  echo $data;
}

function SelectReferenciasUnidad($db_conx, $codmed, $query = NULL) {
  if ($query == NULL) {
    $sql = "SELECT * FROM vreferencias_uni WHERE MED_CODIGO = $codmed";
    $query = mysqli_query($db_conx, $sql);
  }

  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>Nro. Trámite</td>
            <td>Fecha</td>
            <td>Cédula</td>
            <td>Nombre Completo</td>            
            <td>Motivo</td>
            <td>Servicio</td>
            <td>Estado / Tipo</td>
            <td id="custom-action">Accion</td>
        </tr>';
  $ban = FALSE;
  while ($row = mysqli_fetch_array($query)) {
    $ban = TRUE;
    $data .= '<tr class="row_data">';
    for ($i = 1; $i < $n_columnas; $i++) {
      if ($i == 4) {
        $data .= "<td><span>$row[$i] $row[5]<br>$row[6] $row[7]</span></td>";
        $data .= "<td><span>" . customSubstring($row[8], 50) . "</span></td>";
        $i = 9;
      }
      $data .= "<td><span>$row[$i]</span></td>";
      if ($i + 3 == $n_columnas) {
        $data .= "<td><span>" . $row[$i + 1] . "<br/>" . $row[$i + 2] . "</span></td>";
        break;
      }
    }
    $data .= '<td id="custom-action"><a target="_blank" href="ver_referencias_uni.php?cod_tramite=' . $row[1] . '"><img class="tra-icons" src="images/edit-tra.png"/></a></br>';
    $data .= '<a target="_blank" href="reports/tramite.php?cod=' . $row[1] . '"><img class="tra-icons" src="images/view-tra.png"/></a></td></tr>';
  }
  if ($ban) {
    echo $data;
  } else {
    echo '<h3>No se encontraron resultados, por favor intente con otros datos.</h3>';
  }
}

function SelectReferenciasHospital($db_conx, $query = null) {
  if ($query == null) {
    $sql = "SELECT * FROM vreferencias_uni WHERE tra_estado = 'pendiente' ORDER BY tra_fecha ASC LIMIT 20";
    $query = mysqli_query($db_conx, $sql);
  }

  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>Nro. Tra.</td>
            <td>Fecha</td>
            <td>Cédula</td>
            <td>Nombre Completo</td>            
            <td>Motivo</td>
            <td>Servicio</td>
            <td>Estado / Tipo</td>
            <td id="custom-action">Accion</td>
        </tr>';
  $c = 0;
  $ban = FALSE;
  while ($row = mysqli_fetch_array($query)) {
    $ban = TRUE;
    $data .= '<tr class="row_data">';
    for ($i = 1; $i < $n_columnas; $i++) {
      if ($i == 4) {
        $data .= "<td><span>$row[$i] $row[5]<br>$row[6] $row[7]</span></td>";
        $data .= "<td><span>" . customSubstring($row[8], 50) . "</span></td>";
        $i = 9;
      }
      $data .= "<td><span>$row[$i]</span></td>";
      if ($i + 3 == $n_columnas) {
        $data .= "<td><span>" . $row[$i + 1] . "<br/>" . $row[$i + 2] . "</span></td>";
        break;
      }
    }
    $data .= '<td id="custom-action"><a target="_blank" href="ver_referencias_hos.php?cod_tramite=' . $row[1] . '"><img class="tra-icons" src="images/edit-tra.png"/></a>';
    $data .= '<a target="_blank" href="reports/tramite.php?cod=' . $row[1] . '"><img class="tra-icons" src="images/view-tra.png"/></a></td></tr>';
  }
  if ($ban) {
    echo $data;
  } else {
    echo '<h3>No se encontraron resultados, por favor intente con otros datos.</h3>';
  }
}

function isTramiteContrareferencia($db_conx, $tra_codigo) {
  $sql = "SELECT * FROM ttramite WHERE tra_codigo =  $tra_codigo AND tra_tipo = 'contrareferencia'";
  $query = mysqli_query($db_conx, $sql);
  if ($query->num_rows > 0) {
    return TRUE;
  }
  return FALSE;
}

function isTramiteConfirmado($db_conx, $tra_codigo) {
  $sql = "SELECT * FROM ttramite WHERE tra_codigo =  $tra_codigo AND tra_estado = 'confirmado'";
  $query = mysqli_query($db_conx, $sql);
  if ($query->num_rows > 0) {
    return TRUE;
  }
  return FALSE;
}

function isTramitePendiente($db_conx, $tra_codigo) {
  $sql = "SELECT * FROM ttramite WHERE tra_codigo =  $tra_codigo AND tra_estado = 'pendiente'";
  $query = mysqli_query($db_conx, $sql);
  if ($query->num_rows > 0) {
    return TRUE;
  }
  return FALSE;
}

function isTramiteAtendido($db_conx, $tra_codigo) {
  $sql = "SELECT * FROM ttramite WHERE tra_codigo =  $tra_codigo AND tra_estado = 'atendido'";
  $query = mysqli_query($db_conx, $sql);
  if ($query->num_rows > 0) {
    return TRUE;
  }
  return FALSE;
}

function isTramiteCanceled($db_conx, $tra_codigo) {
  $sql = "SELECT * FROM ttramite WHERE tra_codigo =  $tra_codigo AND tra_estado = 'cancelado'";
  $query = mysqli_query($db_conx, $sql);
  if ($query->num_rows > 0) {
    return TRUE;
  }
  return FALSE;
}

function verficarTramitePertenencia($db_conx, $tra_codigo, $med_codigo) {
  $sql = "SELECT unm_codigo FROM ttramite WHERE tra_codigo =" . $tra_codigo;
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $sql = "SELECT * FROM tunidadmedico WHERE med_codigo = $med_codigo AND unm_codigo = " . $row[0];
  $query = mysqli_query($db_conx, $sql);
  if ($query->num_rows > 0) {
    return TRUE;
  }
  return FALSE;
}

function selectTramiteLocalizacion($db_conx, $cod_tra) {
  $sql = "SELECT unm_codigo FROM ttramite WHERE tra_codigo =" . $cod_tra;
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $sql = "SELECT uni_codigo FROM tunidadmedico WHERE unm_codigo =" . $row[0];
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $tem = $row[0];

  $sql = "SELECT uni_descrip FROM tunidad WHERE uni_codigo =" . $row[0];
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);

  $data = '<table><tr>
                  <td>
                    <h5><span class="uni" id="uni">' . $row[0];

  $sql = "SELECT loc_cparr, loc_ccan, loc_cpro FROM vlocalunidad WHERE uni_codigo =" . $tem;
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $data .= '</span></h5>
                  </td>
                </tr><tr class="tr-data">
                  <td><h6>Parroquia:</h6><span id="par">' . $row[0] . '</span></td>
                  <td><h6>Cantón:</h6><span id="can">' . $row[1] . '</span></td>
                  <td><h6>Provincia:</h6><span id="pro">' . $row[2] . '</span></td>
                </tr></table>';
  echo $data;
}

function selectTramiteData($db_conx, $cod_tra) {
  $sql = "SELECT tra_motivo, tra_resum_cuad_clin, tra_hall_exm_proc_diag, tra_plan_trat, tra_fecha, tra_estado, tra_sala, tra_cama, tra_tipo, tra_justif FROM ttramite WHERE tra_codigo =" . $cod_tra;
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $data = '<table><tr>
                  <td>
                    <label style="width: 400px;"><h5>Motivo de Referencia:</h5></label>
                    <span id="motivo_ref">' . $row[0] . '</span>
                  </td>
                </tr><tr>
                  <td>
                    <label style="width: 400px;"><h5>Resumen del Cuadro Clínico:</h5></label>
                    <span id="resumen_ref">' . $row[1] . '</span>
                  </td>
                </tr><tr>
                  <td>
                    <label style="width: 500px;"><h5>Hallazgos relevantes de examenes y procedimientos diagnósticos:</h5></label>
                    <span id="hallazgo_ref">' . $row[2] . '</span>
                  </td>
                </tr><tr class="tr-data">
                  <td>
                    <label style="width: 400px;"><h5>Plan tratamiento realizado:</h5></label>
                    <span id="plan_ref">' . $row[3] . '</span>
                  </td>
                </tr></table><table class="tr-data">
                <tr>
                  <td>
                    <label style="width: 25%;"><h5>Fecha:</h5></label>
                    <span id="fec">' . $row[4] . '</span>
                  </td>
                  <td>
                    <label style="width: 25%;"><h5>Estado:</h5></label>
                    <span id="est">' . $row[5] . '</span>
                  </td>                  
                </tr>
                <tr >
                  <td style="width: 30%;">
                    <label style="width: 25%;"><h5>Tipo:</h5></label>
                    <span id="tip">' . $row[8] . '</span>
                  </td>
                  <td>
                    <label style="width: 25%;"><h5>Justificado:</h5></label>
                    <span id="jus">' . $row[9] . '</span>
                  </td> 
                </tr>
              </table>';
  echo $data;
}

function selectTramiteDiagnostico($db_conx, $cod_tra) {
  $sql = "SELECT dia_diagnos, sie_descrip FROM vtramitesie10 WHERE tra_codigo =" . $cod_tra;
  $query = mysqli_query($db_conx, $sql);
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= "<li>$row[0] | $row[1]</li>";
    $c++;
  }
  echo $data;
}

function selectTramiteServicio($db_conx, $cod_tra) {
  $sql = "SELECT res_codigo FROM ttramite WHERE tra_codigo =" . $cod_tra;
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $sql = "SELECT ser_descrip FROM vreferenciaservicio WHERE res_codigo =" . $row[0];
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  echo $row[0];
}

function getServicioData($db_conx, $cod) {
  $sql = "SELECT ser_descrip FROM tservicios WHERE ser_codigo = '$cod' LIMIT 1";
  $query = mysqli_query($db_conx, $sql);
  $data = '';
  if ($query) {
    $row = mysqli_fetch_array($query);
    $data .= "$row[0]";
  }
  echo $data;
}

function getPacienteData($db_conx, $cod) {
  $sql = "SELECT * FROM tpaciente WHERE pac_cedula = '$cod' OR pac_hc = '$cod' LIMIT 1";
  $query = mysqli_query($db_conx, $sql);
  $data = '';

  if (!$query || $query->num_rows == 0) {
    $sql = "SELECT * FROM tpaciente WHERE pac_codigo = $cod  LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $data = '';
    if (!$query || $query->num_rows == 0) {
      echo $data;
      return;
    }
  }

  if ($query->num_rows > 0) {
    $row = mysqli_fetch_array($query);
    $seg = '-';
    $sqltem = "SELECT seg_descrip FROM tseguros WHERE seg_codigo = $row[1]";
    $querytem = mysqli_query($db_conx, $sqltem);
    if ($querytem) {
      $rowtem = mysqli_fetch_array($querytem);
      $seg = $rowtem[0];
    }
    $emp = '-';
    $sqltem = "SELECT emp_descrip FROM tempresas WHERE emp_codigo = $row[2]";
    $querytem = mysqli_query($db_conx, $sqltem);
    if ($querytem) {
      $rowtem = mysqli_fetch_array($querytem);
      $emp = $rowtem[0];
    }
    $data .= "$row[6],$row[7],$row[4] $row[5],$row[3],$row[8],$row[12],$row[9],$row[10],$row[13],$row[11],$emp,$seg,$row[0]";
  }
  echo $data;
}

function getServicioAutocomplete($db_conx, $ref = 1) {

  $sql = "SELECT ser_codigo, ser_descrip FROM vreferenciaservicio WHERE ref_codigo = $ref ORDER BY ser_descrip ASC";
  $query = mysqli_query($db_conx, $sql);
  $data = '';
  if ($query) {
    $n_filas = $query->num_rows;
    $c = 0;
    while ($c < $n_filas - 1) {
      $row = mysqli_fetch_array($query);
      $data .= "$row[1],$row[0]-";
      $c++;
    }
    if ($n_filas > 0) {
      $row = mysqli_fetch_array($query);
      $data .= "$row[1],$row[0]";
    }
  }
  echo $data;
}

function getPacienteAutocomplete($db_conx) {

  $sql = "SELECT * FROM tpaciente";
  $query = mysqli_query($db_conx, $sql);
  $data = '';
  if ($query) {
    $n_filas = $query->num_rows;
    $c = 0;
    while ($c < $n_filas - 1) {
      $row = mysqli_fetch_array($query);
      $data .= "$row[6] $row[7] $row[4] $row[5] _ $row[3] _ $row[12],$row[0]-";
      $c++;
    }
    if ($n_filas > 0) {
      $row = mysqli_fetch_array($query);
      $data .= "$row[6] $row[7] $row[4] $row[5] _ $row[3] _ $row[12],$row[0]";
    }
  }
  echo $data;
}

function SelectMedicoxUnidadSQL($db_conx, $cod_uni) {
  $sql = "SELECT med_codigo FROM tunidadmedico WHERE uni_codigo = $cod_uni AND unm_activo = 'activo'";
  $query = mysqli_query($db_conx, $sql);
  $n_filas = $query->num_rows;
  $data = '';
  if ($n_filas == 1) {
    $row = mysqli_fetch_array($query);
    $data .= "med_codigo = $row[0]";
  } elseif ($n_filas > 1) {
    $row = mysqli_fetch_array($query);
    $data .= "med_codigo = $row[0]";
    $c = 1;
    while ($c < $n_filas) {
      $row = mysqli_fetch_array($query);
      $data .= " OR med_codigo = $row[0]";
      $c++;
    }
  }
  return $data;
}

/**
 * Select data to display in combobox, specify the table name without the character t
 * @param type $db_conx
 * @param type $table
 */
function SelectValuesUnidadesPerteneceMedico($db_conx, $cod_med) {
  $sql = "SELECT uni_codigo, uni_descrip FROM vunidadmedico WHERE med_codigo = $cod_med ORDER BY uni_descrip ASC";

  $query = mysqli_query($db_conx, $sql);

  $n_filas = $query->num_rows;
  $data = '<select style="width: 400px;" onchange="getLocalizacionData();"';
  if ($n_filas == 1) {
    $data .= 'id="cmbunidad" disabled="true">';
    $row = mysqli_fetch_array($query);
    $data .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
  } else {
    $data .= 'id="cmbunidad">';
    $c = 0;
    while ($c < $n_filas) {
      $row = mysqli_fetch_array($query);
      $data .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
      $c++;
    }
  }
  $data .= '</select">';
  echo $data;
}

function getServicioxMedico($db_conx, $get, $cod) {
  if ($get == "servicios") {
    $sql = "SELECT * FROM tmedicoxservicio WHERE mes_activo = 'activo' AND mer_codigo = " . $cod;
  } else {
    $sql = "SELECT * FROM tmedicoxservicio WHERE mes_activo = 'activo' AND res_codigo = " . $cod;
  }
  $query = mysqli_query($db_conx, $sql);
  $data = '';
  if ($query) {
    $n_filas = $query->num_rows;

    $c = 0;
    while ($c < $n_filas - 1) {
      $row = mysqli_fetch_array($query);
      if ($get == "servicios") {
        $data .= $row[2] . ',';
      } else {
        $data .= $row[1] . ',';
      }
      $c++;
    }
    if ($n_filas > 0) {
      $row = mysqli_fetch_array($query);
      if ($get == "servicios") {
        $data .= $row[2];
      } else {
        $data .= $row[1];
      }
    }
  }
  echo $data;
}

function SelectServicios($db_conx, $query = NULL) {
  if ($query == NULL) {
    $sql = "SELECT * FROM tservicios LIMIT 20";
    $query = mysqli_query($db_conx, $sql);
  }
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Descripcion</td>
            <td>Observacion</td>
            <td>Referenciado</td>            
            <td id="custom-action"></td>
        </tr>';
  while ($row = mysqli_fetch_array($query)) {
    $data .= '<tr class="row_data">';
    for ($i = 0; $i < $n_columnas; $i++) {
      $data .= '<td><span id="td_' . $row[0] . '_' . $i . '">' . $row[$i] . '</span></td>';
    }
    $temsql = "SELECT ref_codigo FROM trefservicios WHERE ser_codigo = $row[0]";
    $temquery = mysqli_query($db_conx, $temsql);
    $temrow = mysqli_fetch_array($temquery);

    $temsql = "SELECT ref_descrip FROM treferenciado WHERE ref_codigo = $temrow[0]";
    $temquery = mysqli_query($db_conx, $temsql);
    $temrow = mysqli_fetch_array($temquery);

    $data .= "<td>$temrow[0]</td>";
    $data .= '<td id="custom-action"><button id="editar" onclick="editServicios(' . $row[0] . ')">Editar</button></td></tr>';
  }
  echo $data;
}

/**
 * Select treferenciado Values to listbox
 * @param type $db_conx
 */
function SelectValuesReferenciado($db_conx) {
  $sql = "SELECT * FROM treferenciado ORDER BY ref_descrip ASC";
  $query = mysqli_query($db_conx, $sql);

  $n_filas = $query->num_rows;
  $data = '<select size="7"  class="cmbreferenciado" id="cmbreferenciado">';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
    $c++;
  }
  $data .= '</select>';
  echo $data;
}

function SelectUsuario($db_conx, $query = NULL) {
  if ($query == NULL) {
    $sql = "SELECT usu_codigo, usu_usuario, usu_tipo, usu_activo, usu_fecha FROM tusuario";
    $query = mysqli_query($db_conx, $sql);
  }
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Usuario</td>
            <td>Tipo</td>
            <td>Activo</td>
            <td>Ultimo Ingreso</td>
            <td id="custom-action"></td>
        </tr>';
  $c = 0;
  while ($row = mysqli_fetch_array($query)) {
    $data .= '<tr class="row_data">';
    $data .= '<td><span id="td_' . $row[0] . '_0">' . $row[0] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_1">' . $row[1] . '</span></td>';
    $data .= '<td><span id="tip_' . $row[0] . '">' . $row[2] . '</span></td>';
    $data .= '<td><span id="act_' . $row[0] . '">' . $row[3] . '</span></td>';
    $data .= '<td><span id="td_fecha">' . $row[4] . '</span></td>';
    $data .= '<td id="custom-action"><button id="editar" onclick="editUsuario(' . $row[0] . ')">Editar</button></td></tr>';
  }
  echo $data;
}

/**
 * Load the updated data in the table
 * @param type $db_conx
 * @param type $n_items
 * @param type $p_actual
 */
function SelectLocalizacion($db_conx, $query = null) {
  if ($query == NULL) {
    $sql = "SELECT * FROM tlocalizacion LIMIT 20";
    $query = mysqli_query($db_conx, $sql);
  }
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Descripcion</td>
            <td>Parroquia</td>
            <td>Canton</td>
            <td>Provincia</td>
            <td id="custom-action"></td>
        </tr>';
  while ($row = mysqli_fetch_array($query)) {
    $data .= '<tr class="row_data">';
    for ($i = 0; $i < $n_columnas; $i++) {
      $data .= '<td><span id="td_' . $row[0] . '_' . $i . '">' . $row[$i] . '</span></td>';
    }
    $data .= '<td id="custom-action"><button id="editar" onclick="editarLocalizacion(' . $row[0] . ')">Editar</button></td></tr>';
  }
  echo $data;
}

/**
 * Load the data for Combobox.
 * @param type $db_conx
 */
function SelectValuesLocalizacion($db_conx) {
  $sql = "SELECT loc_codigo, loc_descrip FROM tlocalizacion ORDER BY loc_descrip ASC";
  $query = mysqli_query($db_conx, $sql);

  $data = '<select class="localizacion" id="cmblocalizacion">
    <option value="">Seleccione...</option>';
  while ($row = mysqli_fetch_array($query)) {
    $data .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';    
  }
  $data .= '</select">';
  echo $data;
}

/**
 * 
 * @param type $db_conx
 */
function SelectValuesLocalizacionArray($db_conx) {
  $sql = "SELECT loc_codigo, loc_descrip FROM tlocalizacion ORDER BY loc_descrip ASC";
  $query = mysqli_query($db_conx, $sql);
  while ($row = mysqli_fetch_array($query)) {
    $data[$row[0]] = $row[1];
  }
  return $data;
}

/**
 * Load the updated data in the table
 * @param type $db_conx
 * @param type $n_items
 * @param type $p_actual
 */
function SelectUnidad($db_conx, $query = null) {

  if ($query == NULL) {
    $sql = "SELECT * FROM vlocalizacionxunidad LIMIT 20";
    $query = mysqli_query($db_conx, $sql);
  }

  $n_columnas = $query->field_count;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Localizacion</td>
            <td>Descripcion</td>
            <td>Observacion</td>
            <td>Activo</td>
            <td id="custom-action"></td>
        </tr>';
  while ($row = mysqli_fetch_array($query)) {
    $data .= '<tr class="row_data">';
    for ($i = 0; $i < $n_columnas - 1; $i++) {
      if ($i == 1) {
        $data .= '<td><input type="hidden" id="cod_loc_' . $row[0] . '" value="' . $row[$n_columnas - 1] . '" /><span style="display:none;" id="td_' . $row[0] . '_' . $i . '">' . $row[$i] . '</span>
          <span>' . $row[$i] . '</span></td>';
      } else {
        $data .= '<td><span id="td_' . $row[0] . '_' . $i . '">' . $row[$i] . '</span></td>';
      }
    }
    $data .= '<td id="custom-action"><button id="editar" onclick="editUnidad(' . $row[0] . ')">Editar</button></td></tr>';
  }
  echo $data;
}

/**
 * Select Values to combobox Unidad displayed in MedicoReferente
 * @param type $db_conx
 */
function SelectValuesUnidad($db_conx) {
  $sql = "SELECT uni_codigo, uni_descrip FROM tunidad ORDER BY uni_descrip ASC";
  $query = mysqli_query($db_conx, $sql);

  $n_filas = $query->num_rows;
  $data = '<select class="unidadmedico" multiple="multiple" id="cmbunidad">';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
    $c++;
  }
  $data .= '</select>';
  echo $data;
}

/**
 * Select Values to combobox Unidad displayed in MedicoReferente
 * @param type $db_conx
 */
function SelectValuesUnidadFiltro($db_conx) {
  $sql = "SELECT uni_codigo, uni_descrip FROM tunidad ORDER BY uni_descrip ASC";
  $query = mysqli_query($db_conx, $sql);

  $n_filas = $query->num_rows;
  $data = '<select style="width:207px;" id="cmbuni">';
  $data .= '<option value="0">Todos</option>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
    $c++;
  }
  $data .= '</select>';
  echo $data;
}

/**
 * Select from Medico Referente
 * @param type $db_conx
 * @param type $n_items
 * @param type $p_actual
 */
function SelectMedicoReferente($db_conx, $query = NULL) {

  if ($query == NULL) {
    $sql = "SELECT * FROM tmedicoreferente LIMIT 20";
    $query = mysqli_query($db_conx, $sql);
  }
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>            
            <td>Nombre</td>
            <td>CodMed</td>  
            <td>Especialidad</td>
            <td>Unidad(es)</td>
            <td>Estado</td>
            <td>Observacion</td>
            <td id="custom-action"></td>
        </tr>';
  $c = 0;
  while ($row = mysqli_fetch_array($query)) {
    $data .= '<tr class="row_data">';
    $data .= '<td><span id="td_' . $row[0] . '_0">' . $row[0] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_7">' . $row[7] . '</span> ';
    $data .= '<span id="td_' . $row[0] . '_8">' . $row[8] . '</span> ';
    $data .= '<span id="td_' . $row[0] . '_5">' . $row[5] . '</span> ';
    $data .= '<span id="td_' . $row[0] . '_6">' . $row[6] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_1">' . $row[1] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_2">' . $row[2] . '</span></td>';

    $cod = "";
    $uni = "";
    $unimedarray = SelectValuesUnidadMedicoArray($db_conx, $row[0]);
    for ($i = 0; $i < count($unimedarray); $i++) {
      $tem = explode("*", $unimedarray[$i]);
      $cod .= $tem[0];
      $uni .= $tem[1];
      if ($i + 1 != count($unimedarray)) {
        $cod .= ",";
        $uni .= ",<br>";
      }
    }
    $data .= '<td><span style="display:none;" id="uni_' . $row[0] . '">' . $cod . '</span>
      <span >' . $uni . '</span>
      </td>';

    $data .= '<td><span id="td_' . $row[0] . '_4">' . $row[4] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_3">' . $row[3] . '</span></td>';

    $data .= '<td id="custom-action"><button id="editar" onclick="editMedicoReferente(' . $row[0] . ')">Editar</button></td></tr>';
  }
  echo $data;
}

function SelectMedicoReferenciado($db_conx, $query = NULL) {

  if ($query == NULL) {
    $sql = "SELECT * FROM tmedicoreferenciado";
    $query = mysqli_query($db_conx, $sql);
  }
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Nombre</td>
            <td>CodMed</td>
            <td>Especialidad</td>
            <td>Estado</td>
            <td>Observacion</td>
            <td id="custom-action"></td>
        </tr>';

  while ($row = mysqli_fetch_array($query)) {
    $data .= '<tr class="row_data">';
    $data .= '<td><span id="td_' . $row[0] . '_0">' . $row[0] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_7">' . $row[7] . '</span> ';
    $data .= '<span id="td_' . $row[0] . '_8">' . $row[8] . '</span> ';
    $data .= '<span id="td_' . $row[0] . '_5">' . $row[5] . '</span> ';
    $data .= '<span id="td_' . $row[0] . '_6">' . $row[6] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_1">' . $row[1] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_2">' . $row[2] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_4">' . $row[4] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_3">' . $row[3] . '</span></td>';

    $data .= '<td id="custom-action"><button id="editar" onclick="editMedicoReferenciado(' . $row[0] . ')">Editar</button></td></tr>';
  }
  echo $data;
}

/**
 * Return the array with the cod and description of unimed
 * get from VIEW
 * @param type $db_conx
 * @param type $uid
 * @return string[]
 */
function SelectValuesUnidadMedicoArray($db_conx, $uid) {
  $data = array();
  $sql = "SELECT uni_codigo, uni_descrip FROM vunidadmedico WHERE med_codigo = $uid";
  $query = mysqli_query($db_conx, $sql);

  $n_filas = $query->num_rows;
  $c = 0;
  while ($row = mysqli_fetch_array($query)) {    
    $data[$c] = $row[0] . "*" . $row[1];
    $c++;
  }
  return $data;
}

/**
 * Select from Medico Referente
 * @param type $db_conx
 * @param type $n_items
 * @param type $p_actual
 */
function SelectPaciente($db_conx, $query = NULL) {

  if ($query == NULL) {
    $sql = "SELECT * FROM tpaciente";
    $query = mysqli_query($db_conx, $sql);
  }
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>   
            <td>Nombre / Cedula </td>               
            <td>F. Nacimiento</td>
            <td>Genero / Est. Civil</td>
            <td>Instruccion</td>
            <td>Hist. Clinica</td>
            <td>Telefono</td>
            <td>Seguro / Empresa</td>
            <td id="custom-action"></td>
        </tr>';
  while ($row = mysqli_fetch_array($query)) {
    $data .= '<tr class="row_data">';
    $data .= '<td><span id="td_' . $row[0] . '_0">' . $row[0] . '</span></td>'; //Cod   
    $data .= '<td><span id="td_' . $row[0] . '_6">' . $row[6] . '</span> '; //pape
    $data .= '<span id="td_' . $row[0] . '_7">' . $row[7] . '</span> '; //sape
    $data .= '<span id="td_' . $row[0] . '_4">' . $row[4] . '</span> '; //pnom
    $data .= '<span id="td_' . $row[0] . '_5">' . $row[5] . '</span><br>'; //snom    
    $data .= '<span id="td_' . $row[0] . '_3">' . $row[3] . '</span></td>'; //ced
    $data .= '<td><span id="td_' . $row[0] . '_8">' . $row[8] . '</span></td>'; //fnac
    $data .= '<td><span id="td_' . $row[0] . '_9">' . $row[9] . '</span><br>'; //genero
    $data .= '<span id="td_' . $row[0] . '_10">' . $row[10] . '</span></td>'; //estcivil
    $data .= '<td><span id="td_' . $row[0] . '_11">' . $row[11] . '</span></td>'; //Instruccion
    $data .= '<td><span id="td_' . $row[0] . '_12">' . $row[12] . '</span></td>'; //Hist Clinico
    $data .= '<td><span id="td_' . $row[0] . '_13">' . $row[13] . '</span></td>'; //Telefono
    //SELECT SEGURO DESCRIPTION
    $temprow[1] = "";
    if (isset($row[1])) {
      $tempsql = "SELECT * FROM tseguros WHERE seg_codigo = $row[1]";
      $tempquery = mysqli_query($db_conx, $tempsql);
      $temprow = mysqli_fetch_array($tempquery);
    }

    $data .= '<td><span style="display:none;" id="seg_' . $row[0] . '">' . $row[1] . '</span>
      <span>' . $temprow[1] . '</span><br>'; //Seguro
    //SELECT EMPRESA DESCRIPTION
    $temprow[1] = "";
    if (isset($row[2])) {
      $tempsql = "SELECT * FROM tempresas WHERE emp_codigo = $row[2]";
      $tempquery = mysqli_query($db_conx, $tempsql);
      $temprow = mysqli_fetch_array($tempquery);
    }
    $data .= '<span style="display:none;" id="emp_' . $row[0] . '">' . $row[2] . '</span>
      <span>' . $temprow[1] . '</span></td>'; //Empresa

    $data .= '<td id="custom-action"><button id="editar" onclick="editPaciente(' . $row[0] . ')">Editar</button></td></tr>';
  }
  echo $data;
}

/**
 * Select data to display in combobox, specify the table name without the character t
 * @param type $db_conx
 * @param type $table
 */
function SelectValuesSeguros_Empresas($db_conx, $table) {
  $sql = "";
  if ($table == "seguros") {
    $sql = "SELECT * FROM tseguros ORDER BY seg_descrip ASC";
  } else {
    $sql = "SELECT * FROM tempresas ORDER BY emp_descrip ASC";
  }
  $query = mysqli_query($db_conx, $sql);

  $n_filas = $query->num_rows;
  $data = '<select size="12" class="cmb' . $table . '" id="cmb' . $table . '">
    <option value="">Ninguno</option>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<option value="' . $row[0] . '">' . $row[1] . "_" . $row[2] . '</option>';
    $c++;
  }
  $data .= '</select>';
  echo $data;
}

/**
 * Select data to display in combobox, specify the table name without the character t
 * @param type $db_conx
 * @param type $table
 */
function SelectValuesServicios_MReferenciado($db_conx, $table, $multiple = NULL) {
  $sql = "";
  $script = "";

  if ($table == "servicios") {
    $sql = "SELECT * FROM tservicios ORDER BY ser_descrip ASC";
    $script = 'onchange="getMedicoxServicios(\'medicos\');"';
  } else {
    $sql = "SELECT * FROM tmedicoreferenciado WHERE mer_estado = 'activo' ORDER BY mer_sape ASC";
    $script = 'onchange="getMedicoxServicios(\'servicios\');"';
  }

  if ($multiple == NULL) {
    if ($table == "servicios") {
      $data = '<select ' . $script . ' size="30" style="width: 90%;" class="cmb' . $table . 'x" id="cmb' . $table . 'x">
    <option value="">Ninguno</option>';
    } else {
      $data = '<select ' . $script . ' size="30" style="width: 90%;" class="cmb' . $table . '" id="cmb' . $table . '">
    <option value="">Ninguno</option>';
    }
  } else {
    if ($table == "servicios") {
      $data = '<select size="30" style="width: 90%; float:right;" multiple="multiple" class="cmb' . $table . '" id="cmb' . $table . '">
    <option value="">Ninguno</option>';
    } else {
      $data = '<select size="30" style="width: 90%; float:right;" multiple="multiple" class="cmb' . $table . 'x" id="cmb' . $table . 'x">
    <option value="">Ninguno</option>';
    }
  }
  $c = 0;
  $query = mysqli_query($db_conx, $sql);
  $n_filas = $query->num_rows;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    if ($table == "servicios") {
      $data .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
    } else {
      $data .= '<option value="' . $row[0] . '">' . $row[7] . " " . $row[8] . " " . $row[5] . " " . $row[6] . '</option>';
    }
    $c++;
  }
  $data .= '</select>';
  echo $data;
}

function customSubstring($text, $nc) {
  $res = '';
  $i = 0;

  for (; $i < strlen($text) && $i < $nc; $i++) {
    $res .= $text[$i];
  }
  if ($i == $nc) {
    $res .= '...';
  }
  return $res;
}

function SelectReportMedSer($db_conx) {

  $sql = "SELECT * FROM vreport_med_ser";
  $query = mysqli_query($db_conx, $sql);

  $n_columnas = $query->field_count;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Nombre</td>
            <td>CodMed</td>
            <td>Especialidad</td>
            <td>Servicio(s)</td>            
        </tr>';
  $temcod = -1;
  $ban = FALSE;
  while ($row = mysqli_fetch_array($query)) {

    if ($row['MER_CODIGO'] != $temcod) {
      if ($ban == TRUE) {
        $data .= '</ul></td></tr>';
      }

      $data .= '<tr class="row_data">';
      $data .= '<td><span>' . $row['MER_CODIGO'] . '</span></td>';
      $data .= '<td><span>' . $row['MER_PAPE'] . ' ' . $row['MER_SAPE'] . ' ' . $row['MER_PNOM'] . ' ' . $row['MER_SNOM'] . '</span></td>';
      $data .= '<td><span>' . $row['MER_CODMED'] . '</span></td>';
      $data .= '<td><span>' . $row['MER_ESPECIAL'] . '</span></td>';
      $data .= '<td><ul>';
    }
    $data .= '<li>' . $row['SER_DESCRIP'] . '</li>';

    $temcod = $row['MER_CODIGO'];
    $ban = TRUE;
  }
  $data .= '</ul></td></tr>';
  echo $data;
}

function SelectReportSerMed($db_conx) {

  $sql = "SELECT * FROM vreport_med_ser ORDER BY ser_descrip ASC";
  $query = mysqli_query($db_conx, $sql);

  $n_columnas = $query->field_count;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Servicio</td>             
            <td>Médico(s)</td>            
        </tr>';
  $temcod = -1;
  $ban = FALSE;
  while ($row = mysqli_fetch_array($query)) {

    if ($row['SER_CODIGO'] != $temcod) {
      if ($ban == TRUE) {
        $data .= '</ul></td></tr>';
      }

      $data .= '<tr class="row_data">';
      $data .= '<td><span>' . $row['SER_CODIGO'] . '</span></td>';
      $data .= '<td><span>' . $row['SER_DESCRIP'] . '</span></td>';
      $data .= '<td><ul>';
    }

    $data .= '<li>' . $row['MER_PAPE'] . ' ' . $row['MER_SAPE'] . ' ' . $row['MER_PNOM'] . ' ' . $row['MER_SNOM'] . '</li>';

    $temcod = $row['SER_CODIGO'];
    $ban = TRUE;
  }
  $data .= '</ul></td></tr>';
  echo $data;
}

?>
