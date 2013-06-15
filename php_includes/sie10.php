<?php

include_once("db_conx.php");
include_once("check_login_status.php");
if ($user_ok == true) {
  $sie = array();
  $sql = "SELECT sie_codigo, sie_descrip FROM tsie10";
  $query = mysqli_query($db_conx, $sql);
  if ($query) {
    $n_filas = $query->num_rows;
    $c = 0;
    while ($c < $n_filas) {
      $row = mysqli_fetch_array($query);
      $sie[(string)$row[0]] = $row[1];
      $c++;
    }
  }
  echo json_encode($sie);
}
?>