<?php

function filtrarPaciente($db_conx, $op, $btn, $rxp, $pa, $ord, $fn, $gen, $ec, $tex) {
  $ftex = $ffn = "";

  if ($tex != '' && $op == 'op5') {
    $ftex = "WHERE (pac_pape = '$tex' OR pac_sape = '$tex' OR pac_pnom = '$tex' OR pac_snom = '$tex' OR pac_cedula = '$tex' OR pac_hc = '$tex' OR pac_instruc = '$tex')";
  }
  if ($fn != '' && $op != 'op5') {
    $ffn = "pac_fch_nac = '$fn'";
  }

  if ($op == 'op1' || $op == 'op2') {
    $ban = false;
    $sql = "SELECT COUNT(*) FROM tpaciente";
    if ($fn != '') {
      $sql .= " WHERE $ffn";
      $ban = true;
    }
    if ($ec != 'op0') {
      $sql .= ($ban) ? " AND pac_est_civ = '$ec'" : " WHERE pac_est_civ = '$ec'";
      $ban = true;
    }
    if ($gen != 'op0') {
      $sql .= ($ban) ? " AND pac_genero = '$gen'" : " WHERE pac_genero = '$gen'";
    }
  }

  if ($op == 'op3') {
    $sql = "SELECT COUNT(*) FROM tpaciente WHERE pac_genero = '$gen'";
    if ($fn != '') {
      $sql .= " AND $ffn";
    }
    if ($ec != 'op0') {
      $sql .= " AND pac_est_civ = '$ec'";
    }
  }

  if ($op == 'op4') {
    $sql = "SELECT COUNT(*) FROM tpaciente WHERE pac_est_civ = '$ec'";
    if ($fn != '') {
      $sql .= " AND $ffn";
    }
    if ($gen != 'op0') {
      $sql .= " AND pac_genero = '$gen'";
    }
  }

  if ($op == 'op5') {
    $sql = "SELECT COUNT(*) FROM tpaciente $ftex";
    if ($ec != 'op0') {
      $sql .= " AND pac_est_civ = '$ec'";
    }
    if ($gen != 'op0') {
      $sql .= " AND pac_genero = '$gen'";
    }
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($op == 'op1' || $op == 'op2') {
    $ban = false;
    $sql = "SELECT * FROM tpaciente";
    if ($fn != '') {
      $sql .= " WHERE $ffn";
      $ban = true;
    }
    if ($ec != 'op0') {
      $sql .= ($ban) ? " AND pac_est_civ = '$ec'" : " WHERE pac_est_civ = '$ec'";
      $ban = true;
    }
    if ($gen != 'op0') {
      $sql .= ($ban) ? " AND pac_genero = '$gen'" : " WHERE pac_genero = '$gen'";
    }
  }

  if ($op == 'op3') {
    $sql = "SELECT * FROM tpaciente WHERE pac_genero = '$gen'";
    if ($fn != '') {
      $sql .= " AND $ffn";
    }
    if ($ec != 'op0') {
      $sql .= " AND pac_est_civ = '$ec'";
    }
  }

  if ($op == 'op4') {
    $sql = "SELECT * FROM tpaciente WHERE pac_est_civ = '$ec'";
    if ($fn != '') {
      $sql .= " AND $ffn";
    }
    if ($gen != 'op0') {
      $sql .= " AND pac_genero = '$gen'";
    }
  }

  if ($op == 'op5') {
    $sql = "SELECT * FROM tpaciente $ftex";
    if ($ec != 'op0') {
      $sql .= " AND pac_est_civ = '$ec'";
    }
    if ($gen != 'op0') {
      $sql .= " AND pac_genero = '$gen'";
    }
  }

  if ($op == 'op1') {
    $sql .= " ORDER BY pac_codigo $ord";
  } elseif ($op == 'op2' || $op == 'op5') {
    $sql .= " ORDER BY pac_pape $ord";
  } elseif ($op == 'op3') {
    $sql .= " ORDER BY pac_genero $ord";
  } elseif ($op == 'op4') {
    $sql .= " ORDER BY pac_est_civ $ord";
  }

  $sql .= " LIMIT $limit";

  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectPaciente($db_conx, $query);
}

function filtrarUsuario($db_conx, $op, $btn, $rxp, $pa, $ord, $tip, $est, $tex) {
  if ($op == "op1" || $op == "op2") {
    $ban = false;
    $sql = "SELECT COUNT(*) FROM tusuario";
    if ($est != "op0") {
      $sql .= " WHERE usu_activo = '$est'";
      $ban = true;
    }
    if ($tip != "op0") {
      $sql .= (!$ban) ? " WHERE usu_tipo = '$tip'" : " AND usu_tipo = '$tip'";
    }
  }
  if ($op == "op3") {
    $sql = "SELECT COUNT(*) FROM tusuario WHERE usu_tipo = '$tip'";
    if ($est != "op0") {
      $sql .= " AND usu_activo = '$est'";
    }
  }
  if ($op == "op4") {
    $sql = "SELECT COUNT(*) FROM tusuario WHERE usu_usuario = '$tex'";
    if ($est != "op0") {
      $sql .= " AND usu_activo = '$est'";
    }
    if ($tip != "op0") {
      $sql .= " AND usu_tipo = '$tip'";
    }
  }


  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  $sel = "usu_codigo, usu_usuario, usu_tipo, usu_activo, usu_fecha";

  if ($op == "op1" || $op == "op2") {
    $ban = false;
    $sql = "SELECT $sel FROM tusuario";
    if ($est != "op0") {
      $sql .= " WHERE usu_activo = '$est'";
      $ban = true;
    }
    if ($tip != "op0") {
      $sql .= (!$ban) ? " WHERE usu_tipo = '$tip'" : " AND usu_tipo = '$tip'";
    }
  }
  if ($op == "op3") {
    $sql = "SELECT $sel FROM tusuario WHERE usu_tipo = '$tip'";
    if ($est != "op0") {
      $sql .= " AND usu_activo = '$est'";
    }
  }
  if ($op == "op4") {
    $sql = "SELECT $sel FROM tusuario WHERE usu_usuario = '$tex'";
    if ($est != "op0") {
      $sql .= " AND usu_activo = '$est'";
    }
    if ($tip != "op0") {
      $sql .= " AND usu_tipo = '$tip'";
    }
  }

  if ($op == 'op1') {
    $sql .= " ORDER BY usu_codigo $ord";
  } else {
    $sql .= " ORDER BY usu_usuario $ord";
  }

  $sql .= " LIMIT $limit";

  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectUsuario($db_conx, $query);
}

function filtrarMedicoReferenciado($db_conx, $op, $btn, $rxp, $pa, $ord, $est, $tex) {
  $ftex = $fest = "";

  if ($tex != '' && $op == 'op4') {
    $ftex = "WHERE (mer_codmed = '$tex' OR mer_pape = '$tex' OR mer_sape = '$tex' OR mer_pnom = '$tex' OR mer_snom = '$tex' OR mer_especial = '$tex')";
  }
  if ($est != 'op0') {
    $fest = "AND mer_estado = '$est'";
  }

  if ($ftex != '') {
    $sql = "SELECT COUNT(*) FROM tmedicoreferenciado $ftex $fest"; //Si tiene texto    
  } else {
    if ($est != 'op0') {
      $sql = "SELECT COUNT(*) FROM tmedicoreferenciado WHERE mer_estado = '$est' "; //hay un estado
    } else {
      $sql = "SELECT COUNT(*) FROM tmedicoreferenciado"; //No hay estado
    }
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($ftex != '') {
    $sql = "SELECT * FROM tmedicoreferenciado $ftex $fest"; //Si tiene texto    
  } else {
    if ($est != 'op0') {
      $sql = "SELECT * FROM tmedicoreferenciado WHERE mer_estado = '$est' "; //hay un estado
    } else {
      $sql = "SELECT * FROM tmedicoreferenciado"; //No hay estado
    }
  }

  if ($op == 'op1') {
    $sql .= " ORDER BY mer_codigo $ord";
  } elseif ($op == 'op2' || $op == 'op4') {
    $sql .= " ORDER BY mer_pape $ord";
  } elseif ($op == 'op3') {
    $sql .= " ORDER BY mer_especial $ord";
  }

  $sql .= " LIMIT $limit";

  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectMedicoReferenciado($db_conx, $query);
}

function filtrarMedicoReferente($db_conx, $op, $btn, $rxp, $pa, $ord, $est, $uni, $tex) {
  $funi = $ftex = $fest = "";

  if ($uni != 0) {
    $funi = SelectMedicoxUnidadSQL($db_conx, $uni);
  }
  if ($tex != '' && $op == 'op4') {
    $ftex = "WHERE (med_codmed = '$tex' OR med_pape = '$tex' OR med_sape = '$tex' OR med_pnom = '$tex' OR med_snom = '$tex' OR med_especial = '$tex')";
  }
  if ($est != 'op0') {
    $fest = "AND med_estado = '$est'";
  }

  if ($ftex != '') {
    $sql = "SELECT COUNT(*) FROM tmedicoreferente $ftex $fest"; //Si tiene texto
    if ($funi != '') {
      if ($ftex != '') {
        $sql = "SELECT COUNT(*) FROM tmedicoreferente $ftex AND ($funi) $fest"; // Si tiene texto y unidad seleccionada
      } else {
        $sql = "SELECT COUNT(*) FROM tmedicoreferente WHERE ($funi) $fest"; // Si tiene texto y unidad seleccionada
      }
    }
  } elseif ($uni != 0) {
    $sql = "SELECT COUNT(*) FROM tmedicoreferente WHERE ($funi) $fest "; //Si tiene unidad seleccionada
  } else {
    if ($est != 'op0') {
      $sql = "SELECT COUNT(*) FROM tmedicoreferente WHERE med_estado = '$est' "; //hay un estado
    } else {
      $sql = "SELECT COUNT(*) FROM tmedicoreferente"; //No hay estado
    }
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($tex != '') {
    $sql = "SELECT * FROM tmedicoreferente $ftex $fest"; //Si tiene texto
    if ($funi != '') {
      if ($ftex != '') {
        $sql = "SELECT * FROM tmedicoreferente $ftex AND ($funi) $fest"; // Si tiene texto y unidad seleccionada
      } else {
        $sql = "SELECT * FROM tmedicoreferente WHERE ($funi) $fest"; // Si tiene texto y unidad seleccionada
      }
    }
  } elseif ($uni != 0) {
    $sql = "SELECT * FROM tmedicoreferente WHERE ($funi) $fest "; //Si tiene unidad seleccionada
  } else {
    if ($est != 'op0') {
      $sql = "SELECT * FROM tmedicoreferente WHERE med_estado = '$est' "; //hay un estado
    } else {
      $sql = "SELECT * FROM tmedicoreferente"; //No hay estado
    }
  }

  if ($op == 'op1') {
    $sql .= " ORDER BY med_codigo $ord";
  } elseif ($op == 'op2' || $op == 'op4') {
    $sql .= " ORDER BY med_pape $ord";
  } elseif ($op == 'op3') {
    $sql .= " ORDER BY med_especial $ord";
  }

  $sql .= " LIMIT $limit";

  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectMedicoReferente($db_conx, $query);
}

function filtrarServicios($db_conx, $btn, $rxp, $pa, $ord, $tex) {
  if ($tex != '') {
    $sql = "SELECT COUNT(*) FROM tservicios WHERE ser_descrip = '$tex'";
  } else {
    $sql = "SELECT COUNT(*) FROM tservicios";
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($tex != '') {
    $sql = "SELECT * FROM tservicios WHERE ser_descrip = '$tex' ORDER BY ser_descrip $ord LIMIT $limit";
  } else {
    $sql = "SELECT * FROM tservicios ORDER BY ser_descrip $ord LIMIT $limit";
  }
  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectServicios($db_conx, $query);
}

function filtrarUnidad($db_conx, $op, $btn, $rxp, $pa, $ord, $est, $tex) {
  $opEst = '';
  if ($est != 'op0') {
    $opEst = "AND uni_activo = '$est'";
  }
  if ($op == 'op3') {
    $sql = "SELECT COUNT(*) FROM vlocalizacionxunidad WHERE (loc_descrip = '$tex' OR uni_descrip = '$tex') $opEst";
  } elseif ($op == 'op2') {
    $sql = "SELECT COUNT(*) FROM vlocalizacionxunidad WHERE uni_activo = '$est'";
  } elseif ($op == 'op1') {
    if ($est == 'op0') {
      $sql = "SELECT COUNT(*) FROM vlocalizacionxunidad";
    } else {
      $sql = "SELECT COUNT(*) FROM vlocalizacionxunidad WHERE uni_activo = '$est'";
    }
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($op == 'op3') {
    $sql = "SELECT * FROM vlocalizacionxunidad WHERE (loc_descrip = '$tex' OR uni_descrip = '$tex') $opEst ORDER BY uni_descrip $ord LIMIT $limit";
  } elseif ($op == 'op2') {
    $sql = "SELECT * FROM vlocalizacionxunidad WHERE uni_activo = '$est' ORDER BY uni_descrip $ord LIMIT $limit";
  } elseif ($op == 'op1') {
    if ($est == 'op0') {
      $sql = "SELECT * FROM vlocalizacionxunidad ORDER BY uni_codigo $ord LIMIT $limit";
    } else {
      $sql = "SELECT * FROM vlocalizacionxunidad WHERE uni_activo = '$est' ORDER BY uni_descrip $ord LIMIT $limit";
    }
  }

  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectUnidad($db_conx, $query);
}

function filtrarLocalizacion($db_conx, $op, $btn, $rxp, $pa, $ord, $tex) {
  if ($op == 'op5') {
    $sql = "SELECT COUNT(*) FROM tlocalizacion WHERE loc_descrip = '$tex' OR loc_cparr = '$tex' OR loc_ccan = '$tex' OR loc_cpro = '$tex'";
  } else {
    $sql = "SELECT COUNT(*) FROM tlocalizacion";
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($op == 'op5') {
    $sql = "SELECT * FROM tlocalizacion WHERE loc_descrip = '$tex' OR loc_cparr = '$tex' OR loc_ccan = '$tex' OR loc_cpro = '$tex' LIMIT $limit";
  } else {
    $sql = "SELECT * FROM tlocalizacion ORDER BY $op $ord LIMIT $limit";
  }

  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectLocalizacion($db_conx, $query);
}

function filtrarReferenciasUnidad($db_conx, $codmed, $op, $btn, $rxp, $pa, $est, $nro, $fd, $fh) {
  if ($op == 'op1') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND MED_CODIGO = $codmed";
  } elseif ($op == 'op2') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE (tra_codigo = $nro OR pac_cedula = '$nro') AND MED_CODIGO = $codmed";
  } elseif ($op == 'op3') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE ((tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh') AND MED_CODIGO = $codmed";
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($op == 'op1') {
    $sql = "SELECT * FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND MED_CODIGO = $codmed LIMIT $limit";
  } elseif ($op == 'op2') {
    $sql = "SELECT * FROM vreferencias_uni WHERE (tra_codigo = $nro OR pac_cedula = '$nro') AND MED_CODIGO = $codmed LIMIT $limit";
  } elseif ($op == 'op3') {
    $sql = "SELECT * FROM vreferencias_uni WHERE ((tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh') AND MED_CODIGO = $codmed LIMIT $limit";
  }

  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectReferenciasUnidad($db_conx, $codmed, $query);
}

function filtrarReferenciasHospital($db_conx, $op, $btn, $rxp, $pa, $est, $nro, $fd, $fh) {
  if ($op == 'op1') {
    if ($est == "confirmado") {
      $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_estado = '$est' AND tra_tipo != 'contrareferencia'";
    } else {
      $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_estado = '$est' OR tra_tipo = '$est'";
    }
  } elseif ($op == 'op2') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_codigo = $nro OR pac_cedula = '$nro'";
  } elseif ($op == 'op3') {
    if ($est == "confirmado") {
      $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_estado = '$est' AND tra_tipo != 'contrareferencia' AND tra_fecha BETWEEN '$fd' AND '$fh'";
    } else {
      $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh'";
    }
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($op == 'op1') {
    if ($est == "confirmado") {
      $sql = "SELECT * FROM vreferencias_uni WHERE tra_estado = '$est' AND tra_tipo != 'contrareferencia' ORDER BY tra_fecha ASC LIMIT $limit";
    } else {
      $sql = "SELECT * FROM vreferencias_uni WHERE tra_estado = '$est' OR tra_tipo = '$est' ORDER BY tra_fecha ASC LIMIT $limit";
    }
  } elseif ($op == 'op2') {
    $sql = "SELECT * FROM vreferencias_uni WHERE tra_codigo = $nro OR pac_cedula = '$nro' ORDER BY tra_fecha ASC LIMIT $limit";
  } elseif ($op == 'op3') {
    if ($est == "confirmado") {
      $sql = "SELECT * FROM vreferencias_uni WHERE tra_estado = '$est' AND tra_tipo != 'contrareferencia' AND tra_fecha BETWEEN '$fd' AND '$fh' ORDER BY tra_fecha ASC LIMIT $limit";
    } else {
      $sql = "SELECT * FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh' ORDER BY tra_fecha ASC LIMIT $limit";
    }
  }

  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectReferenciasHospital($db_conx, $query);
}

function limitarResultado($btn, $rxp, $pa, $total) {
  $limit = $rxp;
  if ($btn == 'ant') {
    $limit = ($pa > 1) ? $rxp * ($pa - 1) : $rxp;
  } elseif ($btn == 'sig') {
    $tem = ($rxp * ($pa + 1)) - ($rxp * $pa);
    $limit = ($tem > 0) ? ($rxp * $pa) + $tem : ($rxp * $pa);
  } else {

    $limit = $rxp;
  }
  return $limit;
}

function recortarResultado($query, $rxp, $pa, $limit, $total) {
  $tem = $rxp * $pa;
  $c = 0;
  if ($limit > $tem) {//Siguiente
    if ($total < $tem) {
      $tem = $tem - $rxp;
    }
    while ($c < $tem) {
      mysqli_fetch_array($query);
      $c++;
    }
  } else {//Anterior
    $tem = $rxp * ($pa - 2);
    while ($c < $tem) {
      mysqli_fetch_array($query);
      $c++;
    }
  }
  return $query;
}

?>