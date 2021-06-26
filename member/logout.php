<?php
include("../db.php");
$url = $base_url . "/member/login.php";
if (!is_loggedin()) {
   header("location:$url");
    exit();
}
$session_id = $_COOKIE['session_id'];
mysqli_query($conn,"DELETE FROM $login_session_tbl WHERE session_id = '$session_id' ");
setcookie('session_id', '', time() - (86400 * 30), '/');
header("location:$url");
