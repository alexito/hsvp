<?php
function filtrarReferenciasUnidad($db_conx, $codmed, $op, $btn, $rxp, $pa, $est,
        $nro, $fd, $fh) {
  if($op == 'op1'){
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND MED_CODIGO = $codmed";
  }elseif ($op == 'op2') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE (tra_codigo = $nro OR pac_cedula = '$nro') AND MED_CODIGO = $codmed";
  }elseif ($op == 'op3') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE ((tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh') AND MED_CODIGO = $codmed";
  }
  
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if($op == 'op1'){
    $sql = "SELECT * FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND MED_CODIGO = $codmed LIMIT $limit";
  }elseif ($op == 'op2') {
    $sql = "SELECT * FROM vreferencias_uni WHERE (tra_codigo = $nro OR pac_cedula = '$nro') AND MED_CODIGO = $codmed LIMIT $limit";
  }elseif ($op == 'op3') {
    $sql = "SELECT * FROM vreferencias_uni WHERE ((tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh') AND MED_CODIGO = $codmed LIMIT $limit";
  }
  
  $query = mysqli_query($db_conx, $sql);
  if ($btn != 'car') {
    $query = recortarResultado($query, $rxp, $pa, $limit, $total);
  }
  SelectReferenciasUnidad($db_conx, $codmed, $query);
}

function filtrarReferenciasHospital($db_conx, $op, $btn, $rxp, $pa, $est, $nro, $fd, $fh) {
  if($op == 'op1'){
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_estado = '$est' OR tra_tipo = '$est'";
  }elseif ($op == 'op2') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_codigo = $nro OR pac_cedula = '$nro'";
  }elseif ($op == 'op3') {
    $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE (tra_estado = '$est' OR tra_tipo = '$est') AND tra_fecha BETWEEN '$fd' AND '$fh'";
  }
  
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  if($op == 'op1'){
    $sql = "SELECT * FROM vreferencias_uni WHERE tra_estado = '$est' OR tra_tipo = '$est' ORDER BY tra_fecha ASC LIMIT $limit";
  }elseif ($op == 'op2') {
    $sql = "SELECT * FROM vreferencias_uni WHERE tra_codigo = $nro OR pac_cedula = '$nro' ORDER BY tra_fecha ASC LIMIT $limit";
  }elseif ($op == 'op3') {
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