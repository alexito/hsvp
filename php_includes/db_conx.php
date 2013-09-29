<?php
$db_conx = mysqli_connect("localhost", "root", "clickcomp1598", "bdd_hsvp_rc");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}
?>