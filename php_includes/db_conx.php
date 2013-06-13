<?php
$db_conx = mysqli_connect("localhost", "root", "", "bdd_hsvp_rc");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}
?>