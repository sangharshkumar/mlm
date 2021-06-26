<?php
include("../../db.php");
include("../assets/php/functions.php");
if (!is_admin_loggedin()) {
   header("location:$base_url/admin/login.php");
    exit();
}


$user_id = $_GET['user'];
if (is_empty($user_id)) {
   header("location:$error_page");
   exit();
}

if (!is_user_id($user_id)) {
    header("location:$error_page");
    exit();
}

$session_id = new_session_id();
$valid_till_date = '';
$valid_till_date = (strtotime("+30 days", ($current_date)));
$time = time() + (86400 * 30);
setcookie('session_id', $session_id, $time, '/');
$query = mysqli_query($conn, "INSERT INTO $login_session_tbl (`user_id`, `session_id`, `loggedin_at`, `valid_till`) 
                VALUES ('$user_id','$session_id','$current_date','$valid_till_date') ");
if ($query) {
    header("location:$base_url");
    exit();
}
echo "Something went wrong";
exit();