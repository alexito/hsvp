<?php

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
      $data .= '<option value="' . $row[0] . '">' . $row[1] .' '. $row[2] .' '. $row[3] .' '. $row[4]. '</option>';
      $c++;
    }
  }
  $data .= '</select>';
  echo $data;
}

function SelectReferenciasHospitalPendiente($db_conx, $codmed, $n_items = 10, $p_actual = 1) {
  $sql = "SELECT * FROM vreferencias_uni WHERE tra_estado = 'pendiente' ORDER BY tra_fecha ASC";
  $query = mysqli_query($db_conx, $sql);
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>Nro. Tra.</td>
            <td>Fecha</td>
            <td>Cédula</td>
            <td>Nombre Completo</td>            
            <td>Motivo</td>
            <td>Servicio</td>
            <td>Estado</td>
            <td>Activo</td>
            <td>Accion</td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<tr class="row_data">';
    for ($i = 1; $i < $n_columnas; $i++) {
      if ($i == 4) {
        $data .= "<td><span>$row[$i] $row[5]<br>$row[6] $row[7]</span></td>";
        $data .= "<td><span>" . customSubstring($row[8], 50) . "</span></td>";
        $i = 9;
      }
      $data .= "<td><span>$row[$i]</span></td>";
    }

    $data .= '<td><a target="_blank" href="ver_referencias_hos.php?cod_tramite=' . $row[1] . '">Ver<br>Editar</a></td></tr>';
    //print( $data);
    $c++;
  }
  echo $data;
}

function isTramitePendiente($db_conx, $tra_codigo) {
  $sql = "SELECT * FROM ttramite WHERE tra_codigo =  $tra_codigo AND tra_estado = 'pendiente'";
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
                  <td>
                    <label style="width: 25%;"><h5>Sala:</h5></label>
                    <span id="sal">' . $row[6] . '</span>
                  </td>
                  <td>
                    <label style="width: 25%;"><h5>Cama:</h5></label>
                    <span id="cam">' . $row[7] . '</span>
                  </td>
                </tr>
                <tr >
                  <td>
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

function SelectReferenciasUnidad($db_conx, $codmed, $n_items = 10, $p_actual = 1) {
  $sql = "SELECT * FROM vreferencias_uni WHERE MED_CODIGO = $codmed";
  $query = mysqli_query($db_conx, $sql);
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>Nro. Trámite</td>
            <td>Fecha</td>
            <td>Cédula</td>
            <td>Nombre Completo</td>            
            <td>Motivo</td>
            <td>Servicio</td>
            <td>Estado</td>
            <td>Activo</td>
            <td>Accion</td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<tr class="row_data">';
    for ($i = 1; $i < $n_columnas; $i++) {
      if ($i == 4) {
        $data .= "<td><span>$row[$i] $row[5]<br>$row[6] $row[7]</span></td>";
        $data .= "<td><span>" . customSubstring($row[8], 50) . "</span></td>";
        $i = 9;
      }
      $data .= "<td><span>$row[$i]</span></td>";
    }

    $data .= '<td><a target="_blank" href="ver_referencias_uni.php?cod_tramite=' . $row[1] . '">Ver<br>Editar</a></td></tr>';
    //print( $data);
    $c++;
  }
  echo $data;
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
  $sql = "SELECT * FROM tpaciente WHERE pac_codigo = $cod OR pac_cedula = '$cod' OR pac_hc = '$cod' LIMIT 1";
  $query = mysqli_query($db_conx, $sql);
  $data = '';
  if ($query) {
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

function SelectServicios($db_conx, $n_items = 10, $p_actual = 1) {
  $sql = "SELECT * FROM tservicios";
  $query = mysqli_query($db_conx, $sql);
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Descripcion</td>
            <td>Observacion</td>
            <td>Referenciado</td>            
            <td></td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
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
    $data .= '<td><button id="editar" onclick="editServicios(' . $row[0] . ')">Editar</button></td></tr>';
    //print( $data);
    $c++;
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

function SelectUsuario($db_conx, $n_items = 10, $p_actual = 1) {

  $sql = "SELECT usu_codigo, usu_usuario, usu_tipo, usu_activo, usu_fecha FROM tusuario";
  $query = mysqli_query($db_conx, $sql);
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Usuario</td>
            <td>Tipo</td>
            <td>Activo</td>
            <td>Ultimo Ingreso</td>
            <td></td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<tr class="row_data">';
    $data .= '<td><span id="td_' . $row[0] . '_0">' . $row[0] . '</span></td>';
    $data .= '<td><span id="td_' . $row[0] . '_1">' . $row[1] . '</span></td>';
    $data .= '<td><span id="tip_' . $row[0] . '">' . $row[2] . '</span></td>';
    $data .= '<td><span id="act_' . $row[0] . '">' . $row[3] . '</span></td>';
    $data .= '<td><span id="td_fecha">' . $row[4] . '</span></td>';
    $data .= '<td><button id="editar" onclick="editUsuario(' . $row[0] . ')">Editar</button></td></tr>';
    //print( $data);
    $c++;
  }
  echo $data;
}

/**
 * Load the updated data in the table
 * @param type $db_conx
 * @param type $n_items
 * @param type $p_actual
 */
function SelectLocalizacion($db_conx, $n_items = 10, $p_actual = 1) {

  $sql = "SELECT * FROM tlocalizacion";
  $query = mysqli_query($db_conx, $sql);
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Descripcion</td>
            <td>Parroquia</td>
            <td>Canton</td>
            <td>Provincia</td>
            <td></td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<tr class="row_data">';
    for ($i = 0; $i < $n_columnas; $i++) {
      $data .= '<td><span id="td_' . $row[0] . '_' . $i . '">' . $row[$i] . '</span></td>';
    }
    $data .= '<td><button id="editar" onclick="editarLocalizacion(' . $row[0] . ')">Editar</button></td></tr>';
    //print( $data);
    $c++;
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

  $n_filas = $query->num_rows;
  $data = '<select class="localizacion" id="cmblocalizacion">
    <option value="">Seleccione...</option>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
    $c++;
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

  $n_filas = $query->num_rows;
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data[$row[0]] = $row[1];
    $c++;
  }
  return $data;
}

/**
 * Load the updated data in the table
 * @param type $db_conx
 * @param type $n_items
 * @param type $p_actual
 */
function SelectUnidad($db_conx, $n_items = 10, $p_actual = 1) {

  $data_loc = SelectValuesLocalizacionArray($db_conx);

  $sql = "SELECT * FROM tunidad";
  $query = mysqli_query($db_conx, $sql);
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>
            <td>Localizacion</td>
            <td>Descripcion</td>
            <td>Observacion</td>
            <td>Activo</td>
            <td></td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
    $data .= '<tr class="row_data">';
    for ($i = 0; $i < $n_columnas; $i++) {
      if ($i == 1) {
        $data .= '<td><span style="display:none;" id="td_' . $row[0] . '_' . $i . '">' . $row[$i] . '</span>
          <span>' . $data_loc[$row[$i]] . '</span></td>';
      } else {
        $data .= '<td><span id="td_' . $row[0] . '_' . $i . '">' . $row[$i] . '</span></td>';
      }
    }
    $data .= '<td><button id="editar" onclick="editUnidad(' . $row[0] . ')">Editar</button></td></tr>';
    //print( $data);
    $c++;
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
 * Select from Medico Referente
 * @param type $db_conx
 * @param type $n_items
 * @param type $p_actual
 */
function SelectMedicoReferente($db_conx, $n_items = 10, $p_actual = 1) {

  $sql = "SELECT * FROM tmedicoreferente";
  $query = mysqli_query($db_conx, $sql);
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
            <td></td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
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

    $data .= '<td><button id="editar" onclick="editMedicoReferente(' . $row[0] . ')">Editar</button></td></tr>';
    //print( $data);
    $c++;
  }
  echo $data;
}

function SelectMedicoReferenciado($db_conx, $n_items = 10, $p_actual = 1) {

  $sql = "SELECT * FROM tmedicoreferenciado";
  $query = mysqli_query($db_conx, $sql);
  $n_columnas = $query->field_count;
  $n_filas = $query->num_rows;
  $data = '<tr class="row_header">
            <td>COD</td>            
            <td>Nombre</td>
            <td>CodMed</td>  
            <td>Especialidad</td>
            <td>Estado</td>
            <td>Observacion</td>
            <td></td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
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

    $data .= '<td><button id="editar" onclick="editMedicoReferenciado(' . $row[0] . ')">Editar</button></td></tr>';
    //print( $data);
    $c++;
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
  $sql = "SELECT uni_codigo, uni_descrip FROM vunidadmedico WHERE med_codigo = $uid";
  $query = mysqli_query($db_conx, $sql);

  $n_filas = $query->num_rows;
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
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
function SelectPaciente($db_conx, $n_items = 10, $p_actual = 1) {

  $sql = "SELECT * FROM tpaciente";
  $query = mysqli_query($db_conx, $sql);
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
            <td></td>
        </tr>';
  $c = 0;
  while ($c < $n_filas) {
    $row = mysqli_fetch_array($query);
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

    $data .= '<td><button id="editar" onclick="editPaciente(' . $row[0] . ')">Editar</button></td></tr>';
    //print( $data);
    $c++;
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
    $sql = "SELECT * FROM tmedicoreferenciado ORDER BY mer_sape ASC";
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

?>
