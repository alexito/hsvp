<?php

session_start();
// Set Session data to an empty array
$_SESSION = array();
// Expire their cookie files
if (isset($_COOKIE["codigo"]) && isset($_COOKIE["usuario"]) && isset($_COOKIE["clave"])) {
  setcookie("codigo", '', strtotime('-5 days'), '/');
  setcookie("usuario", '', strtotime('-5 days'), '/');
  setcookie("clave", '', strtotime('-5 days'), '/');
}
// Destroy the session variables
session_destroy();
// Double check to see if their sessions exists
if (isset($_SESSION['usuario'])) {
  header("location: message.php?msg=Error:_Logout_Failed");
} else {
  header("location: index.php");
  exit();
}
?>
