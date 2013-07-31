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
if (isset($_POST["des"])) {
  $des = $_POST['des'];
  $obs = $_POST['obs'];
  $sig = $_POST['sig'];
  if($des == "" || $sig == "") {
    echo "The form submission is missing values.";
    exit();
  } else if (isset($_POST["cod"])) { //This is for UPDATE
    $cod = $_POST["cod"];
    $sql = "UPDATE treferenciado SET 
             ref_descrip = '$des',
             ref_descrip = '$sig',
             ref_observ = '$obs' 
             WHERE ref_codigo = $cod";
    $query = mysqli_query($db_conx, $sql);
  } else { //This is to INSERT
    $sql = "INSERT INTO treferenciado (ref_descrip, ref_siglas, ref_observ) 
      VALUES('$des','$sig','$obs');";
    $query = mysqli_query($db_conx, $sql);
  }
  echo SelectValuesReferenciado($db_conx);
  exit();
}
?>
