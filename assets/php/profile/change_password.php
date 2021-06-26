<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}

if (!isset($_POST['current_password'],$_POST['new_password'],$_POST['confirm_password'])) {
    echo "Something is missing";
   exit();
}



$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if (is_empty($current_password)) {
    echo "Current Password is required";
    exit();
}
if (is_empty($new_password)) {
    echo "New Password is required";
    exit();
}
if (is_empty($confirm_password)) {
    echo "Confirm Password is required";
    exit();
}

$query = mysqli_query($conn,"SELECT * FROM $users_tbl WHERE user_id = '$loggedin_user_id' ");
$data = mysqli_fetch_array($query);
$db_password = $data['user_password'];


$pass_decode = password_verify($current_password, $db_password);
if (!$pass_decode) {
    echo "Current password is not matching";
   exit();
}

if ($new_password != $confirm_password) {
    echo "New passwords are not matching";
    exit();
}

$new_password = password_hash($new_password, PASSWORD_BCRYPT);
$query = mysqli_query($conn,"UPDATE $users_tbl SET user_password = '$new_password' WHERE user_id = '$loggedin_user_id' ");
if (!$query) {
    echo "Something went wrong";
    exit();
}

    include("send_email.php");
    send_change_password_successfull_email($loggedin_user_id);
   logout_with_excep($loggedin_user_id);
   echo "Password updated successfully";
