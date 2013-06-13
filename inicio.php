<?php
include_once("php_includes/check_login_status.php");

// Make sure the _GET username is set, and sanitize it
if (isset($_GET["usu"])) {
  $u = preg_replace('#[^a-z0-9]#i', '', $_GET['usu']);
} else {
  header("location: http://www.google.com");
  exit();
}
// Select the member from the users table
$sql = "SELECT * FROM tusuario WHERE usu_usuario='$u' AND usu_activo='activo' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if ($numrows < 1) {
  echo "That user does not exist or is not yet activated, press back";
  exit();
}

?>
<!DOCTYPE html>
<html>
  <head>
<?php include_once("php_includes/head.php"); ?>
  </head>
  <body>
    <div id="templatemo_wrapper">
      <?php include_once("php_includes/template_pageTop.php"); ?>
      <div id="templatemo_main">

        <div class="col_w900">
          <div class="col_allw280 fp_service_box">
            <div class="con_tit_02">Web Design</div>
            <img src="images/onebit_08.png" alt="Image 08" />
            <p>Credit goes to <a href="http://www.icojoy.com" target="_blank">icojoy.com</a> for Onebit icons #2 used in this template. Etiam vel elit massa, sit amet.</p>
            <a class="more" href="#">Detail</a>
          </div>
          <div class="col_allw280 fp_service_box">
            <div class="con_tit_02">Advertising Media</div>
            <img src="images/onebit_15.png" alt="Image 05" />
            <p>Fusce quis felis in dolor tincidunt accumsan. Curabitur dignissim pharetra sollicitudin.</p>
            <a class="more" href="#">Detail</a>
          </div>
          <div class="col_allw280 fp_service_box col_last">
            <div class="con_tit_02">Online Marketing</div>
            <img src="images/onebit_16.png" alt="Image 06" />
            <p>Curabitur sed lectus id erat viverra consectetur nec in sapien. Morbi at justo justo, eu suscipit felis.</p>
            <a class="more" href="#">Detail</a>
          </div>
          <div class="cleaner h60"></div>
          <div class="col_allw280 fp_service_box">
            <div class="con_tit_02">Customer Services</div>
            <img src="images/onebit_17.png" alt="Image 01" />
            <p>Quisque quis leo sit amet dui elementum. Lorem ipsum dolor sit amet, consectetur arcu elit.</p>
            <a class="more" href="#">Detail</a>
          </div>
          <div class="col_allw280 fp_service_box">
            <div class="con_tit_02">Java Training</div>
            <img src="images/onebit_18.png" alt="Image 02" />
            <p>Morbi pretium metus a tellus molestie id porttitor erat pulvinar. Nullam interdum ante felis.</p>
            <a class="more" href="#">Detail</a>
          </div>
          <div class="col_allw280 fp_service_box col_last">
            <div class="con_tit_02">Global Reaching</div>
            <img src="images/onebit_19.png" alt="Image 03" />
            <p>Suspendisse metus felis, varius at euismod eu, egestas eu elit ante ipsum primis in orci luctus.</p>
            <a class="more" href="#">Detail</a>
          </div>

          <div class="cleaner"></div>
        </div>

        <div class="col_w900  col_w900_last">
          <div class="con_tit_01">Introducing Aquatic Theme</div>
          <img src="images/templatemo_image_01.png" alt="Image 01" class="image_wrapper image_fl" />
          <p><em>Curabitur vestibulum ultricies nibh, sed faucibus magna semper at. Ut eget justo dolor, id porta augue. Sed mollis orci eu justo sagittis at hendrerit erat tempus.</em></p>
          <p><a href="http://www.templatemo.com/">Aquatic</a> is free css template provided by <a href="http://www.templatemo.com/">templatemo.com</a> for your personal or commercial websites. Credits go to <a href="http://www.photovaco.com/" target="_blank">Free Photos</a> for photos and <a href="http://www.brushking.eu/361/abstract-brush-pack-vol-7.html" target="_blank">Forty-winks</a> for brush. Quisque in diam a justo condimentum molestie. Vivamus leo velit, convallis id, ultrices sit amet, tempor a, libero. Quisque rhoncus nulla quis sem. Mauris quis nulla sed ipsum pretium sagittis. Suspendisse feugiat. Ut sodales libero ut odio. Maecenas venenatis metus eu est. In sed risus ac felis varius bibendum. Nulla imperdiet congue metus. Validate <a href="http://validator.w3.org/check?uri=referer" rel="nofollow"><strong>XHTML</strong></a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer" rel="nofollow"><strong>CSS</strong></a>.</p>	
          <div class="cleaner"></div>
        </div>    

        <div class="cleaner"></div>
      </div> <!-- end of main -->

    </div>
     <?php include_once("php_includes/template_pageBottom.php"); ?>
  </body>
</html>
