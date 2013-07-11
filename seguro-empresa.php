<?php
include_once("php_includes/db_conx.php");
include_once("functions.php");

session_start();
// If user is logged in, header them away
if (isset($_SESSION["username"])) {
  header("location: message.php?msg=Error inesperado - medico_referente.php");
  exit();
}
?><?php
if (isset($_POST["seguros"])) {
  $des = $_POST['des'];
  $obs = $_POST['obs'];
  if ($des == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tseguros SET 
             seg_descrip = '$des',
             seg_observ = '$obs' 
             WHERE seg_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
  } else { //This is to INSERT
    $sql = "INSERT INTO tseguros (seg_descrip, seg_observ) 
      VALUES('$des','$obs');";
    $query = mysqli_query($db_conx, $sql);
  }
  echo SelectValuesSeguros_Empresas($db_conx, 'seguros');
  exit();
}
if (isset($_POST["empresas"])) {
  $des = $_POST['des'];
  $obs = $_POST['obs'];
  if ($des == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE tempresas SET 
             emp_descrip = '$des',
             emp_observ = '$obs' 
             WHERE emp_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
  } else { //This is to INSERT
    $sql = "INSERT INTO tempresas (emp_descrip, emp_observ) 
      VALUES('$des','$obs');";
    $query = mysqli_query($db_conx, $sql);
  }
  echo SelectValuesSeguros_Empresas($db_conx, 'empresas');
  exit();
}
?>
