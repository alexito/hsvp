<?php

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
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_estado = '$est' OR tra_tipo = '$est'";
  } elseif ($op == 'op2') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_codigo = $nro OR pac_cedula = '$nro'";
  } elseif ($op == 'op3') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh'";
  }

  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if ($op == 'op1') {
    $sql = "SELECT * FROM vreferencias_uni WHERE tra_estado = '$est' OR tra_tipo = '$est' ORDER BY tra_fecha ASC LIMIT $limit";
  } elseif ($op == 'op2') {
    $sql = "SELECT * FROM vreferencias_uni WHERE tra_codigo = $nro OR pac_cedula = '$nro' ORDER BY tra_fecha ASC LIMIT $limit";
  } elseif ($op == 'op3') {
    $sql = "SELECT * FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh' ORDER BY tra_fecha ASC LIMIT $limit";
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