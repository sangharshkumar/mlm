<?php
include("../db.php");
include("../assets/php/functions.php");
$url = $base_url . "/admin/login.php";
if (!is_admin_loggedin()) {
    header("location:$url");
    exit();
}
$session_id = $_COOKIE['admin_session_id'];
mysqli_query($conn, "DELETE FROM $login_session_tbl WHERE session_id = '$session_id' ");
setcookie('admin_session_id', '', time() - (86400 * 30), '/');
header("location:$url");
exit();
