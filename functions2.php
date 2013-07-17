<?php

function filtrarReferenciasHospitalOp1($db_conx, $btn, $rxp, $pa, $est) {
  $sql = "SELECT COUNT(*) FROM vreferencias_uni WHERE tra_estado = '$est' OR tra_tipo = '$est'";
  $query = mysqli_query($db_conx, $sql);
  $row = mysqli_fetch_array($query);
  $total = $row[0];
  $limit = limitarResultado($btn, $rxp, $pa, $total);

  $sql = "SELECT * FROM vreferencias_uni WHERE tra_estado = '$est' OR tra_tipo = '$est' ORDER BY tra_fecha ASC LIMIT $limit";
  $query = mysqli_query($db_conx, $sql);

  $query = recortarResultado($query, $rxp, $pa, $limit);
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

function recortarResultado($query, $rxp, $pa, $limit) {
  $tem = $rxp * $pa;
  $c = 0;
  if ($limit > $tem) {
    while ($c < $tem) {
      mysqli_fetch_array($query);
      $c++;
    }
  } else {
    $tem = $rxp * ($pa - 1);
    while ($c < $tem) {
      mysqli_fetch_array($query);
      $c++;
    }
  }
  return $query;
}

?>