<?php
include_once("php_includes/check_login_status.php");
// If user is already logged in, header that weenis away
if ($user_ok == true) {
  header("location: inicio.php?usu=" . $_SESSION["usuario"]);
  exit();
}
?><?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if (isset($_POST["usu"])) {
  // CONNECT TO THE DATABASE
  include_once("php_includes/db_conx.php");
  // GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
  $usu = mysqli_real_escape_string($db_conx, $_POST['usu']);
  $cla = md5($_POST['cla']);
  
  // FORM DATA ERROR HANDLING
  if ($usu == "" || $cla == "") {
    $error['msg'] = "login_failed";
      $b = json_encode($error);
      echo $b;     
      exit();
  } else {
    // END FORM DATA ERROR HANDLING
    $sql = "SELECT usu_codigo, usu_usuario, usu_clave, usu_tipo FROM tusuario WHERE usu_usuario='$usu' AND usu_activo='activo' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $row = mysqli_fetch_row($query);
    $db_id = $row[0];
    $db_username = $row[1];
    $db_pass_str = $row[2];
    $db_tipo = $row[3];
    if ($cla != $db_pass_str) {
      $error['msg'] = "login_failed";
      $b = json_encode($error);
      echo $b;     
      exit();
    } else {
      // CREATE THEIR SESSIONS AND COOKIES
      $_SESSION['codigo'] = $db_id;
      $_SESSION['usuario'] = $db_username;
      $_SESSION['clave'] = $db_pass_str;
      $_SESSION['tipo'] = $db_tipo;
      setcookie("codigo", $db_id, strtotime('+30 days'), "/", "", "", TRUE);
      setcookie("usuario", $db_username, strtotime('+30 days'), "/", "", "", TRUE);
      setcookie("clave", $db_pass_str, strtotime('+30 days'), "/", "", "", TRUE);
      setcookie("tipo", $db_tipo, strtotime('+30 days'), "/", "", "", TRUE);
      // UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
      $sql = "UPDATE tusuario SET usu_fecha=now() WHERE usu_usuario='$db_username' LIMIT 1";
      $query = mysqli_query($db_conx, $sql);
      $success['usu'] = $db_username;
      $b = json_encode($success);
      echo $b;
      exit();
    }
  }
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include_once("php_includes/head.php"); ?>
    <script type="text/javascript" src="js/session.js"></script>
  </head>
  <body>
    <div id="templatemo_wrapper">
      <?php include_once("php_includes/template_pageTop.php"); ?>

      <div id="templatemo_main">
        <div id="pageMiddle">

          <!-- LOGIN FORM -->
          <div id="genform_style" class="loginfrm">
            <table>
              <tr>
                <td>            
                  <form class="loginclass" id="genform" onsubmit="return false;" style="height: 450px;">
                    <label>Usuario:</label>
                    <input type="text" id="usuario" onfocus="emptyElement('status')" maxlength="20">
                    <label>Clave:</label>
                    <input type="password" id="clave" onfocus="emptyElement('status')" maxlength="20">
                    <br><br><a id="olvidoclave" href="#">Olvido su clave?</a><br>
                    <button id="submitbtn" onclick="login()">Acceder</button> 
                    <p id="status"></p>                    
                  </form>
                </td>
                <td id="loginicon">
                  <img id="loginicon_not" src="images/login.png">
                  <img id="loginicon_yes" style="display: none; max-width: 140px; max-height: 140px;" src="images/success.png">
                  <p id="msg" style="display: none; max-width: 160px; border: salmon dashed thin; padding: 5px;">Para recuperar su clave póngase en contacto con el Administrador.</p>
                </td>
              </tr>
            </table>
            <!-- LOGIN FORM -->
          </div>
        </div>
        <div class="cleaner"></div>
      </div>
    </div>
    <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>