<?php
session_start();
include_once("db_conx.php");
// Files that inculde this file at the very top would NOT require 
// connection to database or session_start(), be careful.
// Initialize some vars
$user_ok = false;
$log_id = "";
$log_username = "";
$log_password = "";

// User Verify function
function evalLoggedUser($conx, $id, $u, $p, $t) {
  $sql = "SELECT * FROM tusuario WHERE usu_codigo='$id' AND usu_usuario='$u' AND usu_clave='$p' AND usu_tipo = '$t' AND usu_activo='activo' LIMIT 1";
  $query = mysqli_query($conx, $sql);
  $numrows = $query->num_rows;
  if ($numrows > 0) {
    return true;
  }
}

if (isset($_SESSION["codigo"]) && isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["tipo"])) {
  $log_id = preg_replace('#[^0-9]#', '', $_SESSION['codigo']);
  $log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['usuario']);
  $log_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['clave']);
  $log_tipo = preg_replace('#[^a-z0-9]#i', '', $_SESSION['tipo']);
  // Verify the user
  $user_ok = evalLoggedUser($db_conx, $log_id, $log_username, $log_password, $log_tipo);
} else if (isset($_COOKIE["codigo"]) && isset($_COOKIE["usuario"]) && isset($_COOKIE["clave"]) && isset($_COOKIE["tipo"])) {
  $_SESSION['codigo'] = preg_replace('#[^0-9]#', '', $_COOKIE['codigo']);
  $_SESSION['usuario'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['usuario']);
  $_SESSION['clave'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['clave']);
  $_SESSION['tipo'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['tipo']);
  $log_id = $_SESSION['codigo'];
  $log_username = $_SESSION['usuario'];
  $log_password = $_SESSION['clave'];
  $log_tipo = $_SESSION['tipo'];
  // Verify the user
  $user_ok = evalLoggedUser($db_conx, $log_id, $log_username, $log_password, $log_tipo);
  if ($user_ok == true) {
    // Update their lastlogin datetime field
    $sql = "UPDATE tusuario SET usu_fecha=now() WHERE id='$log_id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
  }
}
?>